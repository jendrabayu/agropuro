@extends('layouts.app-skeleton')

@section('section_header')
  <h1>Penjadwalan Tanam</h1>
@endsection

@section('app')
  <div class="row">
    <div class="col-lg-12">
      @include('includes.error-alert')
      @include('includes.bs-alert')
      <div class="card">
        <div class="card-header">
          <h4>Daftar Penjadwalan</h4>
          <div class="card-header-action">
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#modal_add_schedule"><i
                class="fas fa-plus"></i> Tambah Penjadwalan Baru</button>
          </div>
        </div>
        <div class="card-body">
          <ul class="list-group">
            @foreach ($schedules as $schedule)
              <li class="list-group-item">
                <div class="d-flex justify-content-between">
                  <div>
                    <span>
                      {{ $schedule->start_at->isoFormat('D MMMM Y') }} - {{ $schedule->end_at->isoFormat('D MMMM Y') }}
                      <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                      <div class="dropdown-menu">
                        <div class="dropdown-title">Opsi</div>
                        <a href="{{ route('plantingschedule.show', $schedule->id) }}" class="dropdown-item has-icon"><i
                            class="fas fa-list"></i> Detail</a>
                        <a href="{{ route('plantingschedule.edit', $schedule->id) }}" class="dropdown-item has-icon"
                          data-action=""><i class="fas fa-edit"></i> Edit</a>
                        <a href="#" class="dropdown-item has-icon text-danger btn_delete_schedule"
                          data-action="{{ route('plantingschedule.destroy', $schedule->id) }}"><i
                            class="fas fa-trash-alt"></i> Hapus</a>
                      </div>
                    </span>
                    <h6><a class="text-dark"
                        href="{{ route('plantingschedule.show', $schedule->id) }}">{{ $schedule->title }}</a></h6>
                  </div>
                  <div class="d-flex justify-content-center align-items-center bg-primary px-3 text-white">
                    <span> {{ $schedule->PlantingScheduleDetails->count() }}</span>
                    &nbsp;
                    Aktivitas
                  </div>
                </div>
              </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>

  <form action="" method="POST" id="form_delete_schedule">
    @csrf
    @method('DELETE')
  </form>
@endsection

@section('modal')
  <div class="modal fade" id="modal_add_schedule" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buat Penjadwalan Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('plantingschedule.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label>Judul</label>
              <input type="text" name="title" class="form-control" tabindex="1" autofocus>
            </div>
            <div class="form-group">
              <label for="">Rentang Tanggal</label>
              <a href="javascript:;" class="btn btn-light icon-left btn-icon d-block" id="btn_datefilter"><i
                  class="fas fa-calendar"></i>Tanggal <span></span></a>
              <input type="hidden" name="start_at">
              <input type="hidden" name="end_at">
            </div>
            <div class="form-group">
              <label>Detail</label>
              <textarea name="information" id="information"></textarea>
            </div>
            <div class="form-group text-right">
              <button type="button" class="btn btn-warning mr-1" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.min.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      $('#btn_datefilter').daterangepicker({
        opens: 'right',
        drops: 'auto',
        endDate: moment()
      }, function(start, end) {
        $('#btn_datefilter span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('input[name=start_at]').val(start.format('YYYY-MM-DD'));
        $('input[name=end_at]').val(end.format('YYYY-MM-DD'));
      });

      $('.btn_delete_schedule').on('click', function(e) {
        e.preventDefault();
        $('#form_delete_schedule').prop('action', $(this).data('action'));
        $('#form_delete_schedule').submit();
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
