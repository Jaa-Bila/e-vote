@extends('layouts.admin')

@section('title', 'Home')

@section('content')
<div class="container-fluid">
  @include('message_info')
  @if (in_array('ADMIN', Session::get('user_roles')) || in_array('PENGAWAS', Session::get('user_roles')))
  <div class="row">
    <div class="col-12 col-sm-6 col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Hasil Pemilihan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="chart-responsive">
                <canvas id="electionResultChart" height="150"></canvas>
              </div>
              <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Partisipasi Pemilih</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <div class="row">
            <div class="col-md-12">
              <div class="chart-responsive">
                <canvas id="voterParticipationChart" height="150"></canvas>
              </div>
              <!-- ./chart-responsive -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.card-body -->
      </div>
    </div>
    <!-- /.col -->
  </div>
  @endif
</div>
@endsection
@section('js')
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
@endsection
