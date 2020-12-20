@extends('layouts.dashboard')

@section('title', 'Tambah Produk Baru')

@section('content')
  <div class="section-header">
    <h1> Tambah Produk Baru</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('admin.product.index') }}">Produk</a>
      </div>
      <div class="breadcrumb-item"> Tambah Produk Baru</div>
    </div>
  </div>
  <div class="section-body">
    <div class="row">
      <div class="col-12">
        @include('includes.bs-alert')
        @include('includes.error-alert')
        <div class="card card-primary">
          <div class="card-header">
            <h4>Tambah Produk Baru</h4>
            <div class="card-header-action">
              <a href="{{ route('admin.product.index') }}" class="btn btn-icon icon-left btn-primary"><i
                  class="fas fa-search-plus"></i> Semua Produk</a>
            </div>
          </div>
          <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Nama Produk</label>
                <div class="col-sm-12 col-md-7">
                  <input type="text" class="form-control" name="nama">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kategori</label>
                <div class="col-sm-12 col-md-7">
                  <select class="form-control selectric" name="category_id">
                    <option value="" selected disabled>--Pilih Kategori--</option>
                    @foreach ($categories as $id => $name)
                      <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi Singkat</label>
                <div class="col-sm-12 col-md-7">
                  <textarea class="form-control h-100" rows="5" name="deskripsi_singkat"></textarea>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                <div class="col-sm-12 col-md-7">
                  <textarea id="description" name="deskripsi"></textarea>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gambar</label>
                <div class="col-sm-12 col-md-7">
                  <div id="image-preview" class="image-preview">
                    <label for="image-upload" id="image-label">Choose File</label>
                    <input type="file" name="gambar" id="image-upload" />
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Stok</label>
                <div class="col-sm-12 col-md-7">
                  <input type="number" min="0" class="form-control" name="stok">
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Harga</label>
                <div class="col-sm-12 col-md-7">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <div class="input-group-text">
                        Rp
                      </div>
                    </div>
                    <input type="number" min="0" class="form-control currency" name="harga">
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Berat</label>
                <div class="col-sm-12 col-md-7">
                  <div class="input-group">
                    <input type="number" class="form-control currency" name="berat" min="0">
                    <div class="input-group-append">
                      <div class="input-group-text">
                        gram
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button value="arsipkan" class="btn btn-warning" name="action">Simpan & Arsipkan</button>
                  <button class="btn btn-primary" value="simpan" name="action">Simpan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('css')
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css') }}">
@endpush

@push('js')
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('assets/modules/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js') }}"></script>
  <script src="{{ asset('assets/modules/upload-preview/js/jquery.uploadPreview.min.js') }}"></script>
@endpush

@push('js')
  <script>
    $(document).ready(function() {

      $("select").selectric();
      $.uploadPreview({
        input_field: "#image-upload", // Default: .image-upload
        preview_box: "#image-preview", // Default: .image-preview
        label_field: "#image-label", // Default: .image-label
        label_default: "Choose File", // Default: Choose File
        label_selected: "Change File", // Default: Change File
        no_label: false, // Default: false
        success_callback: null // Default: null
      });


      $('#description').summernote({
        height: 250,
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ]
      });
    })

  </script>
@endpush
