<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
  data-theme="theme-default" data-assets-path="{{ asset('assets/') }}"
  data-template="vertical-menu-template-no-customizer">

<head>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-BYNE247EQ4"></script>
  <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
      dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-BYNE247EQ4');
  </script>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>ODOJ by Generasi Cakrawala</title>
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/company/favicon.png') }}" />

  <meta name="description" content="One Day One Juz (ODOJ) reporting management app.">
  <meta name="keywords" content="ODOJ, One Day One Juz, Gencar, Generasi Cakrawala, Ramadhan, Tilawah">

  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ request()->url() }}">
  <meta property="og:title" content="ODOJ by Generasi Cakrawala">
  <meta property="og:description" content="One Day One Juz (ODOJ) reporting management app.">
  {{-- <meta property="og:image" content="{{ asset('assets/img/company/profpic.png') }}"> --}}

  <meta property="twitter:card" content="summary_large_image">
  <meta property="twitter:url" content="{{ request()->url() }}">
  <meta property="twitter:title" content="ODOJ by Generasi Cakrawala">
  <meta property="twitter:description" content="One Day One Juz (ODOJ) reporting management app.">
  {{-- <meta property="twitter:image" content="{{ asset('assets/img/company/profpic.png') }}"> --}}

  @include('layouts.css')
  @yield('styles')
</head>

<body>
  @yield('content')
  @include('layouts.js')
  @stack('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Tangkap semua tombol hapus
      const deleteButtons = document.querySelectorAll('.delete-btn');

      deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault(); // Mencegah default behavior

          const url = this.getAttribute('data-url'); // Ambil URL penghapusan

          // Tampilkan SweetAlert2
          Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
          }).then((result) => {
            if (result.isConfirmed) {
              // Jika dikonfirmasi, kirim request penghapusan
              window.location.href = url;
            }
          });
        });
      });
    });
  </script>
</body>

</html>
