@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container">
    <div class="content">
        <div class="col-12">
            <div class="card elevation-0">
                <div class="card-header">
                    <div class="card-title">
                        Gallery
                    </div>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center">
                        @foreach($galleries as $gallery)
                        <div class="col-sm-2">
                            <a href="{{asset($gallery->path)}}" data-toggle="modal" data-target="#modal-lg-{{$gallery->id}}">
                                @if(explode('.', $gallery->path)[1] === 'jpg' || explode('.', $gallery->path)[1] === 'png' || explode('.', $gallery->path)[1] === 'jpeg')
                                    <img src="{{asset($gallery->path)}}" class="img-fluid mb-2"
                                         alt="{{$gallery->title}}" />
                                @else
                                    <video width="320" height="240" autoplay="autoplay">
                                        <source src="{{asset($gallery->path)}}" type="video/mp4">
                                    </video>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($galleries as $gallery)
    <div class="modal fade" id="modal-lg-{{$gallery->id}}">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Gallery Item</h4>
                </div>
                <div class="modal-body">
                    @if(explode('.', $gallery->path)[1] === 'jpg' || explode('.', $gallery->path)[1] === 'png' || explode('.', $gallery->path)[1] === 'jpeg')
                        <img src="{{asset($gallery->path)}}" class="img-fluid mb-2"
                             alt="{{$gallery->title}}" />
                    @else
                        <video width="320" height="240" autoplay="autoplay">
                            <source src="{{asset($gallery->path)}}" type="video/mp4">
                        </video>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection
