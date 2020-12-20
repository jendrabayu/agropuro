@extends('layouts.app-skeleton')


@section('section_header')
  <h1>Detail Penjadwalan Tanam</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active">
      <a href="{{ route('plantingschedule.index') }}">Penjadwalan Tanam</a>
    </div>
    <div class="breadcrumb-item">Detail</div>

  </div>
@endsection

@section('app')
  <div class="row">
    <div class="col-lg-12">
      @include('includes.error-alert')
      @include('includes.bs-alert')
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Informasi &nbsp; &nbsp; <span class="font-weight-normal text-dark">Hari ini :
              {{ now()->isoFormat('dddd, D MMMM Y') }}</span></h4>
          <div class="card-header-action">
            <a href="" class="btn btn-danger" id="btn_delete_schedule"><i class="fas fa-trash-alt"></i> Hapus</a>

            <a href="" class="btn btn-warning"><i class="fas fa-edit"></i> Edit</a>
            <a data-collapse="#information-card-collapse" class="btn btn-icon btn-info" href="#"><i
                class="fas fa-plus"></i></a>
          </div>
        </div>
        <div class="collapse" id="information-card-collapse">
          <div class="card-body">
            <div class="form-group row mb-2">
              <label class="col-sm-2 col-form-label">Judul</label>
              <div class="col-sm-10">
                <input type="email" class="form-control-plaintext" readonly aria-readonly="true"
                  value="{{ $schedule->title }}">
              </div>
            </div>
            <div class="form-group row mb-2">
              <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
              <div class="col-sm-10">
                <input type="email" class="form-control-plaintext" readonly aria-readonly="true"
                  value="{{ $schedule->start_at->isoFormat('dddd, D MMMM Y') }}">
              </div>
            </div>
            <div class="form-group row mb-2">
              <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
              <div class="col-sm-10">
                <input type="email" class="form-control-plaintext" readonly aria-readonly="true"
                  value="{{ $schedule->end_at->isoFormat('dddd, D MMMM Y') }}">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Detail</label>
              <div class="col-sm-10 py-3">
                <div>{!! $schedule->information !!}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h4>Daftar Aktivitas</h4>
          <div class="card-header-action">
            <a class="btn btn-light"
              href="{{ route('plantingschedule.show', [$schedule->id, 'filterdate' => 'now']) }}">Hari ini</a>
            <span>
              <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                Urutkan Tanggal
              </button>
              <div class="dropdown-menu">

                <a class="dropdown-item"
                  href="{{ route('plantingschedule.show', [$schedule->id, 'orderdate' => 'desc']) }}">Terlama</a>

                <a class="dropdown-item"
                  href="{{ route('plantingschedule.show', [$schedule->id, 'orderdate' => 'asc']) }}">Terbaru</a>

              </div>
            </span>
            <button class="btn btn-icon icon-left btn-primary" data-toggle="modal" data-target="#modal_add_activity"><i
                class="fas fa-plus"></i> Tambah Aktivitas Baru</button>
          </div>
        </div>
        <div class="card-body">
          <div class="activities">
            @foreach ($activities as $activity)
              <div class="activity">
                @if ($activity->is_done)
                  <div class="activity-icon bg-success text-white shadow-primary">
                    <i class="fas fa-check"></i>
                  </div>
                @else
                  <div class="activity-icon bg-primary text-white shadow-primary">
                    <i class="fas fa-leaf"></i>
                  </div>
                @endif
                <div class="activity-detail">
                  <div class="mb-2">
                    <span class="text-job text-primary">{{ $activity->date->isoFormat('D MMMM Y') }}
                    </span>
                    @if ($activity->is_done)
                      <span class="bullet"></span>
                      <a class="text-job text-success" href="{{ route('plantingscheduledetail.is_done', [
                            'is_done' => false,
                            'id' => $activity->id,
                        ]) }}">Buka Kembali</a>

                    @else
                      <span class="bullet"></span>
                      <a class="text-job text-success" href="{{ route('plantingscheduledetail.is_done', [
                            'is_done' => true,
                            'id' => $activity->id,
                        ]) }}">Tandai Selesai</a>
                      <span class="bullet"></span>
                      <a class="text-job text-warning" data-action="" href="#">Edit</a>
                      <span class="bullet"></span>
                      <a class="text-job text-danger btn_delete_activity"
                        data-action="{{ route('plantingscheduledetail.destroy', $activity->id) }}" href="#">Hapus</a>
                    @endif
                    @if ($activity->is_done)
                      <span class="badge badge-success ml-2">Selesai</span>
                    @endif
                  </div>
                  <h6 class="text-dark m-0">{{ $activity->activity }}</h6>
                  <p>
                    {{ $activity->information }}
                  </p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>


  <form action="" method="POST" id="form_delete_activity">
    @csrf
    @method('DELETE')
  </form>

  <form action="{{ route('plantingschedule.destroy', $schedule->id) }}" method="POST" id="form_delete_schedule">
    @csrf
    @method('DELETE')
  </form>
@endsection

@section('modal')
  <!-- Modal -->
  <div class="modal fade" id="modal_add_activity" tabindex="-1" aria-labelledby="modal_add_activity" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Aktivitas Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="{{ route('plantingscheduledetail.store') }}" method="POST">
            @csrf
            <input type="hidden" name="planting_schedule_id" value="{{ $schedule->id }}">
            <div class="form-group">
              <label>Judul Aktifitas</label>
              <input type="text" name="activity" class="form-control" tabindex="1" autofocus>
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <textarea name="information" class="form-control h-100" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="">Tanggal</label>
              <a href="javascript:;" class="btn btn-light icon-left btn-icon d-block" id="btn_datepicker"><i
                  class="fas fa-calendar"></i>Tanggal <span></span></a>
              <input type="hidden" name="date">
              <small id="passwordHelpBlock" class="form-text text-muted">
                Masukkan Tanggal antara {{ $schedule->start_at->isoFormat('dddd, D MMMM Y') }} -
                {{ $schedule->end_at->isoFormat('dddd, D MMMM Y') }}
              </small>
            </div>
            <div class="form-group">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endpush

@push('js')
  <script>
    $(document).ready(function() {
      $('#btn_datepicker').daterangepicker({
        opens: 'right',
        drops: 'up',
        singleDatePicker: true,
        endDate: moment()
      }, function(start) {
        $('#btn_datepicker span').html(start.format('YYYY-MM-DD'));
        $('input[name=date]').val(start.format('YYYY-MM-DD'));
      });

      $('.btn_delete_activity').on('click', function(e) {
        e.preventDefault();
        $('#form_delete_activity').prop('action', $(this).data('action'));
        $('#form_delete_activity').submit();
      });

      $('#btn_delete_schedule').click(function(e) {
        e.preventDefault();
        $('#form_delete_schedule').submit();
      });
    });

  </script>
@endpush
