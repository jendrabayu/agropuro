@extends('layouts.dashboard')
@section('title', 'Detail Pesanan')

@section('content')
  <div class="section-header">
    <div class="section-header-back">
      <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Detail Pesanan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('customer.order.index') }}">Pesanan Saya</a>
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

    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            @include('user.order.sections.status')
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        @include('user.order.includes.invoice')
      </div>
    </div>
  </div>
@endsection

@section('modal')
  @if ($order->orderStatus->code === 'belum-bayar')
    @include('user.order.includes.add-payment-proof-modal')
  @endif
@endsection

@push('js')
  <script src="{{ asset('assets/modules/upload-preview/js/jquery.uploadPreview.min.js') }}"></script>
@endpush


@push('js')
  <script>
    $(document).ready(function() {
      $.uploadPreview({
        input_field: "#image-upload",
        preview_box: "#image-preview",
        label_field: "#image-label",
        label_default: "Choose File",
        label_selected: "Change File",
        no_label: false,
        success_callback: null
      });

      const params = new URLSearchParams(window.location.search);

      if (params.get('upload-bukti-transfer') && params.get('upload-bukti-transfer') == 'show') {
        $('#modal_add_payment_proof').modal('show');
      }

      $('#btn_upload_payment_proof').click(function() {
        $('#modal_add_payment_proof').modal('show');
      });

      $('#btn-upload-nanti').click(function() {
        new URLSearchParams().delete('upload-bukti-transfer')
        console.log(params.delete('upload-bukti-transfer'))
      });
    });

  </script>
@endpush
