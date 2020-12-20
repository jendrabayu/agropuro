<div class="modal fade show" tabindex="-1" role="dialog" id="modal_tracking_code">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Informasi Pengiriman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Kurir</label>
          <input type="text" class="form-control" tabindex="1" value="{{ $shipping->code }}" readonly
            aria-readonly="true">
        </div>
        <div class="form-group">
          <label>Service</label>
          <input type="text" class="form-control" tabindex="1" value="{{ $shipping->service }}" readonly
            aria-readonly="true">
        </div>
        <div class="form-group">
          <label>Estimasi Tiba</label>
          <input type="text" class="form-control" tabindex="1" value="{{ $shipping->etd }}" readonly
            aria-readonly="true">
        </div>
        <div class="form-group">
          <label>Nomor Resi Pengiriman</label>
          <input type="text" class="form-control" tabindex="1" value="{{ $shipping->tracking_code }}" readonly
            aria-readonly="true">
        </div>
      </div>
    </div>
  </div>
</div>
