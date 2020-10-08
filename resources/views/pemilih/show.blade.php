@extends('layouts.admin')

@section('title', 'Detail Pemilih')

@section('header', 'Detail Pemilih')

@section('content')
    <div class="container">
        @include('message_info')
        <form id="form_id" role="form">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10 text-center">
                        <img src="{{asset($user->foto)}}" border="0" width="150" class="img-rounded" align="center"/>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Pemilih</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="{{$user->name}}" placeholder="Nama Lengkap" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No Urut Pemilih</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{$user->no_urut}}" placeholder="No Urut" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <input type="text" name="nik" class="form-control" value="{{$user->nik}}" placeholder="NIK" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No ID</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_ktp" class="form-control" value="{{$user->no_ktp}}" placeholder="ID" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tempat/Tanggal Lahir</label>
                    <div class="col-sm-6">
                        <input type="text" name="tempat_lahir" class="form-control" value="{{$user->tempat_lahir}}" placeholder="Tempat Lahir" readonly>
                    </div>
                    <div class="col-sm-4">
                        <input type="date" name="tanggal_lahir" class="form-control" value="{{$user->tanggal_lahir}}" placeholder="yyyy-mm-dd" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-4">
                        <input type="text" name="jenis_kelamin" class="form-control" value="{{$user->jenis_kelamin}}" placeholder="Pekerjaan" readonly>
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Agama</label>
                    <div class="col-sm-4">
                        <input type="text" name="agama" class="form-control" value="{{$user->agama}}" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="alamat" class="form-control" placeholder="Alamat" readonly>{{$user->alamat}}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pekerjaan</label>
                    <div class="col-sm-10">
                        <input type="text" name="pekerjaan" class="form-control" value="{{$user->pekerjaan}}" placeholder="Pekerjaan" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Provinsi</label>
                    <div class="col-sm-10">
                        <input type="text" name="provinsi" class="form-control" value="{{$user->provinsi}}" placeholder="Provinsi" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kabupaten/Kota</label>
                    <div class="col-sm-10">
                        <input type="text" name="kabkota" class="form-control" value="{{$user->kabkota}}" placeholder="Kabupaten/Kota" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                        <input type="text" name="kecamatan" class="form-control" value="{{$user->kecamatan}}" placeholder="Kecamatan" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Desa/Kelurahan</label>
                    <div class="col-sm-10">
                        <input type="text" name="desa_kelurahan" class="form-control" value="{{$user->desa_kelurahan  }}" placeholder="Desa/Kelurahan" readonly>
                    </div>
                </div>
            </div>

        </form>
    </div>
@endsection

