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

    <title>Vote Page</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @yield('css')
</head>

<body class="hold-transition sidebar-mini">
<div class="content">
    <div class="container-fluid">
        <div class="col-12 text-center">
            <h1 style="font-weight: bold">CALON KEPALA DESA</h1>
        </div>
        <div class="row justify-content-around" style="margin-top: 24px">
            @foreach($datas as $data)
                <div class="col-md-3" style="max-width: 300px">
                    <div class="card card-widget widget-user">
                        <div class="card-footer text-center">
                            <img class="mt-3 card-img-top" style="height: 300px" src="{{$data->foto_pengawas !== null ? asset($data->foto_pengawas) : asset('storage/image/user.jpg') }}"
                                 alt="User Avatar">
                        </div>
                        <div class="card-footer">
                            <div class="row align-items-end" style="height: 175px">
                                <div class="col-12 text-center mb-5">
                                    <h3 class="text-center text-bold">{{$data->name}}</h3>
                                    <button type="button" onclick="vote({{$data->id}})"
                                            class="btn btn-success text-center" style="width: 120px;"
                                            data-toggle="modal" data-target="#modal-lg" data-backdrop="static"
                                            data-keyboard="false">PILIH CALON</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@include('layouts.footer')

    <script src="{{ asset('dist/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <!-- Active SideBar -->
    <script>
        $('ul.nav-treeview li').find('a').each(function () {
            var link = new RegExp($(this).attr('href'));
            if (link.test(document.location.href)) {
                if (!$(this).parents().hasClass('active')) {
                    $(this).parents('li').addClass('menu-open');
                    $(this).parents().addClass("active");
                    $(this).addClass("active"); //Add this too
                }
            }
        });
    </script>
    <script>
        function vote(id) {
            let data = {
                paslon_id: id,
                _token: "{{csrf_token()}}"
            }

            $.ajax({
                type: "POST",
                url: "{{route('pemilih.vote')}}",
                data: data,
                success: (response) => {
                    window.location.href = "{{route('login')}}"
                },
                error: (error) => {
                    console.log(error)
                }
            });
        }
    </script>
</body>

</html>
