@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        <div class="card elevation-0">
            <div class="card-body">
                <article>
                    <h2>Jumlah Pemilih : {{$usersCount}} orang</h2>
                </article>
            </div>
        </div>
    </div>
</div>
@endsection
