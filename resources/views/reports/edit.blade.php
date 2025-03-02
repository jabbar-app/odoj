@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 text-center">Edit Laporan</h2>
        <div class="card shadow-sm p-4 border-0">
          <form action="{{ route('reports.update', $report) }}" method="POST">
            @csrf
            @method('PUT') <!-- Gunakan method PUT untuk update -->

            <input type="hidden" name="group_id" value="{{ $report->group_id }}">

            <div class="mb-3">
              <label for="report_date" class="form-label">Tanggal</label>
              <input type="date" name="report_date" id="report_date" class="form-control"
                value="{{ $report->report_date }}" required>
            </div>

            <div class="mb-3">
              <label for="pj_odoj" class="form-label">Nama PJ ODOJ</label>
              <input type="text" name="pj_odoj" id="pj_odoj" class="form-control" value="{{ $report->pj_odoj }}">
            </div>

            <div class="mb-3">
              <label for="pj_bersaksi" class="form-label">Nama PJ Bersaksi</label>
              <input type="text" name="pj_bersaksi" id="pj_bersaksi" class="form-control"
                value="{{ $report->pj_bersaksi }}">
            </div>

            <div class="mb-3">
              <label for="pj_nextday" class="form-label">Nama PJ Next Day</label>
              <input type="text" name="pj_nextday" id="pj_nextday" class="form-control"
                value="{{ $report->pj_nextday }}">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('reports.show', $report) }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
