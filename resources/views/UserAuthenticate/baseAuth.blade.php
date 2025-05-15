<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('bootstrap/css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{asset('Authenticate/logSin.css')}}" rel="stylesheet">
    <title>@yield('AuthTiltle') | {{env('APP_NAME')}}</title>
    <style>
        
        .containerSet{
            background: url('images/background.jpg') no-repeat fixed center;
            background-size: cover;
            font-family: sans-serif;
            height: 100vh;
            position: relative;
            padding: 0px;
            overflow: hidden;
        }
        .containerSet >div:first-of-type{
            position: absolute;
            height: 100%;
            width: 100%;
            {{--  border:3px solid black;  --}}
            backdrop-filter:blur(50px);

        }
      
    </style>
    @section('CustomCSS')
        
    @show
</head>
<body>
    <div class="container-fluid border w-100 containerSet">
        <div class=""></div>
       
        <div class="row ms-0 justify-content-center w-100 pageSet" style="position: fixed;z-inedx:20;top: @yield('topMargin');">
            @section("commonAuth")
            @show
        </div>
       
    </div>
    <script src="{{ asset('bootstrap/js/jQuery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/all.js') }}"></script>
    @section('CustomJS')
        
    @show
</body>
</html>