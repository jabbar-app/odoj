@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center my-3">
          <h4 class="text-primary">
            <a href="https://inisiator.com/" class="text-muted fw-light">Home /</a> {{ $group->name }}
          </h4>
          <a href="{{ route('groups.add-member', $group) }}" class="btn btn-md btn-primary mb-2 float-end">Tambah Group</a>
        </div>
        <div class="card">
          <div class="card-datatable table-responsive">
            <table id="groupsTable" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Member</th>
                  <th>Nomor WhatsApp</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @php
                  // Ambil member dari group (sudah berupa array)
                  $members = $group->member ?? [];
                @endphp

                @forelse ($members as $index => $member)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $member['name'] ?? 'N/A' }}</td>
                    <td>{{ $member['whatsapp'] ?? 'Tidak ada' }}</td>
                    <td>
                      <form action="{{ route('groups.remove-member', $group) }}" method="POST"
                        class="d-inline delete-form">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="name" value="{{ $member['name'] }}">
                        <input type="hidden" name="whatsapp" value="{{ $member['whatsapp'] }}">
                        <button type="submit" class="btn btn-danger btn-sm">
                          <i class="fas fa-trash"></i> Hapus
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="4" class="text-center">Tidak ada member.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="row justify-content-center mt-4">
      <div class="col-12">
        <div class="d-flex justify-content-between align-items-center my-3">
          <h4 class="text-primary">
            <span class="text-muted fw-light">Data Laporan</span>
          </h4>
          <a href="{{ route('reports.create', $group) }}" class="btn btn-md btn-primary mb-2 float-end">Tambah Laporan</a>
        </div>
        <div class="card">
          <div class="card-datatable table-responsive">
            <table id="reportsTable" class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>PJ ODOJ</th>
                  <th>PJ Bersaksi</th>
                  <th>PJ Next Day</th>
                  <th>Total Setoran</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($group->reports as $index => $report)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $report->report_date }}</td>
                    <td>{{ $report->pj_odoj }}</td>
                    <td>{{ $report->pj_bersaksi }}</td>
                    <td>{{ $report->pj_nextday }}</td>
                    <td>{{ $report->entries->count() }} / 30</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .table th,
    .table td {
      vertical-align: middle;
    }

    .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.875rem;
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      $('#groupsTable').DataTable();
      $('#reportsTable').DataTable();
    });
  </script>
  <script>
    // Konfirmasi sebelum menghapus member menggunakan SweetAlert2
    document.addEventListener('DOMContentLoaded', function() {
      const deleteForms = document.querySelectorAll('.delete-form');
      deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
          e.preventDefault(); // Mencegah form submit langsung

          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              form.submit(); // Submit form jika dikonfirmasi
            }
          });
        });
      });
    });
  </script>
@endpush
