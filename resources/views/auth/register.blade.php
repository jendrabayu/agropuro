@extends('layouts.auth')

@section('title', 'Register')

@section('content')

  <div class="card card-primary">
    <div class="card-header">
      <h4>Register</h4>
    </div>

    <div class="card-body">
      <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
          <label for="name">Name</label>
          <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" tabindex="1"
            autofocus value="{{ old('name') }}">

          @error('name')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
            tabindex="1" autofocus value="{{ old('email') }}">

          @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password" class="control-label">Password</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            name="password" tabindex="2">

          @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password" class="control-label">Konfirmasi Password</label>
          <input id="password" type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
            name="password_confirmation" tabindex="2">

          @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
            Register
          </button>
        </div>
      </form>
    </div>
  </div>
  <div class="mt-5 text-muted text-center">
    Sudah punya akun ? <a href="{{ route('login') }}">Login</a>
  </div>
@endsection
