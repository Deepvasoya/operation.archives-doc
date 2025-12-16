@extends('layouts/contentNavbarLayout')

@section('title', 'My Profile')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <!-- User Information Card (Read-only) -->
      <div class="card mb-4">
        <h5 class="card-header">Profile Information</h5>
        <div class="card-body">
          {{-- <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
            <img src="{{ asset('assets/img/avatars/1.png') }}" alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" />
          </div> --}}
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Name</label>
              <input class="form-control" type="text" readonly value="{{ $user->name }}" readonly />
            </div>
            <div class="col-md-6">
              <label class="form-label">Email</label>
              <input class="form-control" type="text" readonly value="{{ $user->email }}" />
            </div>
          </div>
        </div>
      </div>

      <!-- Change Password Card -->
      <div class="card">
        <h5 class="card-header">Change Password</h5>
        <div class="card-body">
          @if (session('success'))
            <div class="alert alert-success alert-dismissible" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
              <ul class="mb-0">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form method="POST" action="{{ route('profile.update-password') }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="password" class="form-label">New Password</label>
                <input class="form-control @error('password') is-invalid @enderror" type="password" id="password"
                  name="password" required />
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation"
                  required />
              </div>
            </div>
            <div class="mt-4">
              <button type="submit" class="btn btn-primary">Update Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
