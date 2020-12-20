@extends('layouts.dashboard')
@section('title', 'Edit Alamat')
@section('content')
  <div class="section-header">
    <h1>Edit Alamat</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('customer.order.index') }}">Pesanan</a></div>
      <div class="breadcrumb-item active"><a href="{{ route('customer.address.index') }}">Alamat</a></div>
      <div class="breadcrumb-item">Edit Alamat</div>
    </div>
  </div>
  <div class="section-body">

    <div class="row justify-content-center">
      <div class="col-lg-8">

        @include('includes.error-alert')
        @include('includes.bs-alert')

        <div class="card">
          <div class="card-header">
            <h4>Edit Alamat</h4>
            <div class="card-header-action">
              <a href="{{ route('customer.address.index') }}" class="btn btn-primary">
                <i class="fas fa-search-plus"></i>Lihat Semua</a>
            </div>
          </div>
          <div class="card-body">
            <form action="{{ route('customer.address.update', $address->id) }}" method="POST">
              @csrf
              @method('PUT')

              <div class="form-group">
                <label>Nama<code>*</code></label>
                <input type="text" class="form-control" tabindex="1" name="name" value="{{ $address->name }}">
              </div>

              <div class="form-group">
                <label>Provinsi<code>*</code></label>
                <select class="form-control select2" id="province_id" tabindex="2" name="province_id">
                  <option disabled>--Pilih Provinsi--</option>
                  @foreach ($provinces as $province_id => $name)
                    <option {{ $province_id === $address->city->province->id ? 'selected' : '' }}
                      value="{{ $province_id }}">{{ $name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Kab/Kota<code>*</code></label>
                <select class="form-control select2" id="city_id" tabindex="3" name="city_id">
                  <option selected disabled>--Pilih Kab/Kota--</option>
                  @foreach ($cities as $city_id => $name)
                    <option {{ $city_id === $address->city_id ? 'selected' : '' }} value="{{ $city_id }}">{{ $name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Kecamatan<code>*</code></label>
                <input type="text" class="form-control" tabindex="4" name="kecamatan" value="{{ $address->kecamatan }}">
              </div>

              <div class="form-group">
                <label>Kelurahan<code>*</code></label>
                <input type="text" class="form-control" tabindex="5" name="kelurahan" value="{{ $address->kelurahan }}">
              </div>

              <div class="form-group">
                <label>Telepon<code>*</code></label>
                <input type="text" class="form-control" tabindex="6" name="phone_number"
                  value="{{ $address->phone_number }}">
              </div>

              <div class="form-group">
                <label>Detail<code>*</code></label>
                <textarea class="form-control h-100" tabindex="7" name="detail" rows="5">{{ $address->detail }}</textarea>
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
        console.log(this)
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
