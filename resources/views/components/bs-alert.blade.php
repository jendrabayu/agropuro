@if (session('status'))
  <div class="alert py-3 alert-{{ session('status')['color'] }} alert-dismissible fade show" role="alert">
    {!! session('status')['message'] !!}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
@endif
