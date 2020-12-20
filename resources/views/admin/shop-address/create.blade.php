@extends('layouts.dashboard')
@section('title', 'Atur Alamat Toko Baru')

@section('content')
  <div class="section-header">
    <h1>Atur Alamat Toko Baru</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Atur Alamat Toko Baru</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        @include('includes.bs-alert')
        @include('includes.error-alert')

        <div class="card">
          <div class="card-header">
            <h4>Atur Alamat Toko Baru</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.shop-address.store') }}" method="POST">
              @csrf

              <div class="form-group">
                <label>Provinsi<code>*</code> </label>
                <select class="form-control select2" id="province_id" tabindex="1" name="province_id">
                  <option disabled selected>--Pilih Provinsi</option>
                  @foreach ($provinces as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Kabupaten/Kota <code> </label>
                <select class="form-control select2" id="city_id" tabindex="2" name="city_id">
                </select>
              </div>

              <div class="form-group">
                <label>Kecamatan <code> </label>
                <input type="text" class="form-control" tabindex="3" name="kecamatan" value="{{ old('kecamatan') }}">
              </div>

              <div class="form-group">
                <label>Kelurahan <code> </label>
                <input type="text" class="form-control" tabindex="4" name="kelurahan" value="{{ old('kelurahan') }}">
              </div>

              <div class="form-group">
                <label>Nomor telepon <code> </label>
                <input type="tel" class="form-control" tabindex="5" name="phone_number" value="{{ old('phone_number') }}">
              </div>

              <div class="form-group">
                <label>Detail <code> </label>
                <textarea rows="5" class="form-control h-100" tabindex="6" name="detail">{{ old('detail') }}</textarea>
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
        console.log(`${url}/admin/shop-address/cities/${provinceId}`)
        $.ajax({
          url: `${url}/admin/shop-address/cities/${provinceId}`,
          type: 'GET',
          success: function(data) {
            let option = '';
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
