@extends('layouts.dashboard')

@section('content')
  <div class="row mb-4">
    <div class="col-xl-6 col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h3 class="mb-2">
            Rp{{ number_format(80, 0, ',', '.') }},-
          </h3>
          <span class="text-muted">Estimasi Penghasilan</span>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h3 class="mb-2">
            {{ number_format(80, 0, ',', '.') }}
          </h3>
          <span class="text-muted">Total Artikel Views</span>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
      <div class="card">
        <div class="card-body">
          <h3 class="mb-2">{{ $reports->name }}</h3>
          <span class="text-muted">Today's Report: 2 / 30</span>
        </div>
      </div>
    </div>
  </div>

  @include('dashboard.stats')

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3 class="m-0">Daftar Artikel</h3>
    <a href="{{ route('articles.create') }}" target="_blank" class="btn btn-primary">Buat Artikel Baru</a>
  </div>

  <div class="card">
    <div class="card-datatable table-responsive">
      <table id="articlesTable" class="table">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Status</th>
            <th>Views</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($articles as $article)
            <tr>
              <td>{{ $article->title }}</td>
              <td>{{ $article->category->title ?? '-' }}</td>
              <td>{{ ucfirst($article->status) }}</td>
              <td>{{ number_format($article->stats->sum('views'), 0, ',', '.') }}</td>
              <td class="d-flex gap-2">
                <a href="{{ route('articles.show', $article->slug) }}" target="_blank" class="btn btn-info btn-sm">
                  Lihat
                </a>
                <a href="{{ route('articles.edit', $article->slug) }}" class="btn btn-warning btn-sm">
                  Edit
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{-- <div class="mt-4">
    {{ $articles->links() }}
  </div> --}}
@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      $('#articlesTable').DataTable({
        pageLength: 10,
        lengthChange: true,
        order: [
          [3, 'asc']
        ]
      });
    });
  </script>
@endpush
