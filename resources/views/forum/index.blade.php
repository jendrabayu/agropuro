@extends('forum.skeleton')


@section('content')
  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      {!! $contentTitle !!}
    </div>
    <div class="card-body">
      @include('forum.sections.forums')
      <div class="row mt-5 justify-content-center">
        <div class="col-lg-12 text-center">
          {{ $forums->appends(request()->all())->links() }}
        </div>
      </div>
    </div>
  </div>
@endsection
