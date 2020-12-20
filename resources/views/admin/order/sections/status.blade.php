 @php
 $status = $order->orderStatus->code;
 @endphp

 <h5 class="text-dark">{{ $order->orderStatus->status_admin }}</h5>

 <div class="mb-3">
   @switch($order->orderStatus->code)
     @case('belum-bayar')
     Menunggu Pembayaran dari Pembeli Sebelum {{ $order->created_at->addDays(2)->isoFormat('D MMM Y H:mm') }}
     @break
     @case('perlu-dicek')
     Pembayaran Perlu Dicek dan Dikonfirmasi
     @break
     @case('perlu-dikirim')
     Pembayaran Sudah Dikonfirmasi, Pesanan Perlu Dikirim
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

 @if ($status === 'belum-bayar' || $status === 'perlu-dicek' || $status === 'perlu-dikirim')
   <span role="button" id="btn_cancel_order" class="badge badge-danger">Batalkan Pesanan</span>
 @endif

 @if ($status === 'perlu-dicek')
   <span role="button" id="btn_check_payment_proof" class="badge badge-info">Cek Bukti Pembayaran</span>
 @endif

 @if ($status === 'perlu-dikirim')
   <a href="#" class="badge badge-info" id="btn_add_tracking_code">Masukkan Nomor Resi Pengiriman</a>
 @endif

 @if ($status === 'dikirim')
   <a href="{{ route('admin.order.order-is-done', $order->invoice) }}" id="btn_order_is_done"
     class="badge badge-info">Selesaikan
     Pesanan</a>
 @endif
