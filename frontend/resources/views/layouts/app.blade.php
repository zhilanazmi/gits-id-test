<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}" sizes="16x16">
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/css/remixicon.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lib/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lib/dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/lib/flatpickr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  @stack('styles')
</head>
<body class="dark:bg-neutral-800 bg-neutral-100 dark:text-white">

@include('partials.sidebar')

<main class="dashboard-main">
  @include('partials.header')

  <div class="dashboard-main-body">
    @if(session('success'))
      <div class="bg-success-100 dark:bg-success-600/25 text-success-600 dark:text-success-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
        <span>{{ session('success') }}</span>
        <button onclick="this.parentElement.remove()" class="text-lg">&times;</button>
      </div>
    @endif

    @if(session('error'))
      <div class="bg-danger-100 dark:bg-danger-600/25 text-danger-600 dark:text-danger-400 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
        <span>{{ session('error') }}</span>
        <button onclick="this.parentElement.remove()" class="text-lg">&times;</button>
      </div>
    @endif

    @yield('content')
  </div>

  @include('partials.footer')
</main>

<script src="{{ asset('assets/js/lib/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/simple-datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/iconify-icon.min.js') }}"></script>
<script src="{{ asset('assets/js/lib/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/flowbite.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('scripts')

</body>
</html>
