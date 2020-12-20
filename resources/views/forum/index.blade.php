@extends('forum.skeleton')

@section('section_header')
  <h1>Forum</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="{{ route('forum.index') }}">Forum</a>
    </div>
  </div>
@endsection

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
