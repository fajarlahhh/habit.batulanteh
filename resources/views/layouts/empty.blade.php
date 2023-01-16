<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>HABIT | @yield('title')</title>

    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link rel="shortcut icon" href="/assets/img/logo.png" type="image/x-icon">

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="/assets/css/material/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    @stack('css')

    @livewireStyles
</head>

<body>
    @yield('content')
</body>

</html>
