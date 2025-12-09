@extends('layouts/contentNavbarLayout')

@section('title', 'Détails Utilisateur')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Détails de l'Utilisateur</h5>
          <div>
            <a href="{{ route('utilisateurs.edit', $utilisateur->id) }}" class="btn btn-sm btn-info">
              <i class="icon-base bx bx-edit"></i> Modifier
            </a>
            <a href="{{ route('utilisateurs.index') }}" class="btn btn-sm btn-secondary">
              <i class="icon-base bx bx-arrow-back"></i> Retour
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-6">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nom:</label>
              <p class="form-control-plaintext">{{ $utilisateur->nom }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">CIN:</label>
              <p class="form-control-plaintext">{{ $utilisateur->cin }}</p>
            </div>
          </div>

          <div class="row mb-6">
            <div class="col-md-6">
              <label class="form-label fw-bold">Email:</label>
              <p class="form-control-plaintext">{{ $utilisateur->email }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Date de création:</label>
              <p class="form-control-plaintext">{{ $utilisateur->created_at->format('d/m/Y H:i') }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
