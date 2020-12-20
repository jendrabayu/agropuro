@extends('layouts.front')
@section('title', 'Keranjang Belanja')
@section('hero_class', 'hero-normal')
@section('content')
  @include('includes.front.breadcrumb', ['breadcrumbs' => [
  'Home' => route('home'),
  'Keranjang Belanja' => '#'
  ]])

  <section class="shoping-cart">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          @include('includes.error-alert')
          @include('includes.bs-alert')
          <div class="shoping__cart__table">
            <table>
              <thead>
                <tr>
                  <th class="shoping__product">Produk</th>
                  <th>Harga</th>
                  <th>Kuantitas</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @php
                $weightTotal = 0;
                $subtotal = 0;
                @endphp
                @foreach ($carts as $cart)
                  @php
                  $subtotal += $cart->product->harga * $cart->quantity;
                  $weightTotal += $cart->product->berat * $cart->quantity;
                  @endphp
                  <tr>
                    <td class="shoping__cart__item">
                      <img style="max-width: 110px" src="{{ Storage::url($cart->product->gambar) }}" alt="">
                      <h5 style="max-width: 450px">{{ $cart->product->nama }}
                        <p class="text-success m-0">{{ $cart->product->category->name }}</p>
                        <p class="text-info m-0">{{ $cart->product->berat / 1000 }} kg</p>
                      </h5>
                    </td>
                    <td class="shoping__cart__price">
                      {{ rupiah_format($cart->product->harga) }}
                    </td>
                    <td class="shoping__cart__qty">
                      <div class="quantity">
                        <div class="pro-qty">
                          <input type="number" data-id="{{ $cart->product->id }}" class="item_quantity"
                            value="{{ $cart->quantity }}">
                        </div>
                        <p>Stok : {{ $cart->product->stok }}</p>
                      </div>
                    </td>
                    <td class="shoping__cart__total">
                      {{ rupiah_format($cart->product->harga * $cart->quantity) }}
                    </td>
                    <td class="shoping__cart__item__close">
                      <span data-id="{{ $cart->id }}" class="icon_close btn_delete"></span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="shoping__cart__btns">
            <a href="{{ route('product.index') }}" class="primary-btn cart-btn">Lanjutkan Belanja</a>
            <a id="btn_update" href="#" class="primary-btn cart-btn cart-btn-right">
              Update Keranjang</a>
          </div>
        </div>
        <div class="col-lg-6">

        </div>
        <div class="col-lg-6">
          <div class="shoping__checkout">
            <h5>Total Keranjang</h5>
            <ul>
              <li>Berat Total <span>{{ $weightTotal / 1000 }} kg</span></li>
              <li>Subtotal <span>{{ rupiah_format($subtotal) }}</span></li>
              <li>Total <span>{{ rupiah_format($subtotal) }}</span></li>
            </ul>
            @if (check_main_address_customer())
              <a href="{{ route('checkout') }}" class="primary-btn">Checkout</a>
            @else
              <a href="{{ route('customer.address.index') }}" class="primary-btn">Atur Alamat Utama</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


@push('js')
  <script>
    $(document).ready(function() {

      axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

      $('.btn_delete').click(function() {
        const id = $(this).data('id');
        Swal.fire({
          title: 'Hapus Produk dari Keranjang?',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'Batal',
          confirmButtonText: 'Hapus'
        }).then((result) => {
          if (result.isConfirmed) {
            axios.delete(`cart/${id}`)
              .then(resp => {
                if (resp.data.success) {
                  window.location.reload();
                }
              })
              .catch(error => {
                console.log(error)
              })
          }
        });
      });

      //need product_id and quantity
      $('#btn_update').click(function(e) {
        e.preventDefault();
        $(this).attr('disabled', true);
        let data = [];
        $.each($('.item_quantity'), function(i, v) {
          data.push({
            product_id: $(v).data('id'),
            quantity: parseInt($(v).val())
          });
        });

        axios.put('cart', {
            carts: data
          })
          .then(resp => {
            if (resp.data.success) {
              window.location.reload();
            }
          })
          .catch(error => {
            console.log(error)
          });
      });
    });

  </script>
@endpush
