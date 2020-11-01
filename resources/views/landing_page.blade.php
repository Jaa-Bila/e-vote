<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Pemilihan Kepala Desa</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{asset('dist/plugins/fullcalendar/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/plugins/fullcalendar-daygrid/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/plugins/fullcalendar-timegrid/main.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/plugins/fullcalendar-bootstrap/main.min.css')}}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body>
    <nav class=" navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li>
                <h4 class="brand-text ml-3 mt-2">
                    <a href="/" style="color: black;">
                        PEMILIHAN KEPALA DESA
                    </a>
                </h4>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" href="{{route('login')}}">
                    <button class="btn btn-sm" style="width: 100px;">Login</button>
                </a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card elevation-0">
                            <div class="card-body">
                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        @foreach($landingCarousels as $index=>$landingCarousel)
                                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$index}}" @if($index === 0)class="active" @endif></li>
                                        @endforeach
                                    </ol>
                                    <div class="carousel-inner" style="height: 500px;">
                                        @foreach($landingCarousels as $index=>$landingCarousel)
                                            <div class="carousel-item @if($index === 0)active @endif">
                                                <img class="d-block w-100" style="height:500px"
                                                    src="{{$landingCarousel->path}}">
                                                <div style="z-index: 2; position: absolute; top: 10%; left: 5%; font-size: 30px">{{ $landingCarousel->text }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="card elevation-0 ml-5">
                            <ul>
                                <li class="nav-link"><a href="#" style="color: black;"><strong>Beranda</strong></a></li>
                                <li class="nav-link"><a href="{{route('profile')}}"
                                        style="color: black;"><strong>Profil</strong></a></li>
                                <li class="nav-link"><a href="{{route('visi_misi')}}" style="color: black;"><strong>Visi
                                            & Misi</strong></a> </li>
                                <li class="nav-link"><a href="{{route('informasi_pemilihan')}}"
                                        style="color: black;"><strong>Informasi Pemilihan</strong></a>
                                </li>
                                <li class="nav-link"><a href="{{route('panduan_memilih')}}"
                                        style="color: black;"><strong>Panduan Memilih</strong></a></li>
                                <li class="nav-link"><a href="{{route('jumlah_pemilih')}}"
                                        style="color: black;"><strong>Jumlah Pemilih</strong></a></li>
                                <li class="nav-link"><a href="{{route('galeri')}}"
                                        style="color: black;"><strong>Galeri</strong></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="card elevation-0 border"
                                    style="border-width: 3px !important; border-color: black !important;">
                                    <div class="card-body">
                                        <marquee width="100%" direction="left" height="30px" scrollamount="8">
                                            <p style="text-align: center;">
                                                @foreach($marqueeTexts as $marqueeText)
                                                    {{$marqueeText->text}}
                                                @endforeach
                                            </p>
                                        </marquee>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <a href="#" style="color: black;" data-toggle="modal" data-target="#modal-lg">
                                    <h1 class="mt-2 ml-3"><span><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </h1>
                                </a>
                            </div>
                        </div>
                        <div class="row mr-5 mt-4 justify-content-center">
                            @foreach($candidates as $index=>$candidate)
                            <div class="col-md-4">
                                <img class="d-block w-100"
                                    src="{{ asset($candidate->foto) }}"
                                    alt="Foto Kandidat {{$index + 1}}" style="height: 375px">
                                    <h5 class="text-center mt-3">Calon {{$index + 1}}</h5>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="modal-lg">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Calendar</h4>
                            </div>
                            <div class="modal-body">
                                <div class="card card-primary">
                                    <div class="card-body p-0">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <strong>Copyright © {{date("Y")}} </strong> All rights reserved
            </div>
        </div>
</body>

<script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script src="{{ asset('dist/plugins/moment/moment.min.js')}}"></script>
<script src="{{ asset('dist/plugins/fullcalendar/main.min.js')}}"></script>
<script src="{{ asset('dist/plugins/fullcalendar-daygrid/main.min.js')}}"></script>
<script src="{{ asset('dist/plugins/fullcalendar-timegrid/main.min.js')}}"></script>
<script src="{{ asset('dist/plugins/fullcalendar-interaction/main.min.js')}}"></script>
<script src="{{ asset('dist/plugins/fullcalendar-bootstrap/main.min.js')}}"></script>
<script>
    $(function () {
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var calendarEl = document.getElementById('calendar');

        var calendar = new Calendar(calendarEl, {
            plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
            'themeSystem': 'bootstrap',
        });

        calendar.render();

    })

</script>

</html>
