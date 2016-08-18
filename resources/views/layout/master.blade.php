<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KrabTracker</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap-theme.min.css">

    @stack('css')
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">

</head>
<body>
<div id="wrap">
    @include('layout.partials.navigation')

    <div class="container content">
        @yield('content')
    </div>
</div>

@include('layout.partials.footer')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>

@stack('javascript')

</body>
</html>