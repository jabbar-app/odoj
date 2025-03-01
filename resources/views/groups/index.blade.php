@extends('layouts.main')

@section('content')
  <div class="container">
    <h4 class="my-5 text-center">اَلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَا تُهُ</h4>

    <div class="row">
      <div class="col-sm-6 col-lg-4 mb-4">
        @php
          $ayah = getRandomAyah();
        @endphp

        <div class="card bg-primary text-white text-center h-100 p-3">
          <figure class="mb-0">
            <blockquote class="blockquote">
              <p class="arabic-text" style="font-size: 1.5rem; line-height: 2.5rem;">
                {{ $ayah['arabic'] ?? 'Tidak dapat memuat ayat.' }}
              </p>
              <p class="translation-text" style="font-size: 1rem; line-height: 1.5rem;">
                {{ $ayah['translation'] ?? 'Tidak dapat memuat terjemahan.' }}
              </p>
            </blockquote>
            <figcaption class="blockquote-footer mt-2 mb-0 text-white">
              Ayat ke-{{ $ayah['ayah_number'] ?? '0' }} <cite
                title="{{ $ayah['surah'] ?? 'Surah' }}">{{ $ayah['surah'] ?? 'Surah' }}</cite>
            </figcaption>
          </figure>
        </div>
      </div>

      @foreach ($groups as $group)
        <div class="col-sm-6 col-lg-4 mb-4">
          <div class="card text-center">
            <div class="card-body">
              <h5 class="card-title">Group: {{ $group->name }}</h5>
              <p class="card-text">Jumlah Member: {{ count($group->member) }}</p>
              <p class="card-text"><small class="text-muted">Registered
                  {{ $group->created_at->diffForHumans() }}</small></p>

              <div class="d-flex flex-column gap-2 mt-4">
                <a href="{{ route('entries.search') }}" class="btn btn-outline-info">Isi Laporan</a>
                <a href="{{ route('groups.show', $group) }}" class="btn btn-info">Detail Group</a>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <div class="row">
      <div class="col-12 my-4 text-center">
        <a href="{{ route('groups.create') }}" class="btn rounded-pill btn-google-plus waves-effect waves-light">
          <i class="tf-icons ti ti-category-plus ti-xs me-1"></i> Tambah Group
        </a>
      </div>
    </div>
  </div>
@endsection
