<div class="modal fade" id="tracking_code_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Nomor Resi Pengiriman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.order.update_tracking_code', $order->id) }}" method="post">
          @csrf
          @method('PUT')
          <div class="form-group">
            <input name="tracking_code" class="form-control" value="{{ $shipping->tracking_code }}" />
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
            <button type="button" id="reset_tracking_code" class="btn btn-light mx-1">Reset</button>
            <button type="submit" class="btn btn-primary">Ubah & Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('js')
  <script>
    $(function() {
      $trackingCodeValue = '{{ $shipping->tracking_code }}';
      $('#reset_tracking_code').click(function() {
        $('input[name=tracking_code]').val($trackingCodeValue);
      });
    });

  </script>
@endpush
