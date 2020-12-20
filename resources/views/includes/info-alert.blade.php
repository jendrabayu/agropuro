@if (session('info'))
  <div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      {!! session('info') !!}
    </div>
  </div>
@endif
