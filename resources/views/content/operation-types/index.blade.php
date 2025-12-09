@extends('layouts/contentNavbarLayout')

@section('title', 'Types d\'Opérations')

@section('content')
  <div class="card table-wrapper">
    <div class="card-header border-0 d-flex align-items-center justify-content-between">
      <h3 class="mb-0">Types d'opérations</h3>
      <a href="{{ route('operation-types.create') }}" class="btn btn-primary btn-sm">
        <i class="icon-base bx bx-plus"></i> Ajouter un nouveau type d'opération
      </a>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <!-- Custom Filters -->
    <div class="card-body border-bottom">
      <form method="GET" action="{{ route('operation-types.index') }}" id="filterForm">
        <div class="row g-3 mb-3">
          <div class="col-md-4">
            <label class="form-label small">Nom du type d'opération</label>
            <input type="text" name="filter_nom" class="form-control form-control-sm"
              placeholder="Rechercher par nom..." value="{{ request('filter_nom') }}">
          </div>
          <div class="col-md-2 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="icon-base bx bx-search"></i> Filtrer
            </button>
            @if (request()->has('filter_nom'))
              <a href="{{ route('operation-types.index') }}" class="btn btn-secondary btn-sm">
                <i class="icon-base bx bx-x"></i> Réinitialiser
              </a>
            @endif
          </div>
        </div>
      </form>
    </div>

    <!-- Custom Table -->
    <div class="table-responsive">
      <table class="table align-items-center table-flush table-striped mb-0">
        <thead class="thead-light">
          <tr>
            <th class="sort" data-sort="nom">
              Nom
              <i class="icon-base bx bx-sort"></i>
            </th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="list">
          @forelse($operationTypes as $operationType)
            <tr>
              <td class="nom">{{ $operationType->nom }}</td>
              <td>
                <a href="{{ route('operation-types.edit', $operationType->id) }}" class="btn btn-sm btn-info"
                  title="Modifier">
                  <i class="icon-base bx bx-edit"></i>
                </a>
                <form action="{{ route('operation-types.destroy', $operationType->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce type d\'opération?')"
                    title="Supprimer">
                    <i class="icon-base bx bx-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="2" class="text-center py-4">
                <p class="text-muted mb-0">Aucun type d'opération trouvé</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Custom Pagination -->
    <div class="card-footer py-4">
      <div class="d-flex justify-content-between align-items-center">
        <div class="text-muted small">
          Affichage de {{ $operationTypes->firstItem() ?? 0 }} à {{ $operationTypes->lastItem() ?? 0 }}
          sur {{ $operationTypes->total() }} résultat(s)
        </div>
        <nav aria-label="Pagination">
          {{ $operationTypes->appends(request()->query())->links() }}
        </nav>
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

    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }

    .sort {
      cursor: pointer;
      user-select: none;
    }

    .sort:hover {
      color: #0d6efd;
    }
  </style>
@endsection
