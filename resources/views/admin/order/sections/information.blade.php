@php
$user = $order->user;
$address = $order->shipping->address;
$paymentShop = $order->payment->bankAccount;
$payment = $order->payment;
$shipping = $order->shipping;
$orderDetails = $order->orderDetails;
$status = $order->orderStatus;
@endphp


<ul class="list-group">
  <li class="list-group-item"><strong>No. Pesanan</strong><br>{{ $order->invoice }}</li>

  <li class="list-group-item"><strong>Pembeli</strong><br>
    {{ $user->name }}, {{ $user->email }}
  </li>

  <li class="list-group-item"><strong>Waktu Pesanan Dibuat</strong><br>
    {{ $order->created_at->isoFormat('dddd, D MMMM Y, HH:MM') }}
  </li>

  <li class="list-group-item"><strong>Batas Waktu Pembayaran</strong><br>
    {{ $order->created_at->addDays(2)->isoFormat('dddd, D MMMM Y, HH:MM') }}
  </li>

  <li class="list-group-item"><strong>Alamat Pengiriman</strong><br>
    {{ sprintf('%s, %s', Str::title($address->name), $address->phone_number) }} <br>
    {{ sprintf('%s, KEL. %s, KEC. %s, KAB/KOTA. %s, PROV. %s', Str::upper($address->detail), Str::upper($address->kelurahan), Str::upper($address->kecamatan), Str::upper($address->city->name), Str::upper($address->city->province->name)) }}
  </li>

  <li class="list-group-item"><strong>Informasi Jasa Kirim</strong> <br>
    {{ Str::upper($shipping->code) }} <br>
    {{ 'Service: ' . $shipping->service . ' Etd: ' . $shipping->etd }}
  </li>

  <li class="list-group-item"><strong>Informasi Berat Total</strong> <br>
    @php
    $beratTotal = 0;
    foreach ($order->orderDetails as $od) {
    $beratTotal += $od->product->berat;
    }
    @endphp
    {{ $beratTotal }} gram / {{ $beratTotal / 1000 }} kg
  </li>

  <li class="list-group-item"><strong>Informasi Pembayaran</strong><br>
    Transfer ke Bank {{ $paymentShop->nama_bank }}
    <strong class="text-dark">{{ $paymentShop->no_rekening }}</strong>
    A.n. {{ $paymentShop->atas_nama }}
  </li>
</ul>
