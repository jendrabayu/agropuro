@extends('layouts.dashboard')
@section('title', 'Pesanan Saya')

@section('content')
  <div class="section-header">
    <h1>Pesanan Saya</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Pesanan Saya</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card mb-0">
          <div class="card-body">
            <ul class="nav nav-pills">
              <li class="nav-item">
                <a class="nav-link {{ request()->type == null ? 'active' : '' }}"
                  href="{{ route('admin.order.index') }}">Semua</a>
              </li>
              @foreach ($orderStatus as $status)
                <li class="nav-item">
                  <a class="nav-link {{ request()->type === $status->code ? 'active' : '' }}"
                    href="{{ route('admin.order.index', ['type' => $status->code]) }}">{{ $status->status_admin }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              {{ $dataTable->table(['class' => 'table table-striped w-100  table-bordered']) }}
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
