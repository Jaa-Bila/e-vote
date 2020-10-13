@extends('layouts.app')

@section('content')
<div class="container">
    <div class="content">
        @foreach($candidates as $candidate)
        <div class="card elevation-0">
            <div class="card-header">
                <h1>Profil {{$candidate->name}}</h1>
            </div>
            <div class="card-body">
                <article>
                    <div class="row">
                        <div class="col-sm-10 text-center">
                            <img src="{{asset($candidate->foto)}}" border="0" width="400" class="img-rounded" align="center"/>
                        </div>
                    </div>

                    Nama : {{$candidate->name}}
                    <br/>
                    TTL : {{$candidate->tempat_lahir}}, {{$candidate->tanggal_lahir}}
                    <br/>
                    Jenis Kelamin : {{ucfirst($candidate->jenis_kelamin)}}
                    <br/>
                    Agama : {{ucfirst($candidate->agama)}}
                    <br/>
                    Pekerjaan : {{ucfirst($candidate->pekerjaan)}}
                    <br/>
                    Pendidikan Terakhir : {{$candidate->pendidikan_terakhir}}
                    <br/>
                    Pengalaman Organisasi : {{$candidate->pengalaman_organisasi}}
                    <br/>
                    Keterangan Tambahan : {{$candidate->keterangan_tambahan}}
                    <br/>
                </article>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
