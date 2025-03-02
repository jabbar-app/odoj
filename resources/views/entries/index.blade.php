@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row my-4">
      <div class="col-12">
        @include('layouts.ayat')
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Group: {{ $report->group->name }}</h4>
            <p class="mb-1"><span class="text-muted">Tanggal Laporan:</span>
              {{ Carbon\Carbon::parse($report->report_date)->translatedFormat('l, d F Y') }}</p>
            <p class="mb-1"><span class="text-muted">Periode:</span>
              {{ Carbon\Carbon::parse($report->report_date)->translatedFormat('d') }} Ramadhan 1446 H</p>
            <p><span class="text-muted">Jumlah Laporan:</span> {{ count($report->entries) }} /
              {{ count($report->group->member) }} Member</p>
            <a href="{{ route('entries.create', $report) }}" class="btn btn-info">Tambah Data</a>
          </div>
          <div class="card-datatable table-responsive">
            <table id="entriesTable" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Member</th>
                  <th>Jumlah Bacaan</th>
                  <th>Juz</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($entries as $index => $entry)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $entry->name }}</td>
                    <td class="text-nowrap">{{ $entry->recite_amount }} Hlm.</td>
                    <td class="text-nowrap">{{ $entry->juz }}</td>
                    <td class="text-nowrap">{{ $entry->status }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 my-4 text-center">
        <a href="{{ route('groups.show', $report->group) }}"
          class="btn rounded-pill btn-secondary waves-effect waves-light">
          Kembali
        </a>
      </div>
    </div>
  </div>
@endsection

@push('styles')
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('#entriesTable').DataTable();
    });
  </script>
@endpush
