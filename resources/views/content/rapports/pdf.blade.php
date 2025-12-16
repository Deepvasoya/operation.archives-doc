<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Rapport - {{ $usager->nom }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 9pt;
      padding: 20px;
      color: #000;
    }

    .header {
      position: relative;
      margin-bottom: 50px;
      min-height: 80px;
    }

    .company-info {
      position: absolute;
      left: 0;
      top: 0;
    }

    .company-logo {
      margin-bottom: 10px;
      max-height: 50px;
      max-width: 150px;
    }

    .company-logo img {
      height: auto;
      max-height: 50px;
      max-width: 150px;
    }

    .company-name {
      font-size: 12pt;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .company-details {
      font-size: 9pt;
      line-height: 1.5;
    }

    .date-info {
      position: absolute;
      right: 0;
      top: 0;
      font-size: 9pt;
      text-align: right;
      line-height: 1.8;
    }

    .middle-info {
      text-align: right;
      margin-bottom: 20px;
    }

    .middle-info-content.right {
      display: inline-block;
      text-align: right;
    }

    .title {
      font-size: 13.5pt;
      font-weight: bold;
      margin: 30px 0 25px 0;
      text-align: center;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      padding: 8px 6px;
      text-align: left;
      font-weight: bold;
      font-size: 9pt;
    }

    td {
      border: 1px solid #dee2e6;
      padding: 8px 6px;
      font-size: 9pt;
    }

    .text-center {
      text-align: center;
    }

    .no-border {
      border: none;
    }
  </style>
</head>

<body>
  <div class="header">
    <div class="company-info">
      <div class="company-logo">
        <img src="{{ public_path('assets/img/custom/logo.png') }}" alt="Logo">
      </div>
      <div class="company-name">StartusWeb</div>
      {{-- <div class="company-details">
        Address: N°189 Lot Ikhtiar Hay Firdaous. Marrakesh 40000<br>
        Téléphone. 0075-323012
      </div> --}}
    </div>
    <div class="date-info">
      Généré le: {{ $date_generation }}<br>
    </div>
  </div>


  <div class="middle-info">
    <div class="middle-info-content right">
      <span style="color: #28a745; font-weight: bold;">Nombre d'Opérations</span>
      {{-- <span style="font-weight: bold;">{{ $operations->count() }}</span> --}}
      <span style="font-weight: bold;">3</span>
    </div>
  </div>

  <div class="title">
    Rapport détaillé du client {{ $usager->nom }} (CIN {{ $usager->cin }})
  </div>

  <table>
    <thead>
      <tr>
        <th>N°</th>
        {{-- <th>Numéro d'opération</th> --}}
        <th>Type d'opération</th>
        <th>Date</th>
        {{-- <th>Pièce jointe</th> --}}
      </tr>
    </thead>
    <tbody>
      @forelse($operations as $index => $operation)
        <tr>
          <td class="text-center">{{ $index + 1 }}</td>
          {{-- <td class="text-center">{{ $operation->numero_operation ?? '-' }}</td> --}}
          <td>{{ $operation->operationType->nom }}</td>
          <td>{{ $operation->created_at->format('d/m/Y') }}</td>
          {{-- <td class="text-center">{{ $operation->created_at->format('d/m/Y') == '30/04/2025' ? 'Oui' : 'Non' }}</td> --}}
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center">Aucune opération trouvée</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>

</html>
