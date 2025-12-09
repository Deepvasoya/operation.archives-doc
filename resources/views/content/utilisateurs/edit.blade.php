@extends('layouts/contentNavbarLayout')

@section('title', 'Modifier un Utilisateur')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Modifier l'Utilisateur</h5>
          <a href="{{ route('utilisateurs.index') }}" class="btn btn-sm btn-secondary">
            <i class="icon-base bx bx-arrow-back"></i> Retour
          </a>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('utilisateurs.update', $utilisateur->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
              <label class="form-label" for="nom">Nom <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                value="{{ old('nom', $utilisateur->nom) }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="cin">CIN <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('cin') is-invalid @enderror" id="cin" name="cin"
                value="{{ old('cin', $utilisateur->cin) }}" required>
              @error('cin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email', $utilisateur->email) }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="password">Nouveau Mot de Passe</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                name="password" minlength="6">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
              <div class="form-text">Laissez vide pour conserver le mot de passe actuel. Minimum 6 caractères si modifié.
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary">Annuler</a>
              <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
