@extends('layouts.admin')

@section('title', 'Tambah Carousel')

@section('header', 'Tambah Carousel')

@section('content')
    <div class="container">
        @include('message_info')
        <form id="form_id" role="form" action="{{route('pengaturan_web.storeCarousel')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Upload Banner</label>
                    <div class="col-sm-10">
                        <input id="upload_image" type="file" name="image" class="form-control" required accept="image/x-png,image/gif,image/jpeg">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Text Banner</label>
                    <div class="col-sm-10">
                        <textarea rows="10" name="text" class="form-control" placeholder="Text Banner" required></textarea>
                    </div>
                </div>

                <div class="col-sm-offset-3 col-sm-7 float-sm-right text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" onclick="reset()" class="btn btn-warning">Reset</button>
                    <a href="{{route('pengaturan_web.index')}}" type="button" class="btn btn-default">Batal</a>
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
        $('#upload_image').on('change', function (e) {
            if(this.files[0].size > 2097152){
                alert("Ukuran foto terlalu besar (max. 2MB)");
                this.value = "";
            }
        })
    </script>
@endsection
