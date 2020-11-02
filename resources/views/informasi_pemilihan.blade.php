@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        <div class="card elevation-0">
            <div class="card-header">
                <h1>Informasi Pemilihan</h1>
            </div>
            <div class="card-body">
                <article>
                    {{$electionInformation->informasi}}
                </article>
            </div>
        </div>
        <div class="text-center">
            <iframe width="480" height="640"
                    src="{{$electionInformation->video}}">
            </iframe>
        </div>
        <div class="text-center">
            <img src="{{$electionInformation->image}}" width="480" height="640">
        </div>
    </div>
</div>
@endsection
