@extends('layouts.front')
@section('title', 'Checkout')
@section('hero_class', 'hero-normal')
@section('content')
  @include('includes.front.breadcrumb', ['breadcrumbs' => [
  'Home' => route('home'),
  'Checkout' => '#'
  ]])


  <!-- Checkout Section -->
  <section class="checkout spad">
    <div class="container">
      <div class="checkout__form">
        <h4>Rincian Pesanan</h4>
        <form action="#">
          <div class="row">
            <div class="col-lg-6 col-md-6">
              <div class="card mb-3">
                <div class="row no-gutters">
                  <div class="col-lg-9">
                    <div class="card-body">
                      <h5 class="card-title font-weight-bold">Alamat Pengiriman</h5>
                      <p class="m-0 font-weight-bold">{{ $address->name }}</p>
                      <p class="m-0">{{ $address->phone_number }}</p>
                      <p class="m-0">{{ $address->detail }}</p>
                      <p class="card-text">
                        {{ Str::upper(sprintf('KAB/KOTA. %s, KEC. %s, KEL. %s, PROV. %s ', $address->city->name, $address->kecamatan, $address->kelurahan, $address->city->province->name)) }}
                      </p>
                    </div>
                  </div>
                  <div class="col-lg-3">
                    <div class="d-flex justify-content-center align-items-center w-100 h-100 flex-column">
                      <p class="text-success font-weight-bold">UTAMA</p>
                      <a href="{{ route('customer.address.index') }}" class="btn btn-secondary btn-sm">Atur Alamat</a>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card mb-3">
                <div class="row no-gutters">
                  <div class="col-lg-12">
                    <div class="card-body">
                      <h5 class="card-title font-weight-bold">Ongkos Kirim ({{ $weight / 1000 }}Kg)</h5>
                      <ul class="list-group">
                        @foreach ($costs as $ongkir)
                          <li class="list-group-item">
                            <p>{{ $ongkir['name'] }}</p>
                            <div>
                              @foreach ($ongkir['costs'] as $cost)
                                <div class="custom-control custom-radio">
                                  @php
                                  $idOngkir = sprintf('%s|%s|%s|%s', $ongkir['code'], $cost['service'],
                                  $cost['cost'][0]['value'], $cost['cost'][0]['etd']);
                                  @endphp
                                  <input type="radio" name="ongkir" id="{{ $idOngkir }}" value="{{ $idOngkir }}"
                                    class="custom-control-input">
                                  <label class="custom-control-label" for="{{ $idOngkir }}">
                                    @php
                                    $service = $cost['service'];
                                    $desc = $cost['description'];
                                    $day = $cost['cost'][0]['etd'];
                                    $price = rupiah_format($cost['cost'][0]['value']);
                                    @endphp
                                    {{ "$service ($desc), Estimasi: $day Hari" }}
                                    &#8212;
                                    <strong>{{ $price }}</strong>
                                  </label>
                                </div>
                              @endforeach
                            </div>
                          </li>
                        @endforeach
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="checkout__input">
                <p>Pesan</p>
                <textarea id="message" class="form-control" name="message" id="" rows="5"></textarea>
              </div>
            </div>
            <div class="col-lg-6 col-md-7">
              <div class="checkout__order">
                <h4>Detail Order</h4>
                <div class="checkout__order__products">Produk <span>Total</span></div>
                <ul>
                  @foreach ($carts as $cart)
                    @php
                    $total = $cart->product->harga * $cart->quantity;
                    @endphp
                    <li>{{ $cart->product->nama }} <strong>X
                        {{ $cart->quantity }}</strong> <span>{{ rupiah_format($total) }}</span>
                    </li>
                  @endforeach
                </ul>

                <!-- Subtotal pesanan -->
                <div class="checkout__order__subtotal">Subtotal<span id="sub_total"></span></div>
                <!-- End subtotal pesanan -->

                <!-- Subtotal ongkir-->
                <div class="checkout__order__subtotal">Ongkir<span id="ongkir_cost"></span></div>
                <!-- Subtotal ongkir-->

                <!-- Total -->
                <div class="checkout__order__total">Total<span id="total"></span></div>
                <!-- End total -->

                <div class="py-2">
                  <h5 class="mb-3 text-dark">Pilihan Pembayaran : </h5>

                  @foreach ($bankAccounts as $account)
                    <div class="custom-control custom-radio mb-3">
                      <input type="radio" id="bank_{{ $account->id }}" name="bank" class="custom-control-input"
                        value="{{ $account->id }}">
                      <label class="custom-control-label" for="bank_{{ $account->id }}">{{ $account->nama_bank }} &#8212;
                        <strong>{{ $account->no_rekening }}</strong> </label>
                    </div>
                  @endforeach
                </div>

                <button id="btn_create_order" type="button" class="site-btn">Buat Pesanan</button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <!-- Checkout Section End -->
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');
      let ongkirCost = 0;
      let data = {
        order: {
          subTotal: Number('{{ $subTotal }}'),
          message: ''
        },
        shipping: {
          address_id: '{{ $address->id }}',
          code: '',
          service: '',
          cost: '',
          etd: ''
        },
        payment: {
          bank_account_id: ''
        }
      };

      $('#sub_total').text(formatRupiah(data.order.subTotal));
      $('#total').text(formatRupiah(data.order.subTotal + ongkirCost));
      $('#ongkir_cost').text(formatRupiah(ongkirCost));

      $('input[name="ongkir"]').change(function() {
        let cost = $(this).val();
        ongkirCost = Number(cost.split('|')[2]);
        $('#ongkir_cost').text(formatRupiah(ongkirCost));
        $('#total').text(formatRupiah(data.order.subTotal + ongkirCost));
      });

      $('#btn_create_order').click(function() {


        if (!$('input[name=ongkir]:checked').length > 0) {
          Swal.fire({
            titleText: 'Anda belum memilih jasa kirim!',
            icon: 'warning',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#833030'
          })
          return;
        }

        if (!$('input[name=bank]:checked').length > 0) {
          Swal.fire({
            titleText: 'Anda belum memilih opsi pembayaran!',
            icon: 'warning',
            confirmButtonText: 'Tutup',
            confirmButtonColor: '#833030'
          })
          return;
        }

        showLoading(true);
        $(this).prop('disabled', true);

        //set data
        data.order.message = $('textarea[name=message]').val();
        data.payment.bank_account_id = $('input[name=bank]:checked').val();
        const shipping = $('input[name=ongkir]:checked').val().split('|');
        data.shipping.code = shipping[0];
        data.shipping.service = shipping[1];
        data.shipping.cost = shipping[2];
        data.shipping.etd = shipping[3];

        console.log(data)

        axios.post("{{ route('customer.order.store') }}", data)
          .then(resp => {
            window.location.href = resp.data.href;
          })
          .catch(error => {
            $(this).prop('disabled', false);
            console.log(error)
          })
      });

      function formatRupiah(angka) {
        let reverse = angka.toString().split('').reverse().join('');
        ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp. ' + ribuan;
      }

      function showLoading(loading) {
        if (typeof loading === 'boolean') {
          if (loading === true) {
            Swal.fire({
              title: 'Tunggu Sebentar...',
              allowOutsideClick: false,
              showConfirmButton: false,
              willOpen: function() {
                Swal.showLoading();
              },
            });
          } else if (loading === false) {
            Swal.close();
          }
        }

      }

    });

  </script>
@endpush
