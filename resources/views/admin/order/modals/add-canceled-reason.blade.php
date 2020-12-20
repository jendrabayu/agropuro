<div class="modal fade" id="cancel_order_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pembatalan Pesanan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.order.order-is-canceled', $order->invoice) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Masukkan Alasan</label>
            <textarea id="canceled_reason" class="form-control h-100" name="canceled_reason" rows="3"></textarea>
          </div>

          <div class="form-group">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-danger">Batalkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
