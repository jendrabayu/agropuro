@extends('layouts.auth')

@section('title', 'Verifikasi alamat email Anda')

@section('content')

  <div class="card card-primary">
    <div class="card-header">
      <h4>Verifikasi alamat email Anda</h4>
    </div>
    <div class="card-body">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif
      @if (session('resent'))
        <div class="alert alert-success" role="alert">
          Tautan verifikasi baru telah dikirim ke alamat email Anda.
        </div>
      @endif


      Sebelum melanjutkan, periksa email Anda untuk tautan verifikasi.
      Jika Anda tidak menerima email
      <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
        @csrf
        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
          klik di sini untuk meminta dikirim ulang</button>.
      </form>
    </div>
  </div>
  <div class="mt-5 text-muted text-center">
    <a href="{{ route('login') }}">Login</a>
    <span class="bullet"></span>
    <a href="{{ route('register') }}">Register</a>
  </div>

@endsection
