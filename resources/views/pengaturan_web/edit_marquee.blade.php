@extends('layouts.admin')

@section('title', 'Edit Marquee')

@section('header', 'Edit Marquee')

@section('content')
    <div class="container">
        @include('message_info')
        <form id="form_id" role="form" action="{{route('pengaturan_web.updateMarquee', $marquee->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Text Berjalan</label>
                    <div class="col-sm-10">
                        <textarea rows="10" name="text" class="form-control" placeholder="Text Berjalan" required>{{$marquee->text}}</textarea>
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
    </script>
@endsection
