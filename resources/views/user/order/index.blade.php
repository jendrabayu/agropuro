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
                  href="{{ route('customer.order.index') }}">Semua</a>
              </li>
              @foreach ($orderStatus as $status)
                <li class="nav-item">
                  <a class="nav-link {{ request()->type === $status->code ? 'active' : '' }}"
                    href="{{ route('customer.order.index', ['type' => $status->code]) }}">{{ $status->status_user }}</a>
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h4>{{ $orders->count() }} Pesanan</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped w-100 ">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Invoice</th>
                    <th>Produk</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Jasa Kirim</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $index => $order)
                    <tr>
                      <th>{{ $index + $orders->firstItem() }}</th>
                      <th>{{ $order->invoice }}</th>
                      <th>
                        @foreach ($order->orderDetails as $item)
                          <div class="d-flex justify-content-between">
                            <div class="font-weight-normal">{{ $item->product->nama }}</div>
                            <div>x{{ $item->quantity }} </div>
                          </div>
                        @endforeach
                      </th>
                      <th>
                        {{ rupiah_format($order->subtotal + $order->shipping->cost) }}
                      </th>
                      <th>
                        {{ $order->orderStatus->status_user }}
                      </th>
                      <th>
                        {{ Str::upper($order->shipping->code) }}
                      </th>
                      <th class="align-middle">
                        <a href="{{ route('customer.order.show', [$order->id, $order->invoice]) }}"
                          class="badge badge-info icon-left">Lihat Rincian
                          <i class="fas fa-search-plus"></i>
                        </a>
                      </th>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer">
            <div class="float-right">
              {{ $orders->appends(request()->input())->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
  <style>
    tr th {
      font-weight: normal;
    }

  </style>
@endpush
