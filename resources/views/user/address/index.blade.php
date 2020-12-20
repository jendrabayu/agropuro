@extends('layouts.dashboard')
@section('title', 'Tambah Alamat Baru')

@section('content')
  <div class="section-header">
    <h1>Alamat Saya</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
      <div class="breadcrumb-item">Alamat Saya</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row justify-content-center">
      <div class="col-lg-12">

        @include('includes.error-alert')
        @include('includes.bs-alert')

        <div class="card">
          <div class="card-header">
            <h4>Alamat Saya</h4>
            <div class="card-header-action">
              <a href="{{ route('customer.address.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Alamat Baru
              </a>
            </div>
          </div>
          <div class="card-body">
            @foreach ($addresses as $address)
              <div class="list-group">
                <div class="list-group-item flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="text-dark">{{ $address->name }} ({{ $address->phone_number }})</h6>
                    @if ($address->is_main === true)
                      <span class="badge badge-primary">Alamat Utama</span>
                    @endif
                  </div>
                  <span>
                    {{ $address->detail }}<br>
                    {{ Str::upper(sprintf('kota/kab %s, kec %s, kel %s, prov %s', $address->city->name, $address->kecamatan, $address->kelurahan, $address->city->province->name)) }}
                  </span>

                  <div class="d-flex justify-content-end">
                    @if ($address->is_main === false)
                      <a href="#" class="text-success btn_set_main"
                        data-url="{{ route('customer.address.setmain', $address->id) }}">Atur Sebagai Utama</a>
                      <div class="bullet"></div>
                    @endif
                    <a class="text-info" href="{{ route('customer.address.edit', $address->id) }}">Ubah</a>
                    <div class="bullet"></div>
                    <a href="#" class="text-danger btn_delete"
                      data-url="{{ route('customer.address.destroy', $address->id) }}">Hapus</a>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  <form action="" method="POST" id="form_delete" hidden>
    @csrf
    @method('DELETE')
  </form>

  <form action="" method="POST" id="form_set_main" hidden>
    @csrf
    @method('PUT')
  </form>
@endsection


@push('js')
  <script>
    $(function() {
      $('.btn_delete').click(function(e) {
        e.preventDefault();
        $('#form_delete').prop('action', $(this).data('url'));
        $('#form_delete').submit();
      });

      $('.btn_set_main').click(function(e) {
        e.preventDefault();
        $('#form_set_main').prop('action', $(this).data('url'));
        $('#form_set_main').submit();
      });
    });

  </script>
@endpush
