@extends('layouts.admin')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="{{asset('dist/plugins/datatables/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{asset('dist/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css')}}">
@endsection

@section('content')
<div class="container-fluid">
  @include('message_info')
  <div class="row">
    @if (!in_array('PENGAWAS', Session::get('user_roles')))
      @foreach($candidates as $index=>$candidate)
      <div class="col-3 col-sm-6 col-md-3">
        <div class="small-box bg-warning">
          <div class="inner">
            <h4>Calon {{$index + 1}}</h4>
            <h5>{{$candidateVoteCounts[$index]}}</h5>
          </div>
          <div class="icon">
            <i class="ion ion-android-people"></i>
          </div>
          <a href="#" onclick="toggleModal({{$candidate->id}})" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endforeach
    @endif
    @if(!in_array('PASLON', Session::get('user_roles')))
    <div class="col-3 col-sm-6 col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h4>Data Pemilih</h4>

          <h5>{{$users->count()}}</h5>
        </div>
        <div class="icon">
          <i class="ion ion-ios-paper"></i>
        </div>
        <a href="{{route('pemilih.index')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-3 col-sm-6 col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h4>Sudah Memilih</h4>
          @if($users->count() !== 0)
                <h5>{{$voters / $users->count() * 100}} %</h5>
          @else
                <h5>0 %</h5>
          @endif
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{route('pemilih.voted')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <div class="col-3 col-sm-6 col-md-3">
      <div class="small-box bg-success">
        <div class="inner">
          <h4>Belum Memilih</h4>
            @if($users->count() !== 0)
                <h5>{{$usersNotVotee / $users->count() * 100}} %</h5>
            @else
                <h5>0 %</h5>
            @endif
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{route('pemilih.not_voted')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endif
  </div>
    <div class="modal fade" id="modal-lg" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Data Pemilih Calon</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="data-table display nowrap" style="width:100%">
                        <thead>
                        <tr>
                            <th>No Urut</th>
                            <th>ID</th>
                            <th>Nama Pemilih</th>
                            <th>L/P</th>
                            <th>NIK</th>
                            <th>Pekerjaan</th>
                            <th>Foto</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
@endsection

@section('js')
    <script src="{{asset('dist/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dist/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js')}}"></script>
    <script>
        let table
        function toggleModal(id){
            $('#modal-lg').modal()

            let url = "{{ route('paslon.voter', ":id") }}"
            url = url.replace(':id', id);

            table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: url,
                render: 'image',
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                    },
                    {
                        data: 'no_ktp',
                        name: 'no_ktp',
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'pekerjaan',
                        name: 'pekerjaan',
                    },
                    {
                        data: 'image',
                        name: 'image',
                    }
                ]
            });
        }

        $('#modal-lg').on('hidden.bs.modal', function () {
            table.destroy()
        })
    </script>
@endsection
