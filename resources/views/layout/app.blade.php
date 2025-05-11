<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('src/img/icon.png') }}" />
    
    <title>MBG Kota Malang | {{ $title }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('src/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('src/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('src/css/css2.css') }}" rel="stylesheet">
    <link href="{{ asset('src/css/dataTables.bootstrap5.css') }}" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        @include('layout.sidebar')
        <div class="main">
            @include('layout.navbar')
            <main class="content">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </main>
            @include('layout.footer')
        </div>
    </div>

    <script src="{{ asset('src/js/app.js') }}"></script>
    <script src="{{ asset('src/js/jquery-3.7.1.js') }}"></script>
    <script src="{{ asset('src/js/dataTables.js') }}"></script>
    <script src="{{ asset('src/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('src/js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('src/js/Chart.min.js') }}"></script>
    <script src="{{ asset('src/js/chartjs-plugin-datalabels.js') }}"></script>
    <script>
        // GLOBAL SETUP TOKEN
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @stack('script')
</body>

</html>
