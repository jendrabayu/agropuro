@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')

  <div class="card card-primary">
    <div class="card-header">
      <h4>Lupa Password</h4>
    </div>
    <div class="card-body">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif
      <p class="text-muted">Kami akan mengirimkan tautan untuk mengatur ulang password Anda</p>
      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ old('email') }}" required autocomplete="email" tabindex="1" autofocus>

          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Lupa Password
          </button>
        </div>
      </form>
    </div>
  </div>
  <div class="mt-5 text-muted text-center">
    <a href="{{ route('login') }}">Login</a>
    <span class="bullet"></span>
    <a href="{{ route('register') }}">Register</a>
  </div>

@endsection
