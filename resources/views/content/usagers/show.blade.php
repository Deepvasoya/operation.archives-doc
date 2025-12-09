@extends('layouts/contentNavbarLayout')

@section('title', $usager->nom . ' - Opérations')

@section('content')
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="row mb-6 gy-6">
    <!-- Usager Details Card -->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">{{ $usager->nom }} - Opérations</h5>
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
          <div class="row mb-4">
            <div class="col-md-3">
              <label class="form-label fw-bold">Nom:</label>
              <p class="form-control-plaintext">{{ $usager->nom }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">CIN:</label>
              <p class="form-control-plaintext">{{ $usager->cin }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Email:</label>
              <p class="form-control-plaintext">{{ $usager->email ?? '-' }}</p>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Téléphone:</label>
              <p class="form-control-plaintext">{{ $usager->telephone ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add New Operation Form -->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Ajouter une nouvelle opération</h5>
        </div>
        <div class="card-body">
          <form action="{{ route('operations.store', $usager->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="operation_type_id" class="form-label">Type d'opération <span
                    class="text-danger">*</span></label>
                <select class="form-select @error('operation_type_id') is-invalid @enderror" id="operation_type_id"
                  name="operation_type_id" required>
                  <option value="">Sélectionner un type</option>
                  @foreach ($operationTypes as $type)
                    <option value="{{ $type->id }}" {{ old('operation_type_id') == $type->id ? 'selected' : '' }}>
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
                  name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-6">
                <label for="numero_operation" class="form-label">Numéro d'opération</label>
                <input type="text" class="form-control @error('numero_operation') is-invalid @enderror"
                  id="numero_operation" name="numero_operation" value="{{ old('numero_operation') }}"
                  placeholder="Entrer le numéro d'opération">
                @error('numero_operation')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                  rows="3" placeholder="Entrer la description">{{ old('description') }}</textarea>
                @error('description')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12">
                <label for="piece_jointe" class="form-label">Pièce jointe</label>
                <input type="file" class="form-control @error('piece_jointe') is-invalid @enderror" id="piece_jointe"
                  name="piece_jointe" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <small class="form-text text-muted">Glissez ou cliquez pour télécharger un fichier (Max: 10MB)</small>
                @error('piece_jointe')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-md-12">
                <button type="submit" class="btn btn-primary">
                  <i class="icon-base bx bx-save"></i> Enregistrer
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Operations Table -->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Liste des Opérations</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table align-items-center table-flush table-striped mb-0">
              <thead class="thead-light">
                <tr>
                  <th>Type</th>
                  <th>Description</th>
                  <th>Pièce jointe</th>
                  <th>Date</th>
                  <th>Numéro d'opération</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse($usager->operations as $operation)
                  <tr>
                    <td>{{ $operation->operationType->nom ?? '-' }}</td>
                    <td>{{ $operation->description ?? '-' }}</td>
                    <td>
                      @if ($operation->piece_jointe)
                        <a href="{{ asset('storage/' . $operation->piece_jointe) }}" target="_blank"
                          class="btn btn-sm btn-link">
                          <i class="icon-base bx bx-file"></i> Voir fichier
                        </a>
                      @else
                        <span class="text-muted">Aucune pièce jointe</span>
                      @endif
                    </td>
                    <td>{{ $operation->date ? \Carbon\Carbon::parse($operation->date)->format('M d, Y') : '-' }}</td>
                    <td>{{ $operation->numero_operation ?? '-' }}</td>
                    <td>
                      <a href="{{ route('operations.edit', $operation->id) }}" class="btn btn-sm btn-info"
                        title="Modifier">
                        <i class="icon-base bx bx-edit"></i>
                      </a>
                      <form action="{{ route('operations.destroy', $operation->id) }}" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                          onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette opération?')"
                          title="Supprimer">
                          <i class="icon-base bx bx-trash"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center py-4">
                      <p class="text-muted mb-0">Aucune opération trouvée</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .table-wrapper {
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
      background-color: #f8f9fa;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #dee2e6;
      padding: 1rem 0.75rem;
    }

    .table tbody td {
      padding: 1rem 0.75rem;
      vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(0, 0, 0, 0.02);
    }

    .table tbody tr:hover {
      background-color: rgba(0, 0, 0, 0.05);
      transition: background-color 0.2s;
    }
  </style>
@endsection
