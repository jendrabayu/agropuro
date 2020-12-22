@extends('layouts.dashboard')

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
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.order.index') }}">Pesanan Saya</a>
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
            <h5 class="text-dark">{{ $status->status_admin }}</h5>
            <div>
              @switch($status->code)
                @case('belum-bayar')
                Menunggu pembayaran dari Pembeli sebelum {{ $order->created_at->addDays(2)->isoFormat('D MMM Y H:mm') }}
                @break
                @case('perlu-dicek')
                Pembayaran perlu dicek dan dikonfirmasi
                @break
                @case('perlu-dikirim')
                Pesanan perlu dikirim
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
              @if (in_array($status->code, ['belum-bayar', 'perlu-dicek', 'perlu-dikirim']))
                <button id="btn_canceled_reason_modal" class="btn btn-primary">Batalkan Pesanan</button>
              @endif

              @if ($status->code === 'perlu-dicek')
                <button id="btn_confirm_payment_proof_modal" class="btn btn-primary">Cek & Konfirmasi Pembayaran</button>
              @endif

              @if ($status->code === 'perlu-dikirim')
                <a href="#" class="btn btn-primary" id="btn_add_tracking_code_modal">Tambah Nomor Resi Pengiriman</a>
              @endif

              @if ($status->code === 'dikirim')
                <a href="{{ route('admin.order.order_done', $order->id) }}" class="btn btn-primary">Selesaikan Pesanan</a>
              @endif

              @if (in_array($status->code, ['perlu-dikirim', 'dikirim', 'selesai']))
                <button id="btn_payment_proof" class="btn btn-primary">Pembayaran</button>
              @endif

              @if (in_array($status->code, ['dikirim', 'selesai']))
                <button id="btn_tracking_code" class="btn btn-primary">Nomor Resi</button>
              @endif
            </div>
          </div>
        </div>
        <!--END ORDER STATUS AND ACTION -->
        <!--END ORDER STATUS AND ACTION -->
        <!--END ORDER STATUS AND ACTION -->

        <!--ORDER INFORMATION -->
        <!--ORDER INFORMATION -->
        <!--ORDER INFORMATION -->
        <div class="card">
          <div class="card-header">
            <h4>Informasi Pesanan</h4>
            <div class="card-header-action">
              <a data-collapse="#order_information" class="btn btn-icon btn-info" href="#"><i
                  class="fas fa-minus"></i></a>
            </div>
          </div>
          <div class="card-body" id="order_information">
            <div class="form-row">
              <div class="form-group col-md-6 mb-2">
                <label>Pembeli</label>
                <div class="border px-3 py-2">{{ $order->user->name }}</div>
              </div>
              <div class="form-group col-md-6 mb-2">
                <label>Nomor Pesanan</label>
                <div class="border px-3 py-2">{{ $order->invoice }}</div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6 mb-2">
                <label>Tanggal Pemesanan</label>
                <div class="border px-3 py-2">{{ $order->created_at->isoFormat('dddd, D MMMM Y, HH:MM') }}</div>
              </div>
              <div class="form-group col-md-6 mb-2">
                <label>Jatuh Tempo Pembayaran</label>
                <div class="border px-3 py-2">{{ $order->created_at->addDays(2)->isoFormat('dddd, D MMMM Y, HH:MM') }}
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6 mb-2">
                <label>Alamat Pengiriman</label>
                <div class="border px-3 py-2">
                  {{ $address->name }}<br>
                  {{ $address->phone_number }}<br>
                  {{ $address->detail }} <br>
                  {{ Str::upper(sprintf('kota/kab %s, kec %s, kel %s, prov %s', $address->city->name, $address->kecamatan, $address->kelurahan, $address->city->province->name)) }}
                </div>
              </div>
              <div class="form-group col-md-6 mb-2">
                <label>Pembayaran Ke</label>
                <div class="border px-3 py-2">
                  {{ $payment_bank->nama_bank }} <br>
                  {{ $payment_bank->no_rekening }} <br>
                  {{ $payment_bank->atas_nama }}
                </div>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6 mb-2">
                <label>Pengiriman</label>
                <div class="border px-3 py-2">
                  {{ Str::upper($shipping->code) . ' ' . $shipping->service . ' Estimasi Hari: ' . $shipping->etd }} <br>
                  {{ $order_details->reduce(function ($carry, $item) {
                        return $carry + (int) $item->product->berat * (int) $item->quantity;
                    }) }} gram @ {{ rupiah_format($shipping->cost) }}
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--END ORDER INFORMATION -->
        <!--END ORDER INFORMATION -->
        <!--END ORDER INFORMATION -->

        <!-- INVOICE -->
        <!-- INVOICE -->
        <!-- INVOICE -->
        <div class="card">
          <div class="card-header">
            <h4></h4>
            <div class="card-header-action">
              <button onclick="printJS('invoiceRoot', 'html')" class="btn btn-warning btn-icon icon-left"><i
                  class="fas fa-print"></i> Cetak</button>
              <a data-collapse="#invoice-card" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
            </div>
          </div>
          <div class="card-body" id="invoice-card">
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
        <!-- End INVOICE -->
        <!-- End INVOICE -->
        <!-- End INVOICE -->
        <!-- End INVOICE -->
      </div>
    </div>
  </div>
@endsection

@section('modal')
  @include('admin.order.modals.add-canceled-reason')
  @include('admin.order.modals.confirm-payment-proof')
  @include('admin.order.modals.payment-proof')
  @include('admin.order.modals.add-tracking-code')
  @include('admin.order.modals.tracking-code')
@endsection

@push('js')
  <script src="{{ asset('assets/modules/print.js') }}"></script>
  <script>
    $(function() {

      $('#btn_to_canceled_reason_modal').click(function() {
        $('#confirm_payment_proof_modal').modal('hide');
        $('#add_canceled_reason_modal').modal('show');
      });

      $('#btn_canceled_reason_modal').click(function() {
        $('#add_canceled_reason_modal').modal('show');
      });

      $('#btn_confirm_payment_proof_modal').click(function() {
        $('#confirm_payment_proof_modal').modal('show');
      });

      $('#btn_add_tracking_code_modal').click(function() {
        $('#add_tracking_code_modal').modal('show');
      });

      $('#btn_payment_proof').click(function() {
        $('#payment_proof_modal').modal('show')
      });

      $('#btn_tracking_code').click(function() {
        $('#tracking_code_modal').modal('show')
      });

      $('#add_canceled_reason_modal').on('hidden.bs.modal', function(e) {
        $('#canceled_reason').val('');
      });

      $('#add_tracking_code_modal').on('hidden.bs.modal', function() {
        $('#tracking_code').val('');
      });

    });

  </script>
@endpush
