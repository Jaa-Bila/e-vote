@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        <div class="card elevation-0">
            <div class="card-header">
                <h1>Panduan Memilih</h1>
            </div>
            <div class="card-body">
                <article>
                    {{$electionInformation->panduan}}
                </article>
            </div>
            <div class="text-center">
                @if(!is_null($electionInformation->video))
                    <iframe width="640" height="480"
                            src="{{$electionInformation->video}}">
                    </iframe>
                @endif
            </div>
            <div class="text-center">
                @if(!is_null($electionInformation->image))
                    <img src="{{$electionInformation->image}}" width="640" height="480">
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
