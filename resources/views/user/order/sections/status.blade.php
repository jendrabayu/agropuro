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
     Pembayaran Berhasil Dikonfirmasi Pada {{ $order->payment->confirmed_at->isoFormat('dddd, D MMMM Y H:mm') }} dan Akan
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
