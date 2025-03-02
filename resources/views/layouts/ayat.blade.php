@php
  $ayah = getRandomAyah();
@endphp

<div class="card bg-primary text-white text-center p-3">
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
