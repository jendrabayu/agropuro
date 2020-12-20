@extends('layouts.dashboard')

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Pesanan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.order.index') }}">Pesanan Saya</a>
      </div>
      <div class="breadcrumb-item">Detail Pesanan</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-lg-12">
        @include('includes.bs-alert')
        @include('includes.error-alert')
      </div>
    </div>

    <!-- Order status & Action for order-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            @include('admin.order.sections.status')
          </div>
        </div>
      </div>
    </div>

    <!-- Order Informastion-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Informasi Pesanan</h4>
            <div class="card-header-action">
              <a data-collapse="#order_information" class="btn btn-icon btn-info" href="#"><i
                  class="fas fa-minus"></i></a>
            </div>
          </div>
          <div class="card-body" id="order_information">
            @include('admin.order.sections.information')
          </div>
        </div>
      </div>
    </div>
    <!-- END Order Informastion-->


    <!-- Product Informastion-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4>Invoice</h4>
            <div class="card-header-action">
              <button onclick="printJS('invoiceRoot', 'html')" class="btn btn-warning btn-icon icon-left"><i
                  class="fas fa-print"></i> Cetak</button>
              <a data-collapse="#invoice-card" class="btn btn-icon btn-info" href="#"><i class="fas fa-minus"></i></a>
            </div>
          </div>
          <div class="card-body" id="invoice-card">
            @include('admin.order.sections.invoice')
          </div>
        </div>
      </div>
    </div>
    <!-- END Product Informastion-->
  </div>
  <!-- END Order status & Action for order-->
@endsection

@section('modal')
  @include('admin.order.modals.add-canceled-reason')
  @include('admin.order.modals.confirm-payment-proof')
  @include('admin.order.modals.add-tracking-code')
@endsection


@push('js')
  <script src="{{ asset('assets/modules/print.js') }}"></script>
@endpush


@push('js')
  <script>
    $(document).ready(function() {
      const btnCancelOrder = $('#btn_cancel_order');
      const btnCheckPaymentProof = $('#btn_check_payment_proof');
      const btnToCancelOrder = $('#btn_to_cancel_order');
      const btnAddTrackingCode = $('#btn_add_tracking_code');

      if (btnCancelOrder.length > 0) {
        btnCancelOrder.click(function() {
          $('#cancel_order_modal').modal('show');
        });
      }

      if (btnCheckPaymentProof.length > 0) {
        btnCheckPaymentProof.click(function() {
          $('#check_payment_proof_modal').modal('show');
        });
      }

      if (btnToCancelOrder.length > 0) {
        btnToCancelOrder.click(function() {
          $('#check_payment_proof_modal').modal('hide');
          $('#cancel_order_modal').modal('show');
        });
      }

      if (btnAddTrackingCode.length > 0) {
        btnAddTrackingCode.click(function() {
          $('#add_tracking_code_modal').modal('show');
        });
      }

      $('#cancel_order_modal').on('hidden.bs.modal', function(e) {
        $('#canceled_reason').val('');
      });

      $('#add_tracking_code_modal').on('hidden.bs.modal', function() {
        $('#tracking_code').val('');
      });

    });

  </script>
@endpush
