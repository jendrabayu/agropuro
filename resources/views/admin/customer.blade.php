@extends('layouts.dashboard')

@section('title', 'Daftar Pelanggan')

@section('content')
  <div class="section-header">
    <h1>Daftar Pelanggan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item">Daftar Pelanggan</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Daftar Pelanggan (Total: {{ $total_customers }})</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              {!! $dataTable->table(['class' => 'table table-striped w-100 text-center ']) !!}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{ $dataTable->scripts() }}
@endpush
