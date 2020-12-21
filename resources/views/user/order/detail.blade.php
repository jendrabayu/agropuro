@extends('layouts.dashboard')
@section('title', 'Detail Pesanan')
  @push('css')
    <style>
      #table_order_items tr th {
        font-weight: normal;
      }

    </style>
  @endpush

@section('content')

  @php
  $status = $order->orderStatus;
  $payment = $order->payment;
  $payment_bank = $order->payment->bankAccount;
  $shipping = $order->shipping;
  $address = $order->shipping->address;
  $order_details = $order->orderDetails;
  @endphp

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

        <!--ORDER STATUS AND ACTION -->
        <!--ORDER STATUS AND ACTION -->
        <!--ORDER STATUS AND ACTION -->
        <div class="card">
          <div class="card-body">
            <h5 class="text-dark">{{ $status->status_user }}</h5>
            <div>
              @switch($status->code)
                @case('belum-bayar')
                Menunggu pembayaran sebelum {{ $order->created_at->addDays(2)->isoFormat('dddd, D MMMM Y H:mm') }}
                @break
                @case('perlu-dicek')
                Pembayaran sedang dicek
                @break
                @case('perlu-dikirim')
                Pembayaran berhasil dikonfirmasi Pada {{ $payment->confirmed_at->isoFormat('dddd, D MMMM Y H:mm') }}
                @break
                @case('dikirim')
                Pesanan dalam proses pengiriman
                @break
                @case('selesai')
                Pesanan sudah diterima
                @break
                @case('dibatalkan')
                Alasan pembatalan: {{ $order->canceled_reason }}
                @break
                @default
              @endswitch
            </div>

            <div class="btn-group mt-3" role="group" aria-label="Basic example">
              @if ($status->code === 'belum-bayar')
                <button type="button" class="btn btn-primary" id="btn_upload_payment_proof">Upload Bukti
                  Pembayaran</button>
              @endif
              @if (!in_array($status->code, ['belum-bayar', 'dibatalkan']))
                <button type="button" class="btn btn-primary" id="payment_proof">Pembayaran Anda</button>
              @endif
              @if (in_array($status->code, ['dikirim', 'selesai']))
                <button type="button" class="btn btn-primary" id="tracking_code">Resi Pengiriman</button>
              @endif
              @if ($status->code === 'dikirim')
                <a href="{{ route('customer.order.is_done', $order->id) }}" class="btn btn-primary">Konfirmasi Pesanan
                  Sudah Diterima</a>
              @endif
            </div>

          </div>
        </div>
        <!--END ORDER STATUS AND ACTION -->
        <!--END ORDER STATUS AND ACTION -->
        <!--END ORDER STATUS AND ACTION -->

        <!--INVOICE -->
        <!--INVOICE -->
        <!--INVOICE -->
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
                          <strong>Dikirim Ke:</strong><br>
                          {{ "{$address->name} ( {$address->phone_number} )" }}<br>
                          {{ $address->detail }} <br>
                          {{ Str::upper(sprintf('kota/kab %s, kec %s, kel %s, prov %s', $address->city->name, $address->kecamatan, $address->kelurahan, $address->city->province->name)) }}
                        </address>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <address>
                          <strong>Pembayaran Ke:</strong><br>
                          Bank {{ $payment_bank->nama_bank }} <br>
                          No. Rekening: {{ $payment_bank->no_rekening }}<br>
                          a.n. {{ $payment_bank->atas_nama }}
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
                      <table class="table table-striped table-hover table-bordered" id="table_order_items">
                        <thead>
                          <tr>
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Kuantitas</th>
                            <th>Total</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($order_details as $item)
                            <tr>
                              <th><img class="img-fluid m-2" width="50" src="{{ Storage::url($item->product->gambar) }}">
                              </th>
                              <th>{{ $item->product->nama }}</th>
                              <th>{{ rupiah_format($item->price) }}</th>
                              <th>{{ $item->quantity }}</th>
                              <th>{{ rupiah_format($item->price * $item->quantity) }}</th>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="row mt-4">
                      <div class="col-lg-8">
                        <div class="section-title">Status Pembayaran</div>
                        <p class="section-lead">
                          @if (in_array($status->code, ['perlu-dikirim', 'dikirim', 'selesai']))
                            Pembayaran berhasil dikonfirmasi, Pada
                            {{ $order->payment->confirmed_at->isoFormat('dddd, D MMMM Y, HH:MM') }}
                          @endif
                          @if ($status->code === 'belum-bayar')
                            Belum Bayar
                          @endif
                          @if (in_array($status->code, ['perlu-dicek', 'dibatalkan']))
                            &mdash;
                          @endif
                        </p>
                        <div class="section-title">Pengiriman</div>
                        <p class="section-lead">
                          {{ Str::upper($shipping->code) . ' ' . $shipping->service . ' Estimasi: ' . $shipping->etd }}
                        </p>
                      </div>
                      <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal</div>
                          <div class="invoice-detail-value"> {{ rupiah_format($order->subtotal) }}</div>
                        </div>
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Subtotal Pengiriman</div>
                          <div class="invoice-detail-value">{{ rupiah_format($shipping->cost) }}</div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                          <div class="invoice-detail-name">Total</div>
                          <div class="invoice-detail-value invoice-detail-value-lg">
                            {{ rupiah_format($order->subtotal + $shipping->cost) }}
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
        <!--END INVOICE -->
        <!--END INVOICE -->
        <!--END INVOICE -->
      </div>
    </div>
  </div>
@endsection

@section('modal')
  @if ($status->code === 'belum-bayar')
    @include('user.order.modals.add-payment-proof')
  @endif
  @if (!in_array($status->code, ['belum-bayar', 'dibatalkan']))
    @include('user.order.modals.payment-proof')
  @endif
  @if (in_array($status->code, ['dikirim', 'selesai']))
    @include('user.order.modals.tracking-code')
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

      $('#payment_proof').click(function() {
        $('#modal_payment_proof').modal('show');
      });
      $('#tracking_code').click(function() {
        $('#modal_tracking_code').modal('show');
      });

      $('#btn-upload-nanti').click(function() {
        new URLSearchParams().delete('upload-bukti-transfer')
        console.log(params.delete('upload-bukti-transfer'))
      });
    });

  </script>
@endpush
