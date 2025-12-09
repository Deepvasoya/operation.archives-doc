@extends('layouts/contentNavbarLayout')

@section('title', 'Modifier une Opération')

@section('content')
  <div class="row mb-6 gy-6">
    <div class="col-xl">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Modifier l'Opération</h5>
          <a href="{{ route('usagers.show', $operation->usager_id) }}" class="btn btn-sm btn-secondary">
            <i class="icon-base bx bx-arrow-back"></i> Retour
          </a>
        </div>
        <div class="card-body">
          <form method="POST" action="{{ route('operations.update', $operation->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row g-3">
              <div class="col-md-6">
                <label for="operation_type_id" class="form-label">Type d'opération <span
                    class="text-danger">*</span></label>
                <select class="form-select @error('operation_type_id') is-invalid @enderror" id="operation_type_id"
                  name="operation_type_id" required>
                  <option value="">Sélectionner un type</option>
                  @foreach ($operationTypes as $type)
                    <option value="{{ $type->id }}"
                      {{ old('operation_type_id', $operation->operation_type_id) == $type->id ? 'selected' : '' }}>
                      {{ $type->nom }}
                    </option>
                  @endforeach
                </select>
                @error('operation_type_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                  name="date"
                  value="{{ old('date', $operation->date ? \Carbon\Carbon::parse($operation->date)->format('Y-m-d') : '') }}"
                  required>
                @error('date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="numero_operation" class="form-label">Numéro d'opération</label>
                <input type="text" class="form-control @error('numero_operation') is-invalid @enderror"
                  id="numero_operation" name="numero_operation"
                  value="{{ old('numero_operation', $operation->numero_operation) }}"
                  placeholder="Entrer le numéro d'opération">
                @error('numero_operation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                  rows="3" placeholder="Entrer la description">{{ old('description', $operation->description) }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12">
                <label for="piece_jointe" class="form-label">Pièce jointe</label>
                @if ($operation->piece_jointe)
                  <div class="mb-2">
                    <p class="text-muted small mb-1">Fichier actuel:</p>
                    <a href="{{ asset('storage/' . $operation->piece_jointe) }}" target="_blank"
                      class="btn btn-sm btn-link">
                      <i class="icon-base bx bx-file"></i> Voir le fichier actuel
                    </a>
                  </div>
                @endif
                <input type="file" class="form-control @error('piece_jointe') is-invalid @enderror" id="piece_jointe"
                  name="piece_jointe" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <small class="form-text text-muted">
                  @if ($operation->piece_jointe)
                    Laisser vide pour conserver le fichier actuel ou sélectionner un nouveau fichier (Max: 10MB)
                  @else
                    Glissez ou cliquez pour télécharger un fichier (Max: 10MB)
                  @endif
                </small>
                @error('piece_jointe')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12">
                <div class="d-flex justify-content-end gap-2">
                  <a href="{{ route('usagers.show', $operation->usager_id) }}" class="btn btn-secondary">Annuler</a>
                  <button type="submit" class="btn btn-primary">
                    <i class="icon-base bx bx-save"></i> Mettre à jour
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
