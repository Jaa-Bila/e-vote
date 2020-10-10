@extends('layouts.admin')

@section('title', 'Edit Menu')

@section('header', 'Edit Menu')

@section('content')
    <div class="container">
        @include('message_info')
        <form id="form_id" role="form" action="{{route('menu.update', $menu->id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="name" class="form-control" placeholder="Nama Menu" required>{{$menu->name}}</textarea>
                    </div>
                </div>

                <div class="col-sm-offset-3 col-sm-7 float-sm-right text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" onclick="reset()" class="btn btn-warning">Reset</button>
                    <a href="{{route('menu.index')}}" type="button" class="btn btn-default">Batal</a>
                </div>
            </div>

        </form>
    </div>
@endsection

@section('js')
    <script>
        function reset(){
            $('#form_id').trigger("reset");
        }
    </script>
@endsection
