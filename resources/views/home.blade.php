<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>HABIT</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="/assets/css/one-page-parallax/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->
</head>

<body data-spy="scroll" data-target="#header" data-offset="51">
    <div id="page-container" class="fade">
        <div id="header" class="header navbar navbar-transparent navbar-fixed-top navbar-expand-lg">
            <!-- begin container -->
            <div class="container">
                <!-- begin navbar-brand -->
                <a href="index.html" class="navbar-brand">
                    <span class="brand-logo"></span>
                    <span class="brand-text">
                        <span class="text-primary">HABIT</span> {{ config('constant.perusahaan') }}
                    </span>
                </a>
                <!-- end navbar-brand -->
                <!-- begin navbar-toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#header-navbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- end navbar-header -->
            </div>
            <!-- end container -->
        </div>

        <div id="home" class="content has-bg home">
            <!-- begin content-bg -->
            <div class="content-bg" style="background-image: url(../assets/img/home.jpg);" data-paroller="true"
                data-paroller-factor="0.5" data-paroller-factor-xs="0.25">
            </div>
            <!-- end content-bg -->
            <!-- begin container -->
            <div class="container home-content">
                <h1>Welcome to HABIT</h1>
                <h3>{{ config('constant.perusahaan') }}</h3>
                <p>
                    Ini adalah aplikasi yang dibangun untuk kebutuhan Billing System dan Baca Meter
                </p>
                @if (auth()->check())
                    <a href="/dashboard" class="btn btn-theme btn-primary">KE DASHBOARD</a>
                @else
                    <a href="/login" class="btn btn-theme btn-primary">LOGIN DI SINI</a>
                @endif
                <br />
            </div>
            <!-- end container -->
        </div>

        <div id="footer" class="footer">
            <div class="container">
                <div class="footer-brand">
                    <div class="footer-brand-logo"></div>
                    HABIT
                </div>
                <p>
                    &copy; Copyright 2023 <br />
                    An admin & front end theme with serious impact
                </p>
                <p class="social-list">
                    <a href="#"><i class="fab fa-facebook-f fa-fw"></i></a>
                    <a href="#"><i class="fab fa-instagram fa-fw"></i></a>
                    <a href="#"><i class="fab fa-twitter fa-fw"></i></a>
                    <a href="#"><i class="fab fa-google-plus-g fa-fw"></i></a>
                </p>
            </div>
        </div>

    </div>

    <script src="../assets/js/one-page-parallax/app.min.js"></script>
</body>

</html>
