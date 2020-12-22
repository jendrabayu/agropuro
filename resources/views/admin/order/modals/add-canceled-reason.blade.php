<div class="modal fade" id="add_canceled_reason_modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembatalan Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.order.order_canceled', $order->id) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Masukkan Alasan Pembatalan<code>*</code></label>
            <textarea id="canceled_reason" class="form-control h-100" name="canceled_reason" rows="5"></textarea>
            <small>Terangkan alasan kenapa Anda membatalkan pesanan ini</small>
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Batalkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
