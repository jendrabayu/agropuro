@php
$bank = $order->payment->bankAccount;
$payment = $order->payment;
@endphp

<div class="modal fade" id="check_payment_proof_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header p-2 py-3">
        <h5 class="modal-title">Konfirmasi Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body p-2">
        <form id="form_confirm_payment_proof" action="{{ route('admin.order.payment-is-confirmed', $order->invoice) }}"
          method="POST">
          @csrf
          <div class="form-group">
            <h6 class="text-dark"><u>Transfer ke :</u></h6>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label>Atas Nama</label>
                <input type="text" class="form-control" value="{{ $bank->atas_nama }}" readonly>
              </div>
              <div class="form-group col-md-4">
                <label>Bank</label>
                <input type="text" class="form-control" value="{{ $bank->nama_bank }}" readonly>
              </div>
              <div class="form-group col-md-4">
                <label>No. Rekening</label>
                <input type="text" class="form-control" value="{{ $bank->no_rekening }}" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <h6 class="text-dark"><u>Transfer dari :</u></h6>
            <div class="form-row">
              <div class="form-group col-md-4">
                <label>Atas Nama</label>
                <input type="text" class="form-control" value="{{ $payment->name }}" readonly>
              </div>
              <div class="form-group col-md-4">
                <label>Bank</label>
                <input type="text" class="form-control" value="{{ $payment->bank }}" readonly>
              </div>
              <div class="form-group col-md-4">
                <label>No. Rekening</label>
                <input type="text" class="form-control" value="{{ $payment->account_number }}" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            @if ($order->payment->payment_proof)
              <img id="payment_proof_image" class="w-100" src="{{ asset('storage/' . $order->payment->payment_proof) }}"
                alt="payment_proof_image">

            @endif
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="form-group">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          <button id="btn_to_cancel_order" type="button" class="btn btn-danger" data-dismiss="modal">Batalkan</button>
          <button type="submit" id="btn_confirm_payment_proof" class="btn btn-primary">Konfirmasi Pembayaran</button>
          <script>
            document.getElementById('btn_confirm_payment_proof').addEventListener('click', function() {
              document.getElementById('form_confirm_payment_proof').submit();
            });

          </script>
        </div>
      </div>
    </div>
  </div>
</div>
