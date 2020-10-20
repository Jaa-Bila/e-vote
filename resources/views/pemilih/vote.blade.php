@extends('layouts.admin')

@section('content')
    <div class="col-12 text-center">
        <h1 style="font-weight: bold">CALON KEPALA DESA</h1>
    </div>
    <div class="row justify-content-around" style="margin-top: 24px">
        @foreach($datas as $data)
            <div class="col-md-3" style="max-width: 300px">
                <div class="card card-widget widget-user">
                    <div class="card-footer text-center">
                        <img class="mt-3 card-img-top" style="height: 300px" src="{{asset($data->foto)}}" alt="User Avatar">
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-end" style="height: 175px">
                            <div class="col-12 text-center mb-5">
                                <h3 class="text-center text-bold">{{$data->name}}</h3>
                                <button type="button" onclick="takeAPhoto({{$data->id}})" class="btn btn-success text-center" style="width: 120px;" data-toggle="modal" data-target="#modal-lg" data-backdrop="static" data-keyboard="false">PILIH CALON</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Take a selfie!</h4>
                </div>
                <div class="modal-body">
                    <video id="video" width="640" height="480" autoplay></video>
                    <button id="snap">Snap Photo</button>
                    <canvas id="canvas" width="640" height="480"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    function takeAPhoto(id)
    {
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var video = document.getElementById('video');
        if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                video.srcObject = stream;
                video.play();
            });
        }


        document.getElementById("snap").addEventListener("click", function() {
            context.drawImage(video, 0, 0, 640, 480);

            const dataURL = canvas.toDataURL("image/png")
            let data = {
                paslon_id: id,
                foto_selfie: dataURL,
                user_id: {{auth()->user()->id}},
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
        });
    }
</script>
@endsection
