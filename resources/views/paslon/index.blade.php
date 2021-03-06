@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
@endsection

@section('title', 'Calon')

@section('content')
    <div class="card card-primary">
        <div class="card-body" style="display: block;">
            @if(in_array('ADMIN', Session::get('user_roles')))
                <a href="{{route('calon.create')}}"><button type="button" class="btn btn-primary">+ Tambahkan Calon</button></a>
            @endif
            @include('message_info')
            <div class="mt-3">
                <table class="data-table display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>TTL</th>
                        <th>Agama</th>
                        <th>L/P</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                        <th>Desa</th>
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
                ajax: "{{ route('calon.index') }}",
                render: 'image',
                columns: [
                    {data: 'no_urut_calon', name: 'no_urut_calon'},
                    {data: 'name', name: 'name'},
                    {data: 'ttl', name: 'ttl'},
                    {data: 'agama', name: 'agama'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'pendidikan_terakhir', name: 'pendidikan_terakhir'},
                    {data: 'pekerjaan', name: 'pekerjaan'},
                    {data: 'desa_kelurahan', name: 'desa_kelurahan'},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
    <script>
    function confirmUser(id) {
        $.ajax({
            type: 'POST',
            url: `/calon/activate/${id}`,
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
            url: `/calon/${id}`,
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
