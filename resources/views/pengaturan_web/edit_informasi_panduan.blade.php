@extends('layouts.admin')

@section('title', 'Edit Informasi Pemilihan')

@section('header', 'Edit Informasi Pemilihan')

@section('content')
    <div class="container">
        @include('message_info')
        <form id="form_id" role="form" action="{{route('pengaturan_web.updateElectionInformation', $electionInformation->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Informasi Pemilihan</label>
                    <div class="col-sm-10">
                        <textarea rows="10" name="informasi" class="form-control" placeholder="Informasi Pemilihan" required>{{$electionInformation->informasi}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Panduan Pemilihan</label>
                    <div class="col-sm-10">
                        <textarea rows="10" name="panduan" class="form-control" placeholder="Panduan Pemilihan" required>{{$electionInformation->panduan}}</textarea>
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
