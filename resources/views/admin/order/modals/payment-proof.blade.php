<div class="modal fade" id="payment_proof_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
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

      </div>
    </div>
  </div>
</div>
