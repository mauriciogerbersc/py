<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="">
    <meta name="author" content="gerber">
    <meta name="_token" content="{{csrf_token()}}" />

    <title>{{ config('app.name', 'Acesso ao Sistema ') }}</title>

    @hasSection('vendor')
    <!-- vendor css -->
    <link href="{{asset('lib/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/ionicons/css/ionicons.min.css')}}" rel="stylesheet">

    @yield('vendor')
    @endif

    <!-- DashForge CSS -->
    <link rel="stylesheet" href="{{asset('css/dashforge.css')}}">
    @hasSection('css')
    @yield('css')
    @endif
</head>

<body>
    
    @component('component_navbar', [ "current" => $current ?? '' ])
    @endcomponent

    <main>
        @hasSection('body')
        @yield('body')
        @endif
    </main>

    <footer class="footer">
        <div>
            <span>&copy; 2019 ParkEyes v1.0.0. </span>
            <span><a href="https://sbtrade.com.br/">SBtrade</a></span>
        </div>
    </footer>

    <script src="{{asset('lib/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('lib/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    @hasSection('js')
    @yield('js')
    @endif
</body>

</html>