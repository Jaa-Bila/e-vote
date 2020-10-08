@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
@endsection

@section('title', 'Admin')

@section('content')
    <div class="card card-primary">
        <div class="card-body" style="display: block;">
            <a href="{{route('admin.create')}}"><button type="button" class="btn btn-primary">+ Tambahkan Admin</button></a>

            @include('message_info')
            <div class="mt-3">
                <table class="data-table display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
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
                ajax: "{{ route('admin.index') }}",
                render: 'image',
                columns: [
                    {data: 'no_ktp', name: 'no_ktp'},
                    {data: 'name', name: 'name'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'nik', name: 'nik'},
                    {data: 'pekerjaan', name: 'pekerjaan'},
                    {data: 'image', name: 'image', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
