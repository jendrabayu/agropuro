@extends('layouts.dashboard')

@section('title', 'Atur Alamat Toko')

@section('content')
  <div class="section-header">
    <h1>Atur Alamat Toko</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item">Atur Alamat Toko</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row justify-content-center">
      <div class="col-lg-8">

        @include('includes.bs-alert')
        @include('includes.error-alert')

        <div class="card">
          <div class="card-header">
            <h5>Atur Alamat Toko</h5>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.shop-address.update', $address->id) }}" method="post">
              @csrf
              @method('PUT')
              <div class="form-group">
                <label>Provinsi <code>*</code></label>
                <select class="form-control select2" id="province_id" name="province_id">
                  <option value="" disabled>--Pilih Provinsi</option>
                  @foreach ($provinces as $id => $name)
                    <option @if ($id === $address->city->province_id)
                      selected
                  @endif value="{{ $id }}">{{ $name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Kabupaten/Kota <code>*</code></label>
                <select class="form-control select2" id="city_id" name="city_id">
                  @foreach ($cities as $city)
                    <option @if ($city->city_id == $address->city_id)
                      selected
                  @endif value="{{ $city->city_id }}">{{ $city->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group">
                <label>Kecamatan <code>*</code></label>
                <input type="text" class="form-control" name="kecamatan" value="{{ $address->kecamatan }}">

              </div>
              <div class="form-group">
                <label>Kelurahan <code>*</code></label>
                <input type="text" class="form-control" name="kelurahan" value="{{ $address->kelurahan }}">

              </div>
              <div class="form-group">
                <label>Nomor telepon <code>*</code></label>
                <input type="tel" class="form-control" name="phone_number" value="{{ $address->phone_number }}">

              </div>
              <div class="form-group">
                <label>Detail <code>*</code></label>
                <textarea class="form-control h-100" rows="5" name="detail">
                {{ $address->detail }}
                </textarea>

              </div>
              <div class="form-group text-right">
                <a href="{{ url()->previous() }}" class="btn btn-warning mr-1">Kembali</a>
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
