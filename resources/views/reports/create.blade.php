@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 text-center">Tambah Laporan Baru</h2>
        <div class="card shadow-sm p-4 border-0">
          <form action="{{ route('reports.store') }}" method="POST">
            @csrf
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            <div class="mb-3">
              <label for="report_date" class="form-label">Tanggal</label>
              <input type="date" name="report_date" id="report_date" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="pj_odoj" class="form-label">Nama PJ ODOJ</label>
              <input type="text" name="pj_odoj" id="pj_odoj" class="form-control">
            </div>
            <div class="mb-3">
              <label for="pj_bersaksi" class="form-label">Nama PJ Bersaksi</label>
              <input type="text" name="pj_bersaksi" id="pj_bersaksi" class="form-control">
            </div>
            <div class="mb-3">
              <label for="pj_nextday" class="form-label">Nama PJ Next Day</label>
              <input type="text" name="pj_nextday" id="pj_nextday" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
