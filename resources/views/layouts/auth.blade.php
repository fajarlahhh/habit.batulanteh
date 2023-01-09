<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Habit | {{ config('constant.perusahaan') }}</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="/assets/css/material/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->
    @livewireStyles
</head>

<body class="pace-top">
    <div id="page-loader" class="fade show">
        <div class="material-loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                    stroke-miterlimit="10"></circle>
            </svg>
            <div class="message">Loading...</div>
        </div>
    </div>
    <div id="page-container" class="fade">
        <div class="login login-with-news-feed">
            <div class="news-feed">
                <div class="news-image" style="background-image: url(../assets/img/login.jpg)"></div>
                <div class="news-caption">
                    <h4 class="caption-title">{{ config('constant.perusahaan') }}</h4>
                    <p>
                        {{ config('constant.alamat') }}
                    </p>
                </div>
            </div>
            <div class="right-content">
                <div class="login-header">
                    <div class="brand">
                        <span class="logo"></span> <b>Habit</b>
                        <small>Billing System dan Baca Meter</small>
                    </div>
                    <div class="icon">
                        <i class="fa fa-sign-in-alt"></i>
                    </div>
                </div>
                @livewire('auth.login')
            </div>
        </div>
    </div>

    @livewireScripts

    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/theme/material.min.js"></script>

    @stack('scripts')
</body>

</html>
