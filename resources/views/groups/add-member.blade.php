@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <h2 class="mb-4 text-center">Tambah Member Group</h2>
        <div class="card shadow-sm p-4 border-0">
          <form action="{{ route('groups.store-member') }}" method="POST">
            @csrf
            <input type="hidden" name="group_id" value="{{ $group->id }}">

            <!-- Container untuk dynamic rows -->
            <div id="member-rows">
              <div class="member-row mb-3">
                <div class="row">
                  <div class="col-md-5">
                    <label for="name" class="form-label">Nama Member</label>
                    <input type="text" name="members[0][name]" class="form-control" required>
                  </div>
                  <div class="col-md-5">
                    <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                    <input type="text" name="members[0][whatsapp]" class="form-control">
                  </div>
                  <div class="col-md-2 d-flex align-items-end mt-2">
                    <button type="button" class="btn btn-danger btn-remove-row" disabled>
                      Hapus
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <!-- Tombol untuk menambah row -->
            <div class="mb-3">
              <button type="button" id="add-row" class="btn btn-success">
                <i class="fas fa-plus"></i> Tambah Member
              </button>
            </div>

            <!-- Tombol submit -->
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const memberRows = document.getElementById('member-rows');
      const addRowButton = document.getElementById('add-row');
      let rowCount = 1; // Mulai dari 1 karena row pertama sudah ada

      // Fungsi untuk menambah row
      addRowButton.addEventListener('click', function() {
        const newRow = document.createElement('div');
        newRow.classList.add('member-row', 'mb-3');
        newRow.innerHTML = `
          <div class="row">
            <div class="col-md-5">
              <label for="name" class="form-label">Nama Member</label>
              <input type="text" name="members[${rowCount}][name]" class="form-control" required>
            </div>
            <div class="col-md-5">
              <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
              <input type="text" name="members[${rowCount}][whatsapp]" class="form-control">
            </div>
            <div class="col-md-2 d-flex align-items-end mt-2">
              <button type="button" class="btn btn-danger btn-remove-row">
                Hapus
              </button>
            </div>
          </div>
        `;
        memberRows.appendChild(newRow);
        rowCount++;

        // Aktifkan tombol hapus untuk semua row kecuali yang pertama
        document.querySelectorAll('.btn-remove-row').forEach(button => {
          button.disabled = false;
        });
      });

      // Fungsi untuk menghapus row
      memberRows.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove-row')) {
          const row = e.target.closest('.member-row');
          row.remove();

          // Nonaktifkan tombol hapus jika hanya tersisa satu row
          if (document.querySelectorAll('.member-row').length === 1) {
            document.querySelector('.btn-remove-row').disabled = true;
          }
        }
      });
    });
  </script>
@endpush
