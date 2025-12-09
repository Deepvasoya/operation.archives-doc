@extends('layouts/contentNavbarLayout')

@section('title', 'Détails Usager')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Détails de l'Usager</h5>
          <div>
            <a href="{{ route('usagers.edit', $usager->id) }}" class="btn btn-sm btn-info">
              <i class="icon-base bx bx-edit"></i> Modifier
            </a>
            <a href="{{ route('usagers.index') }}" class="btn btn-sm btn-secondary">
              <i class="icon-base bx bx-arrow-back"></i> Retour
            </a>
          </div>
        </div>
        <div class="card-body">
          <div class="row mb-6">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nom:</label>
              <p class="form-control-plaintext">{{ $usager->nom }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">CIN:</label>
              <p class="form-control-plaintext">{{ $usager->cin }}</p>
            </div>
          </div>

          <div class="row mb-6">
            <div class="col-md-6">
              <label class="form-label fw-bold">Email:</label>
              <p class="form-control-plaintext">{{ $usager->email ?? '-' }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Téléphone:</label>
              <p class="form-control-plaintext">{{ $usager->telephone ?? '-' }}</p>
            </div>
          </div>

          <div class="row mb-6">
            <div class="col-md-6">
              <label class="form-label fw-bold">Nombre d'Opérations:</label>
              <p class="form-control-plaintext">{{ $usager->nombre_operations }}</p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold">Date de création:</label>
              <p class="form-control-plaintext">{{ $usager->created_at->format('d/m/Y H:i') }}</p>
            </div>
          </div>

          <div class="mt-6">
            <h6 class="mb-3">Opérations</h6>
            <div class="alert alert-info">
              <i class="icon-base bx bx-info-circle"></i>
              La liste des opérations sera affichée ici ({{ $usager->nombre_operations }} opération(s))
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
