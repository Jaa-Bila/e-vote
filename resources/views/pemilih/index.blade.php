@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{asset('dist/plugins/datatables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('dist/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
@endsection

@section('title', 'Pemilih')

@section('content')
<div class="card card-primary">
    <div class="card-body" style="display: block;">
        @if(in_array('ADMIN', Session::get('user_roles')))
            <a href="{{route('pemilih.create')}}"><button type="button" class="btn btn-primary">+ Tambahkan
                    Pemilih</button></a>
        @endif
        
        @include('message_info')
        <div class="mt-3">
            <table class="data-table display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>No Urut</th>
                        <th>ID</th>
                        <th>Nama Pemilih</th>
                        <th>L/P</th>
                        <th>NIK</th>
                        <th>Pekerjaan</th>
                        <th>Foto</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
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
<script src="{{asset('dist/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('dist/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
<script type="text/javascript">
    $(function () {
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('pemilih.index') }}",
            render: 'image',
            columns: [{
                    data: 'no_urut',
                    name: 'no_urut',
                },
                {
                    data: 'no_ktp',
                    name: 'no_ktp',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'jenis_kelamin',
                    name: 'jenis_kelamin',
                },
                {
                    data: 'nik',
                    name: 'nik',
                },
                {
                    data: 'pekerjaan',
                    name: 'pekerjaan',
                },
                {
                    data: 'image',
                    name: 'image',
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
<script>
    function takeAPhoto(id) {
        var canvas = document.getElementById('canvas');
        var context = canvas.getContext('2d');
        var video = document.getElementById('video');
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                video: true
            }).then(function (stream) {
                video.srcObject = stream;
                video.play();
            });
        }


        document.getElementById("snap").addEventListener("click", function () {
            context.drawImage(video, 0, 0, 640, 480);

            const dataURL = canvas.toDataURL("image/png")
            let data = {
                foto_pengawas: dataURL,
                user_id: id,
                _token: "{{csrf_token()}}"
            }

            $.ajax({
                type: "POST",
                url: "{{route('pemilih.foto_pengawas')}}",
                data: data,
                success: (response) => {
                    window.location.href = "/pemilih"
                }
            });
        });
    }

</script>
<script>
    function confirmUser(id) {
        $.ajax({
            type: 'POST',
            url: `/pemilih/activate/${id}`,
            data: {
                _token: "{{csrf_token()}}"
            },
            success: () => {
                window.location.reload()
            }
        })
    }
</script>
<script>
    function deleteUser(id) {
        $.ajax({
            type: 'DELETE',
            url: `/pemilih/${id}`,
            data: {
                _token: "{{csrf_token()}}"
            },
            success: () => {
                window.location.reload()
            }
        })
    }
</script>
@endsection
