@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>Group: {{ $report->group->name }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('entries.store', $report) }}" method="POST">
              @csrf

              <div class="form-group mb-3">
                <label class="form-label" for="report_date">Tanggal/Periode Laporan</label>
                <h4>{{ $report->report_date }}</h4>
              </div>

              <!-- Input Nama Member -->
              <div class="form-group mb-3">
                <label class="form-label" for="name">Nama Member</label>
                <select id="name" name="name" class="select2 form-select @error('name') is-invalid @enderror"
                  data-allow-clear="true">
                  <option value="" selected disabled>- Pilih Data -</option>
                  @foreach ($report->group->member ?? [] as $member)
                    <option value="{{ $member['name'] }}" {{ old('name') == $member['name'] ? 'selected' : '' }}>
                      {{ $member['name'] }}
                    </option>
                  @endforeach
                </select>
                @error('name')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Input Jumlah Halaman -->
              <div class="form-group mb-3">
                <label class="form-label" for="recite_amount">Jumlah Halaman yang Dibaca Hari Ini</label>
                <input type="number" name="recite_amount"
                  class="form-control @error('recite_amount') is-invalid @enderror" value="{{ old('recite_amount') }}">
                @error('recite_amount')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Input Juz yang Dibaca -->
              <div class="form-group mb-3">
                <label class="form-label" for="juz">Juz yang Dibaca Hari Ini</label>
                <select id="juz" name="juz" class="select2 form-select @error('juz') is-invalid @enderror"
                  data-allow-clear="true">
                  <option value="" selected disabled>- Pilih Data -</option>
                  @for ($i = 1; $i <= 30; $i++)
                    <option value="Juz {{ $i }}" {{ old('juz') == "Juz $i" ? 'selected' : '' }}>Juz
                      {{ $i }}</option>
                  @endfor
                </select>
                @error('juz')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Input Status ODOJ -->
              <div class="form-group mb-3">
                <label class="form-label" for="status">Status ODOJ</label>
                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror"
                  data-allow-clear="true">
                  <option value="" selected disabled>- Pilih Data -</option>
                  <option value="🐫 = 00:01 - 10:00 WIB"
                    {{ old('status') == '🐫 = 00:01 - 10:00 WIB' ? 'selected' : '' }}>🐫 = 00:01 - 10:00 WIB</option>
                  <option value="🐄 = 10:01 - 18:00 WIB"
                    {{ old('status') == '🐄 = 10:01 - 18:00 WIB' ? 'selected' : '' }}>🐄 = 10:01 - 18:00 WIB</option>
                  <option value="🐏 = 18:01 - 23:00 WIB"
                    {{ old('status') == '🐏 = 18:01 - 23:00 WIB' ? 'selected' : '' }}>🐏 = 18:01 - 23:00 WIB</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Tombol Submit -->
              <button type="submit" class="btn btn-primary">Simpan Laporan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    .select2-container .select2-selection--single {
      height: 38px;
      padding: 6px 12px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 36px;
    }
  </style>
@endpush

@push('scripts')
  <script>
    // Inisialisasi Select2
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: "- Pilih Data -",
        allowClear: true
      });
    });
  </script>
@endpush
