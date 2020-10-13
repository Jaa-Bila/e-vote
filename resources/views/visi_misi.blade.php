@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        @foreach($candidates as $candidate)
        <div class="card elevation-0">
            <div class="card-header">
                <h1>Visi Misi {{$candidate->name}}</h1>
            </div>
            <div class="card-body">
                <article>
                    {{$candidate->visi_misi}}
                </article>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
