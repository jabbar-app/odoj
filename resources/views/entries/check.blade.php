@extends('layouts.main')

@section('content')
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4 class="mb-0">Lihat Detail Laporan Member</h4>
          </div>
          <div class="card-body">
            @if (empty($group))
              <form action="{{ route('entries.check') }}" method="GET">
                <div class="form-group mb-3">
                  <label class="form-label" for="group_id">Nama Group</label>
                  <select id="group_id" name="group_id"
                    class="select2 form-select @error('group_id') is-invalid @enderror" data-allow-clear="true" required>
                    <option value="" selected disabled>- Pilih Data -</option>
                    @foreach ($groups as $group)
                      <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                      </option>
                    @endforeach
                  </select>
                  @error('group_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lihat Group</button>
              </form>
            @else
              @php
                // Pastikan $group dan $group->member sudah terdefinisi
                $members = $group->member ?? [];
              @endphp

              <form action="{{ route('entries.show') }}" method="GET">
                <div class="form-group mb-3">
                  <label class="form-label" for="name">Nama Member</label>
                  <select id="name" name="name" class="select2 form-select @error('name') is-invalid @enderror"
                    data-allow-clear="true" required>
                    <option value="" selected disabled>- Pilih Member -</option>
                    @foreach ($members as $member)
                      <option value="{{ $member['name'] }}" {{ old('name') == $member['name'] ? 'selected' : '' }}>
                        {{ $member['name'] }}
                      </option>
                    @endforeach
                  </select>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <button type="submit" class="btn btn-primary">Lihat Detail</button>
              </form>
            @endif
          </div>
        </div>
      </div>
    </div>

    <div class="row text-center my-4">
      <div class="col-12">
        <a href="{{ route('landing') }}" class="btn rounded-pill btn-secondary waves-effect waves-light">
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
        placeholder: "- Pilih Data -",
        allowClear: true
      });
    });
  </script>
@endpush
