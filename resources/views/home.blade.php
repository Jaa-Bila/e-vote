@extends('layouts.admin')

@section('title', 'Home')

@section('css')
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

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
          <a href="{{route('calon.show', $candidate->id)}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
      </div>
      @endforeach
    @endif
    @if(!in_array('PASLON', Session::get('user_roles')))
    <div class="col-3 col-sm-6 col-md-3">
      <div class="small-box bg-info">
        <div class="inner">
          <h4>Data Pemilih</h4>

          <h5>{{$users}}</h5>
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
          <h5>{{$voters / $users * 100}} %</h5>
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
          <h5>{{$usersNotVotee / $users * 100}} %</h5>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <a href="{{route('pemilih.not_voted')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection
{{-- @section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    var electionResultCanvas = $('#electionResultChart').get(0).getContext('2d')
    var electionResultData = {
      labels: {!! json_encode($candidate_labels) !!},
      datasets: [
        {
          data: {!! json_encode($votes) !!},
          backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions = {
      legend: {
        display: true,
        labels: {
          boxWidth: 64,
          fontSize: 16,
          padding: 12
        }
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var electionResultChart = new Chart(electionResultCanvas, {
      type: 'doughnut',
      data: electionResultData,
      options: pieOptions
    })

    var voterParticipationCanvas = $('#voterParticipationChart').get(0).getContext('2d')
    var voterParticipationData = {
      labels: ['Sudah memilih','Belum Memilih/Golput'],
      datasets: [
        {
          data: [{!! json_encode($voted_voters) !!}, {!! json_encode($total_voters) - json_encode($voted_voters) !!}],
          backgroundColor : ['#00a65a', '#f56954', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
    }
    var pieOptions = {
      legend: {
        display: true,
        labels: {
          boxWidth: 64,
          fontSize: 16,
          padding: 12
        }
      }
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var voterParticipationChart = new Chart(voterParticipationCanvas, {
      type: 'doughnut',
      data: voterParticipationData,
      options: pieOptions
    })
</script>
@endsection --}}
