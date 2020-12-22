@extends('layouts.app-skeleton')


@section('section_header')
  <h1>Penjadwalan Tanam</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      {{-- <a href="{{ route('forum.index') }}">Forum</a> --}}
    </div>
    {{-- <div class="breadcrumb-item">{!! $contentTitle !!}</div>
    --}}
  </div>
@endsection

@section('app')
  <div class="row">
    <div class="col-lg-12">
      @include('includes.error-alert')
      @include('includes.bs-alert')
      <div class="card">
        <div class="card-header">
          <h4>Edit Aktivitas</h4>
          <div class="card-header-action">
            <a href="{{ route('plantingschedule.index') }}" class="btn btn-icon icon-left btn-primary"><i
                class=" fas fa-search-plus"></i> Semua
              Penjadwalan</a>
          </div>
        </div>
        <div class="card-body">
          <form action="{{ route('plantingscheduledetail.update', $activity->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="">Nama Aktivitas</label>
              <input type="text" class="form-control" name="activity" value="{{ $activity->activity }}">
            </div>

            <div class="form-group">
              <label>Keterangan</label>
              <textarea name="information" id="information">{{ $activity->information }}</textarea>
            </div>

            <div class="form-group">
              <label for="">Tanggal</label>
              <a href="javascript:;" class="btn btn-light icon-left btn-icon d-block" id="btn_datepicker"><i
                  class="fas fa-calendar"></i>Tanggal <span></span></a>
              <input type="hidden" name="date" value="{{ $activity->date->format('Y-m-d') }}">
              <small id="passwordHelpBlock" class="form-text text-muted">
                Masukkan Tanggal antara {{ $schedule->start_at->isoFormat('dddd, D MMMM Y') }} -
                {{ $schedule->end_at->isoFormat('dddd, D MMMM Y') }}
              </small>
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
    $(function() {
      $('#btn_datepicker span').html("{{ $activity->date->format('Y-m-d') }}");
      $('#btn_datepicker').daterangepicker({
        opens: 'right',
        drops: 'up',
        singleDatePicker: true,
        minDate: moment("{{ $schedule->start_at }}"),
        maxDate: moment("{{ $schedule->end_at }}"),
        startDate: moment("{{ $activity->date }}"),
        endDate: moment("{{ $schedule->end_at }}"),
      }, function(start) {
        $('#btn_datepicker span').html(start.format('YYYY-MM-DD'));
        $('input[name=date]').val(start.format('YYYY-MM-DD'));
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
