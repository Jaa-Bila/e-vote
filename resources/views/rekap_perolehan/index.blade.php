@extends('layouts.admin')

@section('title', 'Rekap Perolehan')

@section('content')
<div class="container-fluid">
  @include('message_info')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Rekap Perolehan</h3>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6">
              <div class="chart-responsive">
                <h3 class="text-center ml-3"><strong>Grafik Presentase Suara Masuk</strong></h3>
                <canvas id="rekapPerolehan" height="150"></canvas>
              </div>
            </div>
            <div class="col-md-6">
                <h3 class="text-center"><strong>Tabel Presentase Suara</strong></h3>
                <h6 class="text-center mb-5">Suara Masuk Per Kecamatan</h6>
                <table class="table table-bordered" style="width: 100%">
                    <thead style="background-color: blue;color:white;">
                        <tr>
                            <th class="text-center">Kecamatan</th>
                            <th class="text-center">Progress</th>
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">{{$data['desa']}}</td>
                            <td class="text-right">{{$data['totalVoter']}} / {{$data['totalPemilih']}}</td>
                            <td class="text-right">{{$data['presentase']}}%</td>
                        </tr>
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
    const DESA = ['{{$data['desa']}}'];
    var color = Chart.helpers.color;
    var horizontalBarChartData = {
        labels: [DESA],
        datasets: [{
            label: '% Suara Masuk',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderWidth: 1,
            data: [{{$data['presentase']}}, 100]
        }]

    };

    window.onload = function() {
        var ctx = document.getElementById('rekapPerolehan').getContext('2d');
        window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: horizontalBarChartData,
            options: {  
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Grafik Presentase Suara Masuk'
                }
            }
        });

    };
</script>
@endsection
