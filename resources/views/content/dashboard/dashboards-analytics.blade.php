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
  <div class=" pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
      <div class="header-body">
        <div class="row">
          <!-- Total des Usagers -->
          <div class="col-xl-6 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0 stats-card-hover">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="card-title text-uppercase text-muted mb-2 stats-label">Total des Usagers</h6>
                    <span class="stats-number">{{ $totalUsagers }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow stats-icon">
                      <i class="icon-base bx bx-user"></i>
                    </div>
                  </div>
                </div>
                <div class="mt-3 pt-2 border-top border-light">
                  <p class="mb-0 stats-growth">
                    <span class="text-success font-weight-semibold">
                      <i class="icon-base bx bx-up-arrow-alt"></i> +{{ $usagersGrowth }}%
                    </span>
                    <span class="text-muted ml-2 stats-period">Ce mois-ci</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Total des Opérations -->
          <div class="col-xl-6 col-lg-6">
            <div class="card card-stats mb-4 mb-xl-0 stats-card-hover">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="card-title text-uppercase text-muted mb-2 stats-label">Total des Opérations</h6>
                    <span class="stats-number">{{ $totalOperations }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow stats-icon">
                      <i class="icon-base bx bx-list-check"></i>
                    </div>
                  </div>
                </div>
                <div class="mt-3 pt-2 border-top border-light">
                  <p class="mb-0 stats-growth">
                    <span class="text-success font-weight-semibold">
                      <i class="icon-base bx bx-up-arrow-alt"></i> +{{ $operationsGrowth }}%
                    </span>
                    <span class="text-muted ml-2 stats-period">Ce mois-ci</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Usager le plus Actif -->
          <div class="col-xl-6 col-lg-6 mt-4">
            <div class="card card-stats mb-4 mb-xl-0 stats-card-hover">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="card-title text-uppercase text-muted mb-2 stats-label">Usager le plus Actif</h6>
                    <span
                      class="stats-number stats-text-value">{{ $mostActiveUsager ? $mostActiveUsager->nom : 'N/A' }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-info text-white rounded-circle shadow stats-icon">
                      <i class="icon-base bx bx-user-circle"></i>
                    </div>
                  </div>
                </div>
                <div class="mt-3 pt-2 border-top border-light">
                  <p class="mb-0 stats-growth">
                    <span class="text-info font-weight-semibold">
                      <i class="icon-base bx bx-award"></i>
                    </span>
                    <span class="text-muted ml-2 stats-period">Top Engagement</span>
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- Type d'Opération le plus Populaire -->
          <div class="col-xl-6 col-lg-6 mt-4">
            <div class="card card-stats mb-4 mb-xl-0 stats-card-hover">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="card-title text-uppercase text-muted mb-2 stats-label">Type d'Opération le plus Populaire
                    </h6>
                    <span
                      class="stats-number stats-text-value">{{ $mostPopularType ? $mostPopularType->nom : 'N/A' }}</span>
                  </div>
                  <div class="col-auto">
                    <div class="icon icon-shape bg-success text-white rounded-circle shadow stats-icon">
                      <i class="icon-base bx bx-file-blank"></i>
                    </div>
                  </div>
                </div>
                <div class="mt-3 pt-2 border-top border-light">
                  <p class="mb-0 stats-growth">
                    <span class="text-info font-weight-semibold">
                      <i class="icon-base bx bx-star"></i>
                    </span>
                    <span class="text-muted ml-2 stats-period">Plus Populaire</span>
                  </p>
                </div>
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
      border-radius: 0.75rem;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
      background: #fff;
    }

    .stats-card-hover {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stats-card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.2);
    }

    .stats-label {
      font-size: 0.75rem;
      font-weight: 600;
      letter-spacing: 0.5px;
      margin-bottom: 0.75rem !important;
      color: #6c757d !important;
    }

    .stats-number {
      font-size: 2.5rem;
      font-weight: 700;
      line-height: 1.2;
      color: #2b2c40;
      display: block;
      letter-spacing: -0.5px;
    }

    .stats-text-value {
      font-size: 1.25rem;
      font-weight: 600;
      line-height: 1.4;
      color: #2b2c40;
      display: block;
      word-break: break-word;
    }

    .icon-shape {
      width: 4rem;
      height: 4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s ease;
    }

    .stats-card-hover:hover .icon-shape {
      transform: scale(1.1);
    }

    .icon-shape i {
      font-size: 2rem;
    }

    .stats-icon {
      opacity: 0.95;
    }

    .stats-growth {
      font-size: 0.875rem;
      display: flex;
      align-items: center;
      flex-wrap: wrap;
    }

    .stats-growth i {
      font-size: 1rem;
      margin-right: 0.25rem;
    }

    .stats-period {
      font-size: 0.8125rem;
    }

    .font-weight-semibold {
      font-weight: 600;
    }

    .border-light {
      border-color: #e9eaec !important;
    }

    @media (max-width: 1200px) {
      .stats-number {
        font-size: 2rem;
      }

      .stats-text-value {
        font-size: 1.1rem;
      }

      .icon-shape {
        width: 3.5rem;
        height: 3.5rem;
      }

      .icon-shape i {
        font-size: 1.75rem;
      }
    }

    @media (max-width: 768px) {
      .stats-number {
        font-size: 1.75rem;
      }

      .stats-text-value {
        font-size: 1rem;
      }

      .stats-label {
        font-size: 0.7rem;
      }
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
