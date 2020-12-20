@extends('layouts.dashboard-skeleton')

@section('title', 'Pengaturan Akun')

@section('app')
  <div class="container profile_setting">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        @include('includes.error-alert')
        @include('includes.info-alert')
        <form action="{{ route('accountsetting.update', $user->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="card">
            <div class="card-header">
              <h4>Pengaturan Akun</h4>
              <div class="card-header-action">

                @if (auth()->user()->role === 1)
                  <a href="{{ route('admin.dashboard') }}" class="btn btn-icon icon-left btn-outline-primary mr-2"><i
                      class="fas fa-tachometer-alt"></i>
                    Dashboard</a>
                @endif
                <a href="{{ route('home') }}" class="btn btn-icon icon-left btn-outline-primary"><i
                    class="fas fa-home"></i></i>
                  Home</a>
              </div>
            </div>
            <div class="card-body">

              <div class="form-group">
                <label>Nama</label>
                <input type="text" class="form-control" name="name" autofocus tabindex="1" value="{{ $user->name }}">
              </div>

              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" name="email" tabindex="2" value="{{ $user->email }}">
              </div>

              <div class="form-group">
                <label>Foto</label>
                <div id="image-preview" class="image-preview"
                  style="background-image: url({{ asset('storage/' . $user->photo) }});   background-size: cover;">
                  <label for="image-upload" id="image-label">Pilih Foto</label>
                  <input type="file" name="photo" id="image-upload" />
                </div>
              </div>

              <div class="form-group">
                <label>Password Baru</label>
                <input type="password" class="form-control" tabindex="3" name="password">
              </div>

              <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" class="form-control" tabindex="4" name="password_confirmation">
              </div>

              <div class="form-group text-right">
                <a href="{{ url()->previous() }}" class="btn btn-icon icon-left btn-warning mr-1">
                  Kembali</a>
                <button class="btn btn-primary">Simpan</button>
              </div>

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection

@push('css')
  <style>
    .profile_setting {
      margin: 50px auto;
    }

  </style>
@endpush

@push('js')
  <script src="{{ asset('assets/modules/upload-preview/js/jquery.uploadPreview.min.js') }}"></script>
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
    })

  </script>
@endpush
