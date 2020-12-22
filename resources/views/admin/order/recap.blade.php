@extends('layouts.dashboard')

@section('content')
  <section class="section-header">
    <h1>Rekap Penjualan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Rekap Penjualan</div>
    </div>
  </section>

  <section class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Rekap Penjualan</h4>
            <div class="card-header-action">
              @php $filter = request()->get('filter') ?? null; @endphp
              <input type="hidden" name="filter" value="{{ $filter ? $filter : 'daily' }}">
              <input type="hidden" name="start_date" value="{{ today()->subMonth()->format('Y-m-d') }}">
              <input type="hidden" name="end_date" value="{{ today()->addDay(1)->format('Y-m-d') }}">
              <a href="javascript:;" class="btn btn-primary btn-datefilter icon-left btn-icon"><i
                  class="fas fa-calendar"></i> Tanggal <span></span></a>
              <a href="{{ route('admin.recap', ['filter' => 'daily']) }}"
                class="btn {{ $filter === 'daily' ? 'active' : '' }}">Harian</a>
              <a href="{{ route('admin.recap', ['filter' => 'monthly']) }}"
                class="btn {{ $filter === 'monthly' ? 'active' : '' }}">Bulanan</a>
              <a href="{{ route('admin.recap', ['filter' => 'yearly']) }}"
                class="btn {{ $filter === 'yearly' ? 'active' : '' }}"> Tahunan</a>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered w-100" id="table-recap">
                <thead>
                  <tr>
                    <th class="date_column">Tanggal</th>
                    <th class="date_column">Bulan</th>
                    <th class="date_column">Tahun</th>
                    <th>Total Pesanan</th>
                    <th>Produk Terjual</th>
                    <th>Pendapatan</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
  <style>
    .date_column {
      max-width: 20px;
    }

  </style>
@endpush

@push('js')
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/moment.min.js') }}"></script>
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
@endpush

@push('js')
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      const tableRecap = $('#table-recap').DataTable({
        ajax: {
          url: window.location.href,
          type: 'POST',
          dataSrc: "recaps",
          data: function() {
            return {
              filter: $('input[name=filter]').val(),
              start_date: $('input[name=start_date]').val(),
              end_date: $('input[name=end_date]').val()
            }
          }
        },
        ordering: false,
        columns: [{
            data: "date"
          },
          {
            data: "month"
          },
          {
            data: "year"
          },
          {
            data: "total_order"
          },
          {
            data: "products_sold"
          },
          {
            data: "income",
            render: function(income) {
              return `Rp. ${rupiahFormat(income)}`;
            }
          }
        ]
      });


      function rupiahFormat(number) {
        const reverse = number.toString().split('').reverse().join('');
        let ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return ribuan;
      }

      $('.btn-datefilter').daterangepicker({
        ranges: {
          'Hari ini': [moment(), moment()],
          'Minggu lalu': [moment().subtract(6, 'days'), moment()],
          '30 hari lalu': [moment().subtract(29, 'days'), moment()],
          'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
          'Bulan lalu': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
            'month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      }, function(start, end) {
        $('.btn-datefilter span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        $('input[name=start_date]').val(start.format('YYYY-MM-DD'));
        $('input[name=end_date]').val(end.format('YYYY-MM-DD'));
        tableRecap.ajax.reload();
      });

    });

  </script>
@endpush
