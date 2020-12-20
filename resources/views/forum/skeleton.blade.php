@extends('layouts.app-skeleton')

@section('sidebar')
  @include('forum.sections.navigation')
  @include('forum.sections.categories')
@endsection


@section('app')
  <div class="row">
    <div class="col-lg-3 p-2">
      @yield('sidebar')
    </div>
    <div class="col lg-9 p-2">
      @include('includes.bs-alert')
      @include('includes.error-alert')
      @yield('content')
    </div>
  </div>

@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/select2/css/select2.min.css') }}">
  <style>
    .btn_link {
      background: none;
      border: none;
      font-size: 12px;
      outline: none;
      padding: 0;
      margin: 0;
    }

    .btn_link:hover {
      text-decoration: underline
    }

    .btn_link:hover,
    .btn_link:active,
    .btn_link:focus {
      outline: none;
      border: none;
    }

  </style>
@endpush
@push('js')
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('assets/modules/select2/js/select2.full.min.js') }}"></script>
@endpush


@push('js')
  <script>
    $(document).ready(function() {
      //https://summernote.org/deep-dive/
      $('#summernote').summernote({
        height: 250,
        placeholder: 'Tulis pertanyaan Anda disini...',
        dialogsInBody: true,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['insert', ['link', 'picture']],
          ['view', ['fullscreen']],
        ],
      });
    });

  </script>
