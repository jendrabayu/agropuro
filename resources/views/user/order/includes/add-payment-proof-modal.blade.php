  <div class="modal fade show" data-backdrop="static" tabindex="-1" role="dialog" id="modal_add_payment_proof">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Upload Bukti Transfer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('customer.order.add-payment-proof', $order->invoice) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
              <div class="border border-warning text-dark p-3" style="font-size: 1rem">
                @php $paymentTo = $order->payment->bankAccount; @endphp
                Lakukan pembayaran ke no. rekening <strong>{{ $paymentTo->no_rekening }}</strong>
                BANK {{ $paymentTo->nama_bank }} A.n. {{ $paymentTo->atas_nama }}, Sebesar
                {{ rupiah_format($order->subtotal + $order->shipping->cost) }}
                <br>
                <span style="font-size: .8rem" class="text-danger">Batas waktu :
                  {{ Carbon\Carbon::parse($order->created_at)->addDays(2)->isoFormat('dddd, D MMMM Y, HH:mm') }}
              </div>
            </div>
            <div class="form-group">
              <label>Atas Nama <span class="text-danger">*</span></label>
              <input type="text" class="form-control" tabindex="1" name="name">
            </div>
            <div class="form-group">
              <label>Nama Bank <span class="text-danger">*</span></label>
              <input type="text" class="form-control" tabindex="2" name="bank">
            </div>
            <div class="form-group">
              <label>No. Rekening <span class="text-danger">*</span></label>
              <input type="text" class="form-control" tabindex="3" name="account_number">
            </div>
            <div class="form-group d-flex justify-content-center flex-column align-items-center">
              <label for="">Upload Bukti Transfer</label>
              <div id="image-preview" class="image-preview">
                <label for="image-upload" id="image-label">Choose File</label>
                <input type="file" name="payment_proof" id="image-upload" tabindex="4" />
              </div>
            </div>
            <div class="form-group d-flex justify-content-end">
              <button type="button" class="btn btn-danger mr-2" id="btn-upload-nanti" data-dismiss="modal">Upload
                Nanti</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
