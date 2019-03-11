<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <title>{{config('app/name', 'Test1')}}</title>
    </head>
    <body>
        @include('inc/navbar')
        <div class="container">
            @yield('content')
        </div>
    </body>
</html>
