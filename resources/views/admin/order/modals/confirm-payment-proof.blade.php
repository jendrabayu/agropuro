<div class="modal fade" id="confirm_payment_proof_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cek & Konfirmasi Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <div class="border p-2" style="font-size: 1rem">
            Total yang harus dibayar {{ rupiah_format($order->subtotal + $shipping->cost) }},
            Ke Bank {{ $payment_bank->nama_bank }}, No. Rekening {{ $payment_bank->no_rekening }},
            Atas Nama {{ $payment_bank->atas_nama }}
          </div>
        </div>
        <form id="form_confirm_payment_proof" action="{{ route('admin.order.payment_confirmed', $order->id) }}"
          method="POST">
          @csrf
          @method('PUT')
          <div class="form-group mb-2">
            <label>Atas Nama</label>
            <input type="text" class="form-control" tabindex="1" value="{{ $payment->name }}" readonly
              aria-readonly="true">
          </div>
          <div class="form-group  mb-2">
            <label>Nama Bank</label>
            <input type="text" class="form-control" tabindex="2" value="{{ $payment->bank }}" readonly
              aria-readonly="true">
          </div>
          <div class="form-group  mb-2">
            <label>No. Rekening</label>
            <input type="text" class="form-control" tabindex="3" value="{{ $payment->account_number }}" readonly
              aria-readonly="true">
          </div>
          @if ($payment->payment_proof)
            <div class="form-group ">
              <img class="w-100" src="{{ Storage::url($payment->payment_proof) }}" alt="" srcset="">
            </div>
          @endif
          <div class="form-group">
            <small>Periksa dengan teliti, apakah Pembeli sudah mengirimkan uang ke rekening toko dengan jumlah yang
              tepat</small>
          </div>
          <div class="form-group text-right mt-4">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
            <button id="btn_to_canceled_reason_modal" type="button" class="btn btn-primary mx-1"
              data-dismiss="modal">Batalkan</button>
            <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
