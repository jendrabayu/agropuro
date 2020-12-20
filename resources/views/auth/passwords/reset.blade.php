@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
  <div class="card card-primary">
    <div class="card-header">
      <h4>Reset Password</h4>
    </div>
    <div class="card-body">
      @if (session('status'))
        <div class="alert alert-success" role="alert">
          {{ session('status') }}
        </div>
      @endif
      <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password">Password Baru</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" required autocomplete="new-password">

          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password-confirm">Konfirmasi Password</label>
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
            autocomplete="new-password">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Reset Password
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
