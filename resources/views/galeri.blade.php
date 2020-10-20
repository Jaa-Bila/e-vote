@extends('layouts.app')

@section('title', 'Gallery')

@section('css')
    <link rel="stylesheet" href="{{asset('dist/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endsection

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
                            <a href="{{asset($gallery->path)}}" data-toggle="lightbox"
                                data-title="{{$gallery->title}}" data-gallery="gallery">
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
</div>
@endsection

@section('js')
<script src="{{asset('dist/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<script>
    $(function () {
      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true
        });
      });
    })
  </script>
@endsection