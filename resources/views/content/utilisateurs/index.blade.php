@extends('layouts/contentNavbarLayout')

@section('title', 'Gestion des Utilisateurs')

@section('content')
  <div class="card table-wrapper">
    <div class="card-header border-0 d-flex align-items-center justify-content-between">
      <h3 class="mb-0">Utilisateurs</h3>
      <a href="{{ route('utilisateurs.create') }}" class="btn btn-primary btn-sm">
        <i class="icon-base bx bx-plus"></i> Ajouter un Nouveau Utilisateur
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
      <form method="GET" action="{{ route('utilisateurs.index') }}" id="filterForm">
        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label small">Nom</label>
            <input type="text" name="filter_nom" class="form-control form-control-sm"
              placeholder="Rechercher par nom..." value="{{ request('filter_nom') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label small">CIN</label>
            <input type="text" name="filter_cin" class="form-control form-control-sm"
              placeholder="Rechercher par CIN..." value="{{ request('filter_cin') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label small">Email</label>
            <input type="text" name="filter_email" class="form-control form-control-sm"
              placeholder="Rechercher par email..." value="{{ request('filter_email') }}">
          </div>
          <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="icon-base bx bx-search"></i> Filtrer
            </button>
            @if (request()->hasAny(['filter_nom', 'filter_cin', 'filter_email']))
              <a href="{{ route('utilisateurs.index') }}" class="btn btn-secondary btn-sm">
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
            <th class="sort" data-sort="cin">
              CIN
              <i class="icon-base bx bx-sort"></i>
            </th>
            <th>Email</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="list">
          @forelse($utilisateurs as $utilisateur)
            <tr>
              <td class="nom">{{ $utilisateur->nom }}</td>
              <td class="cin">{{ $utilisateur->cin }}</td>
              <td>{{ $utilisateur->email }}</td>
              <td>
                <a href="{{ route('utilisateurs.edit', $utilisateur->id) }}" class="btn btn-sm btn-info"
                  title="Modifier">
                  <i class="icon-base bx bx-edit"></i>
                </a>
                <form action="{{ route('utilisateurs.destroy', $utilisateur->id) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger"
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?')" title="Supprimer">
                    <i class="icon-base bx bx-trash"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="text-center py-4">
                <p class="text-muted mb-0">Aucun utilisateur trouvé</p>
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
          Affichage de {{ $utilisateurs->firstItem() ?? 0 }} à {{ $utilisateurs->lastItem() ?? 0 }}
          sur {{ $utilisateurs->total() }} résultat(s)
        </div>
        <nav aria-label="Pagination">
          {{ $utilisateurs->appends(request()->query())->links() }}
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
