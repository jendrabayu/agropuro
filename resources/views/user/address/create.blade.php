@extends('layouts.dashboard')
@section('title', 'Tambah Alamat Baru')

@section('content')
  <div class="section-header">
    <h1>Tambah Alamat Baru</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('customer.order.index') }}">Pesanan Saya</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('customer.address.index') }}">Alamat</a></div>
      <div class="breadcrumb-item">Tambah Alamat Baru</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        @include('includes.error-alert')
        @include('includes.bs-alert')

        <div class="card">
          <div class="card-header">
            <h4>Tambah Alamat Baru</h4>
            <div class="card-header-action">
              <a href="{{ route('customer.address.index') }}" class="btn btn-primary">
                <i class="fas fa-search-plus"></i>
                Lihat Semua
              </a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('customer.address.store') }}" method="POST">
              @csrf

              <div class="form-group">
                <label>Nama<code>*</code></label>
                <input type="text" class="form-control" autofocus tabindex="1" name="name" value="{{ old('name') }}">
              </div>

              <div class="form-group">
                <label>Provinsi<code>*</code></label>
                <select class="form-control select2" id="province_id" tabindex="2" name="province_id">
                  <option selected disabled>--Pilih Provinsi--</option>
                  @foreach ($provinces as $province_id => $name)
                    <option value="{{ $province_id }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Kab/Kota<code>*</code></label>
                <select class="form-control select2" id="city_id" tabindex="3" name="city_id">
                  <option selected disabled>--Pilih Kab/Kota--</option>
                </select>
              </div>

              <div class="form-group">
                <label>Kecamatan<code>*</code></label>
                <input type="text" class="form-control" tabindex="4" name="kecamatan" value="{{ old('kecamatan') }}">
              </div>

              <div class="form-group">
                <label>Kelurahan<code>*</code></label>
                <input type="text" class="form-control" tabindex="5" name="kelurahan" value="{{ old('kelurahan') }}">
              </div>

              <div class="form-group">
                <label>Telepon<code>*</code></label>
                <input type="text" class="form-control" tabindex="6" name="phone_number"
                  value="{{ old('phone_number') }}">
              </div>

              <div class="form-group">
                <label>Detail<code>*</code></label>
                <textarea class="form-control h-100" rows="5" tabindex="7" name="detail">{{ old('detail') }}</textarea>
              </div>

              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" value="true" class="custom-control-input" id="is_main" tabindex="8"
                    name="is_main">
                  <label class="custom-control-label" for="is_main">Jadikan Alamat Utama</label>
                </div>
              </div>

              <div class="form-group text-right">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/modules/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
@endpush

@push('js')
  <script>
    $(document).ready(function() {
      const url = "{{ url('/') }}";

      const toHtml = function(tag, value) {
        $(tag).html(value);
      }

      $('#province_id').on('change', function() {
        const provinceId = $(this).val();
        $.ajax({
          url: `${url}/customer/address/cities/${provinceId}`,
          type: 'GET',
          success: function(data) {
            let option = ' <option selected disabled>--Pilih Kab/Kota--</option>';
            if (data && data.length > 0) {
              data.forEach(function(item) {
                option += `<option value="${item.city_id}">${item.name}</option>`
              });
            }
            $('#city_id').html(option)
          }
        });
      });
    });

  </script>
@endpush
