@extends('layouts.main')

@section('content')
  <div class="container py-4">
    <div class="card mb-4">
      <div class="card-header">
        <h4 class="card-title mb-0">Detail Laporan {{ request('name') }}</h4>
      </div>
      <div class="card-body">
        <p class="card-text mb-1"><span class="text-muted">Group:</span> {{ $entries->first()->report->group->name }}</p>
        <p class="card-text mb-1"><span class="text-muted">Tanggal Bergabung:</span> 1 Ramadhan 1446 H</p>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-header">
        <h4 class="card-title">Statistik Tilawah Harian</h4>
      </div>
      <div class="card-body">
        <div id="barChart"></div>
      </div>
    </div>
    <div class="card mb-4">
      <div class="card-header">
        <h4 class="card-title">Data Laporan</h4>
      </div>
      <div class="card-datatable table-responsive">
        <table id="entriesTable" class="table">
          <thead>
            <tr>
              <th>Waktu</th>
              <th>Jumlah Bacaan</th>
              <th>Juz</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($entries as $entry)
              <tr class="text-nowrap">
                <td>{{ \Carbon\Carbon::parse($entry->report->report_date)->translatedFormat('j F Y') }}</td>
                <td>{{ $entry->recite_amount }} Hlm.</td>
                <td>{{ $entry->juz }}</td>
                <td>{{ $entry->status }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      $('#entriesTable').DataTable();
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Data dari controller
      var groupedEntries = {!! json_encode($groupedEntries) !!};

      // Format data untuk ApexCharts
      var labels = groupedEntries.map(function(entry) {
        return new Date(entry.date).toLocaleDateString(); // Format tanggal
      });

      var data = groupedEntries.map(function(entry) {
        return entry.total_recite_amount; // Ambil total jumlah halaman
      });

      // Konfigurasi ApexCharts
      var options = {
        chart: {
          type: 'bar',
          height: 350
        },
        series: [{
          name: 'Jumlah Halaman Dibaca',
          data: data
        }],
        xaxis: {
          categories: labels,
          title: {
            text: 'Tanggal'
          }
        },
        yaxis: {
          title: {
            text: 'Jumlah Halaman'
          },
          min: 0
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '55%',
            endingShape: 'rounded'
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function(val) {
              return val + " halaman";
            }
          }
        }
      };

      // Render chart
      var chart = new ApexCharts(document.querySelector("#barChart"), options);
      chart.render();
    });
  </script>
@endpush
