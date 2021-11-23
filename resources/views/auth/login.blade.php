<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>E-Vote | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('dist/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('dist/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
        html, body, .container {
            height: 100vh !important;
        }
    </style>
</head>
<body>
    @if(session()->has('success'))
        <script type="text/javascript">
            $(function () {
                swal("Deleted!", "Data has been Deleted.", "success"),
                    swal({
                        title: {{ session()->get('success') }},
                        text: "Your Custom or Dynamic SUccess message put here",
                        type: "success"})

            });
        </script>
    @endif
<div class="container">
    <h1 class="mt-3 mb-0">Pemilihan Kades</h1>
    <div class="row h-100">
        <div class="col-4 my-auto">
            <img src="{{asset('images/login.png')}}" alt="logo" width="300">
        </div>
        <div class="col-8 my-auto">
            @include('message_info')
            <h1>Silahkan Login</h1>
            <form action="{{route('login')}}" method="post" style="width: 100%">
                @csrf
                <div class="input-group mb-3">
                    <input id="no_ktp" type="text" class="form-control{{ $errors->has('no_ktp') ? ' is-invalid' : '' }}" name="no_ktp" placeholder="Scan KTP Anda" required autofocus>
                    @if ($errors->has('no_ktp'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('no_ktp') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-4 text-center">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
                    </div>
                </div>
                <div class="card-subtitle mt-2">
                    Silahkan hubungi admin jika anda belum terdaftar sebagai pemilih.
                </div>
            </form>
        </div>
    </div>
</div>


<!-- jQuery -->
<script src="{{asset('dist/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('dist/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>

</body>
</html>
