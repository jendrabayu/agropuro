@extends('layouts.dashboard')
@section('title', 'Detail Pesanan')

@section('content')

  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Pesanan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('customer.order.index') }}">Pesanan Saya</a>
      </div>
      <div class="breadcrumb-item">Detail Pesanan</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        @include('includes.bs-alert')
        @include('includes.error-alert')
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            @php
            $status = $order->orderStatus->code;
            @endphp

            <h5 class="text-dark">{{ $order->orderStatus->status_user }}</h5>

            <div class="mb-3">
              @switch($order->orderStatus->code)
                @case('belum-bayar')
                Menunggu Pembayaran Sebelum {{ $order->created_at->addDays(2)->isoFormat('dddd, D MMMM Y H:mm') }}
                @break
                @case('perlu-dicek')
                Pembayaran Sedang Dicek
                @break
                @case('perlu-dikirim')
                Pembayaran Berhasil Dikonfirmasi Pada {{ $order->payment->confirmed_at->isoFormat('dddd, D MMMM Y H:mm') }}
                dan Akan
                Segera
                Dikirim
                @break
                @case('dikirim')
                Pesanan Dalam Pengiriman
                {{ Str::upper($order->shipping->code) . " ( {$order->shipping->service} )" }}
                <span class="font-weight-bold text-dark">NOMOR RESI: {{ $order->shipping->tracking_code }}</span>
                @break
                @case('selesai')
                Pesanan Sudah Diterima
                @break
                @case('dibatalkan')
                Alasan Pembatalan: {{ $order->canceled_reason }}
                @break
                @default
              @endswitch
            </div>

            @if ($status === 'belum-bayar')
              <span role="button" id="btn_upload_payment_proof" class="badge badge-primary">Upload Bukti Transfer</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4></h4>
            <div class="card-header-action">
              <button onclick="printJS('invoiceRoot', 'html')" class="btn btn-warning btn-icon icon-left"><i
                  class="fas fa-print"></i> Cetak</button>
            </div>
          </div>
          <div class="card-body">
            <div class="invoice" id="invoiceRoot">
              <div class="invoice-print">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="invoice-title">
                      <h3>Invoice</h3>
                      <div class="invoice-number">Pesanan #{{ $order->invoice }}</div>
                    </div>
                    <hr>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Ditagih Ke :</strong><br>
                          {{ $order->user->name }}<br>
                          {{ $order->user->email }}<br>
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          @php $address = $order->shipping->address; @endphp
                          <strong>Dikirim Ke:</strong><br>
                          {{ $address->name }} ({{ $address->phone_number }}) <br>
                          {{ $address->detail }} <br>
                          {{ Str::upper(sprintf('kota/kab %s, kec %s, kel %s, prov %s', $address->city->name, $address->kecamatan, $address->kelurahan, $address->city->province->name)) }}
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          @php $bank = $order->payment->bankAccount @endphp
                          <strong>Pembayaran Ke:</strong><br>
                          Bank {{ $bank->nama_bank }} <br>
                          No. Rekening : {{ $bank->no_rekening }} <br>
                          a.n.{{ $bank->atas_nama }}
                        </address>
                      </div>
                      <div class="col-md-6 text-md-right">
                        <address>
                          <strong>Tanggal Pemesanan:</strong><br>
                          {{ $order->created_at->isoFormat('dddd, D MMMM Y, HH:MM') }}<br><br>
                        </address>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="col-md-12">
                    <div class="section-title">Ringkasan Pesanan</div>
                    <div class="table-responsive">
                      <table class="table table-striped table-hover table-bordered table-md">
                        <tr>
                          <th data-width="40">#</th>
                          <th>Produk</th>
                          <th class="text-center">Harga Satuan</th>
                          <th class="text-center">Kuantitas</th>
                          <th class="text-center">Subtotal</th>
                        </tr>
                        @foreach ($order->orderDetails as $key => $value)
                          <tr>
                            <th>{{ $key + 1 }}</th>
                            <th>
                              <div class="row">
                                <div class="col-lg-2">
                                  <img class="img-fluid" src="{{ asset('storage/' . $value->product->gambar) }}"
                                    alt="{{ $value->product->nama }}">
                                </div>
                                <div class="col-lg-10">
                                  {{ $value->product->nama }}
                                </div>
                              </div>
                            </th>
                            <th class="text-center">
                              {{ rupiah_format($value->price) }}
                            </th>
                            <th class="text-center">
                              {{ $value->quantity }}
                            </th>
                            <th class="text-center">
                              {{ rupiah_format($value->price * $value->quantity) }}
                            </th>
                          </tr>
                        @endforeach
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Status Pembayaran</div>
                        <p class="section-lead">

                          @if (in_array($order->orderStatus->code, ['perlu-dikirim', 'dikirim', 'selesai']))
                            Pembayaran berhasil dikonfirmasi, Pada
                            {{ $order->payment->confirmed_at->isoFormat('dddd, D MMMM Y, HH:MM') }}
                          @endif

                          @if ($order->orderStatus->code === 'belum-bayar')
                            Belum Bayar
                          @endif

                          @if (in_array($order->orderStatus->code, ['perlu-dicek', 'dibatalkan']))
                            &mdash;
                          @endif

                        </p>
                        <div class="section-title">Pengiriman</div>
                        <p class="section-lead">
                          @php
                          $shipping = $order->shipping;
                          @endphp
                          {{ Str::upper($shipping->code) . $shipping->service . ' Estimasi :' . $shipping->etd }}
                        </p>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal</div>
                          <div class="invoice-detail-value"> {{ rupiah_format($order->subtotal) }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal Pengiriman</div>
                          <div class="invoice-detail-value">{{ rupiah_format($order->shipping->cost) }}</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">
                            {{ rupiah_format($order->subtotal + $order->shipping->cost) }}
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('modal')
  @if ($order->orderStatus->code === 'belum-bayar')
    @include('user.order.includes.add-payment-proof-modal')
  @endif
@endsection

@push('js')
  <script src="{{ asset('assets/modules/upload-preview/js/jquery.uploadPreview.min.js') }}"></script>
  <script src="{{ asset('assets/modules/print.js') }}"></script>
  <script>
    $(document).ready(function() {
      $.uploadPreview({
        input_field: "#image-upload",
        preview_box: "#image-preview",
        label_field: "#image-label",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,
        success_callback: null
      });

      const params = new URLSearchParams(window.location.search);

      if (params.get('upload-bukti-transfer') && params.get('upload-bukti-transfer') == 'show') {
        $('#modal_add_payment_proof').modal('show');
      }

      $('#btn_upload_payment_proof').click(function() {
        $('#modal_add_payment_proof').modal('show');
      });

      $('#btn-upload-nanti').click(function() {
        new URLSearchParams().delete('upload-bukti-transfer')
        console.log(params.delete('upload-bukti-transfer'))
      });
    });

  </script>
@endpush
