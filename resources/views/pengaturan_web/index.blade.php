@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('dist/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
@endsection

@section('title', 'Pengaturan Web')

@section('content')
    @include('message_info')
    <div class="card">
        <div class="card-header">
            <h5>Informasi Pemilihan</h5>
        </div>
        <div class="card-body" style="display: block;">
            <div class="mt-3">
                <table class="data-table-information display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Informasi</th>
                        <th>Panduan</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Carousel Landing Page</h5>
        </div>
        <div class="card-body" style="display: block;">
            <a href="{{route('pengaturan_web.createCarousel')}}"><button type="button" class="btn btn-primary float-right mb-3">+ Tambahkan Gambar</button></a>
            <div class="mt-3">
                <table class="data-table-carousel display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Gallery</h5>
        </div>
        <div class="card-body" style="display: block;">
            <a href="{{route('pengaturan_web.createGalleries')}}"><button type="button" class="btn btn-primary float-right mb-3">+ Tambahkan Gambar</button></a>
            <div class="mt-3">
                <table class="data-table-gallery display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Marquee</h5>
        </div>
        <div class="card-body" style="display: block;">
            <div class="mt-3">
                <table class="data-table-marquee display nowrap" style="width:100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Text</th>
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
            var table = $('.data-table-information').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pengaturan_web.indexElectionInformation') }}",
                render: 'image',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'informasi', name: 'informasi'},
                    {data: 'panduan', name: 'panduan'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            var table = $('.data-table-carousel').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pengaturan_web.indexLandingCarousel') }}",
                render: 'image',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            var table = $('.data-table-gallery').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pengaturan_web.indexGalleries') }}",
                render: 'image',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'image', name: 'image'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>

    <script type="text/javascript">
        $(function () {
            var table = $('.data-table-marquee').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ route('pengaturan_web.indexMarquee') }}",
                render: 'image',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'text', name: 'text'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });
    </script>
@endsection
