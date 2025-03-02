@extends('layouts.main')

@section('content')
  <div class="container py-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-1">Group: {{ $report->group->name }}</h5>
        <p class="card-text">
          Tanggal Laporan: {{ $report->report_date }}
        </p>
      </div>
      <div class="card-body">
        <ul>
          <li>PJ ODOJ: {{ $report->pj_odoj }}</li>
          <li>PJ Bersaksi: {{ $report->pj_bersaksi }}</li>
          <li>PJ Next Day: {{ $report->pj_nextday }}</li>
          <li>Jumlah Setoran: {{ $report->entries->count() }} / {{ count($report->group->member) }}</li>
        </ul>

        <div class="d-flex justify-content-between align-items-center">
          <a href="{{ route('entries.index', $report) }}" class="btn btn-info">Detail</a>
          <div>
            <a href="{{ route('reports.edit', $report) }}" class="btn btn-warning">Edit</a>
            <button class="dropdown-item delete-btn" data-url="{{ route('reports.destroy', $report) }}">Hapus</button>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
