@extends('layouts.main')

@php
  // Ambil member dari group (sudah berupa array)
  $members = $group->member ?? [];
@endphp

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>
              Group: {{ $group->name }}
            </h4>
            <a href="{{ route('groups.add-member', $group) }}" class="btn btn-primary mb-2">Tambah
              Member</a>
          </div>
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
                @forelse ($members as $index => $member)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $member['name'] ?? 'N/A' }}</td>
                    <td>{{ $member['whatsapp'] ?? 'Tidak ada' }}</td>
                    <td>
                      <div class="btn-group">
                        <button type="button" class="btn btn-outline-info btn-sm dropdown-toggle waves-effect"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          Pilih
                        </button>
                        <ul class="dropdown-menu">
                          <li><a href="{{ route('groups.edit-member', ['group' => $group, 'whatsapp' => $member['whatsapp']]) }}" class="dropdown-item">Edit</a></li>
                          <li><a href="{{ route('entries.show', $member['name']) }}" class="dropdown-item">Detail</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <form action="{{ route('groups.remove-member', $group) }}" method="POST"
                              class="d-inline delete-form">
                              @csrf
                              @method('DELETE')
                              <input type="hidden" name="name" value="{{ $member['name'] }}">
                              <input type="hidden" name="whatsapp" value="{{ $member['whatsapp'] }}">
                              <button type="submit" class="dropdown-item">
                                Hapus
                              </button>
                            </form>
                          </li>
                        </ul>
                      </div>

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
        <div class="card">
          <div class="card-header">
            <h4>
              Template Laporan
            </h4>
            <a href="{{ route('reports.create', $group) }}" class="btn btn-outline-info mb-2">Tambah</a>
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
                @foreach ($group->reports as $index => $report)
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
                          <li><button class="dropdown-item"
                              onclick="copyToClipboard('{{ $link }}')">Salin</button></li>
                          <li><a href="{{ route('reports.edit', $report) }}" class="dropdown-item">Edit</a></li>
                          <li><a href="{{ route('entries.index', $report) }}" class="dropdown-item">Detail</a></li>
                          <li>
                            <hr class="dropdown-divider">
                          </li>
                          <li>
                            <button class="dropdown-item delete-btn"
                              data-url="{{ route('reports.destroy', $report) }}">Hapus</button>
                          </li>
                        </ul>
                      </div>
                    </td>
                    <td>{{ $report->report_date }}</td>
                    <td>{{ $report->pj_odoj }}</td>
                    <td>{{ $report->pj_bersaksi }}</td>
                    <td>{{ $report->pj_nextday }}</td>
                    <td>{{ $report->entries->count() }} / {{ count($members) }}</td>
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
  <script>
    $(document).ready(function() {
      $('#groupsTable').DataTable();
      $('#reportsTable').DataTable();
    });
  </script>

  <script>
    function copyToClipboard(text) {
      // Cek apakah navigator.clipboard tersedia
      if (navigator.clipboard) {
        navigator.clipboard.writeText(text)
          .then(() => {
            // Tampilkan notifikasi sukses
            Swal.fire({
              icon: 'success',
              title: 'Link berhasil disalin!',
              text: 'Link telah disalin ke clipboard.',
              showConfirmButton: false,
              timer: 1500 // Notifikasi akan hilang setelah 1.5 detik
            });
          })
          .catch(() => {
            // Tampilkan notifikasi error jika gagal
            Swal.fire({
              icon: 'error',
              title: 'Gagal menyalin link',
              text: 'Silakan coba lagi atau salin secara manual.',
              showConfirmButton: false,
              timer: 1500
            });
          });
      } else {
        // Fallback untuk browser yang tidak mendukung navigator.clipboard
        const textarea = document.createElement('textarea');
        textarea.value = text;
        document.body.appendChild(textarea);
        textarea.select();
        try {
          const successful = document.execCommand('copy');
          if (!successful) throw new Error('Gagal menyalin teks');
          Swal.fire({
            icon: 'success',
            title: 'Link berhasil disalin!',
            text: 'Link telah disalin ke clipboard.',
            showConfirmButton: false,
            timer: 1500
          });
        } catch (err) {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menyalin link',
            text: 'Silakan coba lagi atau salin secara manual.',
            showConfirmButton: false,
            timer: 1500
          });
        } finally {
          document.body.removeChild(textarea);
        }
      }
    }
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
