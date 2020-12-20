@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
  <div class="section-header">
    <h1>Dashboard</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item">Dashboard</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        <div class="card card-info">
          <div class="card-header">
            <div class="float-left">
              <h4>Yang Perlu Dilakukan</h4>
              <p>Hal-hal yang perlu kamu tangani</p>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-lg-3">
                <a href="{{ route('admin.order.index', ['type' => 'belum-bayar']) }}">
                  <div class="d-flex p-3 justify-content-center align-items-center flex-column border border-primary">
                    <h4 class="text-primary m-0">
                      {{ $belumBayar }}
                    </h4>
                    <p class="text-dark m-0">
                      Belum Bayar
                    </p>
                  </div>
                </a>
              </div>
              <div class="col-lg-3">
                <a href="{{ route('admin.order.index', ['type' => 'perlu-dicek']) }}">
                  <div class="d-flex p-3 justify-content-center align-items-center flex-column border border-primary">
                    <h4 class="text-primary m-0">
                      {{ $perluDicek }}
                    </h4>
                    <p class="text-dark m-0">
                      Pembayaran Perlu Dicek
                    </p>
                  </div>
                </a>
              </div>
              <div class="col-lg-3">
                <a href="{{ route('admin.order.index', ['type' => 'perlu-dikirim']) }}">
                  <div class="d-flex p-3 justify-content-center align-items-center flex-column border border-primary">
                    <h4 class="text-primary m-0">
                      {{ $perluDikirim }}
                    </h4>
                    <p class="text-dark m-0">
                      Pesanan Perlu Dikirim
                    </p>
                  </div>
                </a>
              </div>
              <div class="col-lg-3">
                <a href="{{ route('admin.order.index', ['type' => 'dikirim']) }}">
                  <div class="d-flex p-3 justify-content-center align-items-center flex-column border border-primary">
                    <h4 class="text-primary m-0">
                      {{ $dikirim }}
                    </h4>
                    <p class="text-dark m-0">
                      Pesanan Dikirim
                    </p>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-3">
      <div class="col-lg-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>10 Pesanan Terbaru</h4>
            <div class="card-header-action">
              <a href="{{ route('admin.order.index') }}" class="btn btn-primary mr-2">
                <i class="fas fa-search-plus"></i>
                Semua Pesanan
              </a>
              <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
            </div>
          </div>
          <div class="collapse show" id="mycard-collapse">
            <div class="card-body">
              <div class="table-responsive">
                {{ $dataTable->table(['class' => 'table table-striped w-100 table-bordered']) }}
              </div>
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
