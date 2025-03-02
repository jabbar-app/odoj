{{-- {{ dd(empty($reports)) }} --}}
@extends('layouts.main')

@section('content')
  <div class="container py-4">
    <div class="card">
      <div class="card-header">
        <h1>Daftar Laporan</h1>
        <a href="/" class="btn btn-light mb-3">Kembali</a>
      </div>
      <div class="card-datatable table-responsive">
        <table id="reportsTable" class="table">
          <thead>
            <tr>
              <th>No</th>
              <th>Tautan</th>
              <th>Tanggal</th>
              <th>PJ ODOJ</th>
              <th>PJ Bersaksi</th>
              <th>PJ Next Day</th>
              <th>Total Setoran</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reports as $index => $report)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle waves-effect"
                      data-bs-toggle="dropdown" aria-expanded="false">
                      Pilih
                    </button>
                    @php
                      $link = "https://inisiator.com/odoj/$report->id/entries/create";
                    @endphp
                    <ul class="dropdown-menu" style="">
                      <li><button class="dropdown-item" onclick="copyToClipboard('{{ $link }}')">Salin</button>
                      </li>
                      <li><a href="{{ route('reports.edit', $report) }}" class="dropdown-item">Edit</a></li>
                      <li><a href="{{ route('entries.index', $report) }}" class="dropdown-item">Detail</a></li>
                      <li>
                        <hr class="dropdown-divider">
                      </li>
                      <li>
                        <button class="dropdown-item delete-report-btn"
                          data-url="{{ route('reports.destroy', $report) }}">Hapus</button>
                      </li>
                    </ul>
                  </div>
                </td>
                <td>{{ $report->report_date }}</td>
                <td>{{ $report->pj_odoj }}</td>
                <td>{{ $report->pj_bersaksi }}</td>
                <td>{{ $report->pj_nextday }}</td>
                <td>{{ $report->entries->count() }} / {{ count($report->group->member) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
