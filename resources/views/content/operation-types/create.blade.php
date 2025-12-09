@extends('layouts/contentNavbarLayout')

@section('title', 'Ajouter un Type d\'Opération')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Ajouter un nouveau type d'opération</h5>
          <a href="{{ route('operation-types.index') }}" class="btn btn-sm btn-secondary">
            <i class="icon-base bx bx-arrow-back"></i> Retour
          </a>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('operation-types.store') }}">
            @csrf

            <div class="mb-6">
              <label class="form-label" for="nom">Nom du type d'opération <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom"
                value="{{ old('nom') }}" required placeholder="Entrez le nom du type d'opération">
              @error('nom')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('operation-types.index') }}" class="btn btn-secondary">Annuler</a>
              <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
