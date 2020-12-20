@if (session('warning'))
  <div class="alert alert-warning alert-dismissible show fade">
    <div class="alert-body">
      <button class="close" data-dismiss="alert">
        <span>&times;</span>
      </button>
      {!! session('warning') !!}
    </div>
  </div>
@endif
