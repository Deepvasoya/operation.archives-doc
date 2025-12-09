@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
  @vite(['resources/assets/vendor/scss/pages/page-auth.scss'])
@endsection

@section('content')
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card px-sm-6 px-0">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{ url('/') }}" class="app-brand-link gap-2">
                {{-- <span class="app-brand-logo demo">@include('_partials.macros')</span> --}}
                <span class="app-brand-text demo text-heading fw-bold"><img src="{{ asset('assets/img/custom/logo.png') }}"
                    alt="Logo" width="100"></span>
              </a>
            </div>
            <!-- /Logo -->
            {{-- <h4 class="mb-1">Welcome to {{ config('variables.templateName') }}! 👋</h4> --}}
            {{-- <p class="mb-6">Please sign-in to your account and start the adventure</p> --}}

            @if (session('success'))
              <div class="alert alert-success mb-4">
                {{ session('success') }}
              </div>
            @endif

            @if ($errors->any())
              <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form id="formAuthentication" class="mb-6" action="{{ url('/login') }}" method="POST">
              @csrf
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-base bx bx-envelope"></i>
                    </span>
                  </div>
                  <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="Email" value="{{ old('email') }}" required autofocus />
                </div>
                @error('email')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group mb-3">
                <div class="input-group input-group-alternative">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-base bx bx-lock-open-alt"></i>
                    </span>
                  </div>
                  <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" placeholder="Mot de passe" required />
                </div>
                @error('password')
                  <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
              </div>
              <div class="mb-8">
                <div class="d-flex justify-content-between">
                  <div class="form-check mb-0">
                    <input class="form-check-input" type="checkbox" id="remember" name="remember" />
                    <label class="form-check-label" for="remember"> Remember Me </label>
                  </div>
                  {{-- <a href="{{ url('auth/forgot-password-basic') }}">
                    <span>Forgot Password?</span>
                  </a> --}}
                </div>
              </div>
              <div class="text-center">
                <button class="btn btn-primary my-4" type="submit">Se connecter</button>
              </div>
            </form>

            {{-- <p class="text-center">
              <span>New on our platform?</span>
              <a href="{{ url('auth/register-basic') }}">
                <span>Create an account</span>
              </a>
            </p> --}}
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
@endsection
