<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">

        <title>Tudu</title>
    </head>
    <body>
        <div id="app"></div>
        <script src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>
