<div class="modal fade" id="add_tracking_code_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Nomor Resi Pengiriman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.order.add-tracking-code', $order->invoice) }}" method="POST">
          @csrf
          <div class="form-group">
            <label>Masukkan no. resi pengiriman</label>
            <input id="tracking_code" class="form-control" name="tracking_code" />
          </div>

          <div class="form-group">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
