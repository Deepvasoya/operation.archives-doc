@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('vendor-style')
  @vite('resources/assets/vendor/libs/apex-charts/apex-charts.scss')
@endsection

@section('vendor-script')
  @vite('resources/assets/vendor/libs/apex-charts/apexcharts.js')
@endsection

@section('content')
  <!-- Header Stats -->
  <div class="header bg-gradient-danger pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row">
          <!-- Total des Usagers -->
          <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Total des Usagers</h5>
                    <span class="h2 font-weight-bold mb-0">{{ $totalUsagers }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                      <i class="icon-base bx bx-user"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-success mr-2">
                    <i class="icon-base bx bx-up-arrow-alt"></i> +{{ $usagersGrowth }}%
                  </span>
                  <span class="text-nowrap">Ce mois-ci</span>
                </p>
              </div>
            </div>
          </div>

          <!-- Total des Opérations -->
          <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Total des Opérations</h5>
                    <span class="h2 font-weight-bold mb-0">{{ $totalOperations }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                      <i class="icon-base bx bx-list-check"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-success mr-2">
                    <i class="icon-base bx bx-up-arrow-alt"></i> +{{ $operationsGrowth }}%
                  </span>
                  <span class="text-nowrap">Ce mois-ci</span>
                </p>
              </div>
            </div>
          </div>

          <!-- Usager le plus Actif -->
          <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Usager le plus Actif</h5>
                    <span class="h2 font-weight-bold mb-0">{{ $mostActiveUsager ? $mostActiveUsager->nom : 'N/A' }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                      <i class="icon-base bx bx-user-circle"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-success mr-2">
                    <i class="icon-base bx bx-award"></i>
                  </span>
                  <span class="text-nowrap">Top Engagement</span>
                </p>
              </div>
            </div>
          </div>

          <!-- Type d'Opération le plus Populaire -->
          <div class="col-xl-3 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0">
              <div class="card-body">
                <div class="row">
                  <div class="col">
                    <h5 class="card-title text-uppercase text-muted mb-0">Type d'Opération le plus Populaire</h5>
                    <span class="h2 font-weight-bold mb-0"
                      style="font-size: 1rem;">{{ $mostPopularType ? $mostPopularType->nom : 'N/A' }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-success text-white rounded-circle shadow">
                      <i class="icon-base bx bx-file-blank"></i>
                    </div>
                  </div>
                </div>
                <p class="mt-3 mb-0 text-muted text-sm">
                  <span class="text-info mr-2">
                    <i class="icon-base bx bx-star"></i>
                  </span>
                  <span class="text-nowrap">Plus Populaire</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts Section -->
  <div class="container-fluid mt--7">
    <div class="row mt-5">
      <!-- Opérations par Type -->
      <div class="col-xl-6">
        <div class="card shadow h-100">
          <div class="card-header bg-transparent">
            <h3 class="mb-0">Opérations par Type</h3>
          </div>
          <div class="card-body d-flex align-items-center justify-content-center">
            <div id="operations-by-type-chart" style="max-height: 400px; width: 100%;"></div>
          </div>
        </div>
      </div>

      <!-- Opérations par Date -->
      <div class="col-xl-6">
        <div class="card shadow h-100">
          <div class="card-header bg-transparent">
            <h3 class="mb-0">Opérations par Date</h3>
          </div>
          <div class="card-body d-flex align-items-center justify-content-center">
            <div id="operations-by-date-chart" style="max-height: 400px; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>

    <!-- Tables Section -->
    <div class="row mt-5">
      <!-- Derniers 10 Usagers -->
      <div class="col-xl-6">
        <div class="card shadow">
          <div class="card-header bg-transparent">
            <h3 class="mb-0">Derniers 10 Usagers</h3>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>Nom</th>
                  <th>CIN</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                @forelse($latestUsagers as $usager)
                  <tr>
                    <td>{{ $usager->nom }}</td>
                    <td>{{ $usager->cin }}</td>
                    <td>{{ $usager->email ?: '-' }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">Aucun usager trouvé</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <!-- Dernières 10 Opérations -->
      <div class="col-xl-6">
        <div class="card shadow">
          <div class="card-header bg-transparent">
            <h3 class="mb-0">Dernières 10 Opérations</h3>
          </div>
          <div class="table-responsive">
            <table class="table align-items-center table-flush">
              <thead class="thead-light">
                <tr>
                  <th>N°</th>
                  <th>Type</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @forelse($latestOperations as $index => $operation)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $operation['type'] }}</td>
                    <td>{{ $operation['date'] }}</td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">Aucune opération trouvée</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  @section('page-script')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Opérations par Type Chart (Donut)
        const operationsByTypeData = @json($operationsByType);
        const typeLabels = operationsByTypeData.map(item => item.nom);
        const typeSeries = operationsByTypeData.map(item => item.count);

        const typeChartOptions = {
          chart: {
            type: 'donut',
            height: 400
          },
          labels: typeLabels,
          series: typeSeries,
          colors: ['#f56565', '#ed8936', '#ecc94b', '#48bb78', '#38b2ac', '#4299e1', '#667eea', '#9f7aea'],
          legend: {
            position: 'bottom'
          },
          dataLabels: {
            enabled: true,
            formatter: function(val) {
              return val.toFixed(1) + '%';
            }
          }
        };

        const typeChart = new ApexCharts(document.querySelector('#operations-by-type-chart'), typeChartOptions);
        typeChart.render();

        // Opérations par Date Chart (Line)
        const operationsByDateData = @json($operationsByDate);
        const dateLabels = operationsByDateData.map(item => item.date);
        const dateSeries = operationsByDateData.map(item => item.count);

        const dateChartOptions = {
          chart: {
            type: 'line',
            height: 400,
            toolbar: {
              show: false
            }
          },
          series: [{
            name: 'Opérations',
            data: dateSeries
          }],
          xaxis: {
            categories: dateLabels
          },
          colors: ['#4299e1'],
          stroke: {
            curve: 'smooth',
            width: 3
          },
          markers: {
            size: 5
          },
          grid: {
            borderColor: '#e2e8f0'
          }
        };

        const dateChart = new ApexCharts(document.querySelector('#operations-by-date-chart'), dateChartOptions);
        dateChart.render();
      });
    </script>
  @endsection

  <style>
    .header {
      background: linear-gradient(87deg, #f5365c 0, #f56036 100%) !important;
    }

    .card-stats {
      border: 0;
      border-radius: 0.5rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .icon-shape {
      width: 3rem;
      height: 3rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .icon-shape i {
      font-size: 1.5rem;
    }

    .thead-light {
      background-color: #f8f9fa;
    }

    .table th {
      border-top: none;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
    }
  </style>
@endsection
