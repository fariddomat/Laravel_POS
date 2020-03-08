<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
  <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap1.min.css') }}">

</head>
<body style="">
    <div id="app">
        
        <h3 class="bg-primary text-center m-3 p-3 text-white">Welcome To POS Control Management System</h3>

        <main class="py-4">
            @yield('content')
        </main>

        
        <footer class="main-footer">
            
            <strong>Copyright &copy; 2019-2020 <a href="https://www.linkedin.com/in/fariddomat/"> Fariddomat</a>.</strong> All rights
            reserved.
          </footer>

    </div>
</body>
</html>
