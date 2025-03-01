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

  <title>
    @if (!empty($title))
      {{ $title }} &nbsp;|&nbsp;
    @endif
    Generasi Cakrawala
  </title>

  <meta name="description" content="" />
  @include('layouts.css')
  @yield('styles')
</head>

<body>
  @yield('content')
  @include('layouts.js')
  @stack('scripts')
</body>

</html>
