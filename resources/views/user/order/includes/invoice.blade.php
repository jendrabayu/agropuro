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
              {{ $address->name }}<br>
              {{ $address->phone_number }}<br>
              {{ $address->detail }}<br>
              {{ sprintf('KEL. %s, KEC. %s, KAB/KOTA. %s, PROV. %s', Str::upper($address->kelurahan), Str::upper($address->kecamatan), Str::upper($address->city->name), Str::upper($address->city->province->name)) }}
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
              @php $status = $order->orderStatus; @endphp
              @if (!$status->code == 'belum-bayar' || !$status->code == 'perlu-dicek')
                Pembayaran Berhasil Dikonfirmasi, Pada {{ $order->payment->confirmed_at }}
              @endif

              @if ($status->code == 'belum-bayar')
                Pembayaran belum dilakukan
              @endif

            </p>
            <div class="section-title">Jasa Kirim</div>
            <p class="section-lead">
              {{ Str::upper($order->shipping->code) }} <br>
              {{ $order->shipping->service }} <br>
              Estimasi : {{ $order->shipping->etd }} <br>
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
