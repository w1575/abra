<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $title ?? 'base title' }} </title>

    <link rel="stylesheet" href="{{ asset('front/bootstrap/css/bootstrap-reboot.css')  }}">
    <link rel="stylesheet" href="{{ asset('front/bootstrap/css/bootstrap.css')  }}">
    <link rel="stylesheet" href="{{ asset('front/bootstrap/css/bootstrap-grid.css')  }}">
    <link rel="stylesheet" href="{{ asset('front/bootstrap/css/bootstrap-utilities.css')  }}">

    <link rel="stylesheet" href="{{ asset('front/css/old.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/app.css') }}">

    @livewireStyles

</head>
<body>

    {{ $slot }}

    @livewireScripts
    <script src="{{ asset('front/bootstrap/js/bootstrap.js') }}"></script>
    <script src="{{ asset('front/bootstrap/js/bootstrap.bundle.js') }}"></script>
</body>
</html>
