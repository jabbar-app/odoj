@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0">Isi Laporan</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('entries.find') }}" method="POST">
              @csrf

              <!-- Cari Nama Laporan -->
              <div class="form-group mb-3">
                <label class="form-label" for="report_id">Periode Laporan</label>
                <select id="report_id" name="report_id"
                  class="select2 form-select @error('report_id') is-invalid @enderror" data-allow-clear="true" required>
                  <option value="" selected disabled>- Pilih Data -</option>
                  @foreach ($reports as $report)
                    <option value="{{ $report->id }}" {{ old('report_id') == $report->id ? 'selected' : '' }}>
                      {{ $report->report_date }}
                    </option>
                  @endforeach
                </select>
                @error('report_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Tombol Submit -->
              <button type="submit" class="btn btn-primary">Isi Laporan</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="row text-center my-4">
      <div class="col-12">
        <a href="{{ route('groups.show', $report->group) }}"
          class="btn rounded-pill btn-secondary waves-effect waves-light">
          Kembali
        </a>
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
        placeholder: "- Pilih Laporan -",
        allowClear: true
      });
    });
  </script>
@endpush
