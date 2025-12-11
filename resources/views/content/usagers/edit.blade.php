@extends('layouts/contentNavbarLayout')

@section('title', 'Modifier un Usager')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Modifier Usager</h5>
          <a href="{{ route('usagers.index') }}" class="btn btn-sm btn-secondary">
            <i class="icon-base bx bx-arrow-back"></i> Retour
          </a>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('usagers.update', $usager->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-6">
              <label class="form-label" for="nom">Nom <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                value="{{ old('nom', $usager->nom) }}" required>
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="cin">CIN <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('cin') is-invalid @enderror" id="cin" name="cin"
                value="{{ old('cin', $usager->cin) }}" required>
              @error('cin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="email">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email', $usager->email) }}">
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-6">
              <label class="form-label" for="telephone">Téléphone</label>
              <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone"
                name="telephone" value="{{ old('telephone', $usager->telephone) }}">
              @error('telephone')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            {{-- <div class="mb-6">
              <label class="form-label" for="nombre_operations">Nombre d'Opérations</label>
              <input type="number" class="form-control @error('nombre_operations') is-invalid @enderror"
                id="nombre_operations" name="nombre_operations"
                value="{{ old('nombre_operations', $usager->nombre_operations) }}" min="0">
              @error('nombre_operations')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div> --}}

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('usagers.index') }}" class="btn btn-secondary">Annuler</a>
              <button type="submit" class="btn btn-primary">Mettre à jour</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
