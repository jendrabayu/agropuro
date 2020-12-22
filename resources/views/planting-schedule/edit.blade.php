@extends('layouts.app-skeleton')


@section('section_header')
  <h1>Edit Penjadwalan Tanam</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="{{ route('plantingschedule.index') }}">Penjadwalan Tanam</a>
    </div>
    <div class="breadcrumb-item">Edit Penjadwalan Tanam</div>
  </div>
@endsection

@section('app')
  <div class="row">
    <div class="col-lg-12">
      @include('includes.error-alert')
      @include('includes.bs-alert')
      <div class="card">
        <div class="card-header">
          <h4>Edit Penjadwalan Tanam</h4>
          <div class="card-header-action">
            <a href="{{ route('plantingschedule.index') }}" class="btn btn-icon icon-left btn-primary"><i
                class=" fas fa-search-plus"></i> Semua
              Penjadwalan</a>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('plantingschedule.update', $schedule->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
              <label for="">Judul</label>
              <input type="text" class="form-control" name="title" value="{{ $schedule->title }}">
            </div>

            <div class="form-group">
              <label for="">Rentang Tanggal</label>
              <a href="javascript:;" class="btn btn-light icon-left btn-icon d-block" id="btn_datefilter"><i
                  class="fas fa-calendar"></i>Tanggal <span></span></a>
              <input type="hidden" name="start_at" value="{{ $schedule->start_at }}">
              <input type="hidden" name="end_at" value="{{ $schedule->end_at }}">
              <small>
                @if ($firstDate && $lastDate)
                  Tanggal hanya boleh sebelum atau sama dengan
                  {{ $firstDate->isoFormat('dddd, D MMMM Y') }}
                  dan setelah atau sama dengan
                  {{ $lastDate->isoFormat('dddd, D MMMM Y') }}
                @endif
              </small>
            </div>
            <div class="form-group">
              <label>Detail</label>
              <textarea name="information" id="information">{{ $schedule->information }}</textarea>
            </div>
            <div class="form-group text-right">
              <a href="{{ url()->previous() }}" class="btn btn-warning mr-1">Kembali</a>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <form action="" method="POST" id="form_delete_schedule">
    @csrf
    @method('DELETE')
  </form>
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.min.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.min.js') }}"></script>
@endpush

@push('js')
  <script>
    $(document).ready(function() {
      $('#btn_datefilter span').html(
        "{{ $schedule->start_at->format('Y-m-d') . ' - ' . $schedule->end_at->format('Y-m-d') }}");
      $('#btn_datefilter').daterangepicker({
        opens: 'right',
        drops: 'auto',
        startDate: moment("{{ $schedule->start_at }}"),
        endDate: moment("{{ $schedule->end_at }}"),
      }, function(start, end) {
        $('#btn_datefilter span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('input[name=start_at]').val(start.format('YYYY-MM-DD'));
        $('input[name=end_at]').val(end.format('YYYY-MM-DD'));
      });

      $('#information').summernote({
        height: 250,
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
@endpush
