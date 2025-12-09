@extends('layouts/contentNavbarLayout')

@section('title', 'Rapports')

@section('content')
  <div class="card table-wrapper">
    <div class="card-header border-0">
      <h3 class="mb-0">Rapport des Usagers et Opérations</h3>
    </div>

    <!-- Custom Filters -->
    <div class="card-body border-bottom">
      <form method="GET" action="{{ route('rapports.index') }}" id="filterForm">
        <div class="row g-3 mb-3">
          <div class="col-md-3">
            <label class="form-label small">Date de Début</label>
            <input type="date" name="date_debut" class="form-control form-control-sm"
              value="{{ request('date_debut') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label small">Date de Fin</label>
            <input type="date" name="date_fin" class="form-control form-control-sm" value="{{ request('date_fin') }}">
          </div>
          <div class="col-md-3">
            <label class="form-label small">Type d'Opération</label>
            <select name="type_operation" class="form-control form-control-sm">
              <option value="">Tous les types</option>
              @foreach ($operationTypes as $type)
                <option value="{{ $type->id }}" {{ request('type_operation') == $type->id ? 'selected' : '' }}>
                  {{ $type->nom }}
                </option>
              @endforeach
            </select>
          </div>
          <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="icon-base bx bx-search"></i> Filtrer
            </button>
            @if (request()->hasAny(['date_debut', 'date_fin', 'type_operation']))
              <a href="{{ route('rapports.index') }}" class="btn btn-secondary btn-sm">
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
            <th>Nom</th>
            <th>CIN</th>
            <th>Nombre d'Opérations</th>
            <th>Détails des Opérations</th>
            <th>Date de Dernière Opération</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="list">
          @forelse($rapports as $rapport)
            <tr>
              <td>{{ $rapport['usager']->nom }}</td>
              <td>{{ $rapport['usager']->cin }}</td>
              <td>{{ $rapport['nombre_operations'] }}</td>
              <td>{{ $rapport['details_operations'] }}</td>
              <td>{{ $rapport['date_derniere_operation'] }}</td>
              <td>
                <a href="{{ route('rapports.pdf', $rapport['usager']->id) }}" class="btn btn-sm btn-danger"
                  title="Générer PDF" target="_blank">
                  <i class="icon-base bx bx-file-blank"></i> PDF
                </a>
                {{-- <a href="{{ route('usagers.show', $rapport['usager']->id) }}" class="btn btn-sm btn-info"
                  title="Voir détails">
                  <i class="icon-base bx bx-show"></i>
                </a> --}}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-4">
                <p class="text-muted mb-0">Aucun rapport trouvé</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
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
  </style>
@endsection
