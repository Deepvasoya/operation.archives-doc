@extends('layouts/contentNavbarLayout')

@section('title', 'Ajouter un Utilisateur')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Ajouter un Nouveau Utilisateur</h5>
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-sm btn-secondary">
            <i class="icon-base bx bx-arrow-back"></i> Retour
          </a>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('utilisateurs.store') }}">
            @csrf

            <div class="mb-6">
              <label class="form-label" for="nom">Nom <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                value="{{ old('nom') }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="cin">CIN <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('cin') is-invalid @enderror" id="cin" name="cin"
                value="{{ old('cin') }}" required>
              @error('cin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="password">Mot de Passe Initial <span class="text-danger">*</span></label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" required minlength="6">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Le mot de passe doit contenir au moins 6 caractères</div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
