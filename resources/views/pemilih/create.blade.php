@extends('layouts.admin')

@section('title', 'Tambah Pemilih')

@section('header', 'Tambah Pemilih')

@section('content')
    <div class="container">
        @include('message_info')
        <form id="form_id" role="form" action="{{route('pemilih.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nama Pemilih</label>
                    <div class="col-sm-10">
                        <input type="text" name="name" class="form-control" value="" placeholder="Nama Lengkap" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No Urut Pemilih</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_urut" class="form-control" value="{{$user->no_urut + 1}}" placeholder="Alamat Customer" required readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">NIK</label>
                    <div class="col-sm-10">
                        <input type="text" name="nik" class="form-control" value="" placeholder="NIK" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No ID</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_ktp" class="form-control" value="" placeholder="ID" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tempat/Tanggal Lahir</label>
                    <div class="col-sm-6">
                        <input type="text" name="tempat_lahir" class="form-control" value="" placeholder="Tempat Lahir" required>
                    </div>
                    <div class="col-sm-4">
                        <input type="date" name="tanggal_lahir" class="form-control" value="" placeholder="yyyy-mm-dd" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-4">
                        <select name="jenis_kelamin" class="form-control">
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <label class="col-sm-2 col-form-label text-right">Agama</label>
                    <div class="col-sm-4">
                        <select name="agama" class="form-control">
                            <option value="islam">Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="hindu">Hindu</option>
                            <option value="buddha">Buddha</option>
                            <option value="konghucu">Konghucu</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Alamat</label>
                    <div class="col-sm-10">
                        <textarea name="alamat" class="form-control" placeholder="Alamat" required></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Pekerjaan</label>
                    <div class="col-sm-10">
                        <input type="text" name="pekerjaan" class="form-control" value="" placeholder="Pekerjaan" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Provinsi</label>
                    <div class="col-sm-10">
                        <input type="text" name="provinsi" class="form-control" value="" placeholder="Provinsi" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kabupaten/Kota</label>
                    <div class="col-sm-10">
                        <input type="text" name="kabkota" class="form-control" value="" placeholder="Kabupaten/Kota" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                        <input type="text" name="kecamatan" class="form-control" value="" placeholder="Kecamatan" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Desa/Kelurahan</label>
                    <div class="col-sm-10">
                        <input type="text" name="desa_kelurahan" class="form-control" value="" placeholder="Desa/Kelurahan" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Upload Foto</label>
                    <div class="col-sm-10">
                        <input id="upload_image" type="file" name="image" class="form-control" required accept="image/x-png,image/gif,image/jpeg">
                    </div>
                </div>

                <div class="col-sm-offset-3 col-sm-7 float-sm-right text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" onclick="reset()" class="btn btn-warning">Reset</button>
                    <a href="{{route('pemilih.index')}}" type="button" class="btn btn-default">Batal</a>
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
        $('#upload_image').on('change', function (e) {
            if(this.files[0].size > 2097152){
                alert("Ukuran foto terlalu besar (max. 2MB)");
                this.value = "";
            }
        })
    </script>
@endsection
