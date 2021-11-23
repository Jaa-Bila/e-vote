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
              {{-- <div class="chart-responsive">
                <h3 class="text-center ml-3"><strong>Grafik Presentase Suara Masuk</strong></h3>
                <canvas id="rekapPerolehan"></canvas>

              </div> --}}
              <div id="rekapPerolehan">
              </div>
            </div>
            <div class="col-md-6" style="font-size: 14px">
                <h3 class="text-center"><strong>Tabel Presentase Suara</strong></h3>
                <h6 class="text-center mb-5">Suara Masuk Per Kecamatan</h6>
                <table class="table table-bordered" style="width: 100%">
                    <thead style="background-color: blue;color:white;">
                        <tr>
                            <th class="text-center">Kecamatan</th>
                            <th class="text-center">Progress</th>
                            @foreach($candidateVoters as $candidateVoter)
                                <th class="text-center">{{$candidateVoter['name']}}</th>
                            @endforeach
                            <th class="text-center">%</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left">{{$data['desa']}}</td>
                            <td class="text-right">{{$data['totalVoter']}} / {{$data['totalPemilih']}}</td>
                            @foreach($candidateVoters as $candidateVoter)
                                <td>{{number_format((float)$candidateVoter['presentase'], 2, '.', '')}} %</td>
                            @endforeach
                            <td>{{number_format((float)$data['presentase'], 2, '.', '')}} %</td>
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
<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    Highcharts.chart('rekapPerolehan', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Grafik Presentase Suara Masuk'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: {!!json_encode($paslon)!!},
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Perolehan Suara',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ' Suara'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -20,
        y: 40,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Suara Masuk',
        data: {!!json_encode($cansvote)!!}
    }]
});
</script>


{{-- <script>
    const DESA = ['{{$data['desa']}}'];
    var color = Chart.helpers.color;
    var horizontalBarChartData = {
        labels: [DESA],
        datasets:

        [{
            label: '% Suara Masuk',
            backgroundColor : ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderWidth: 1,
            data: [{{number_format((float)$data['presentase'], 2, '.', '')}}, 100 ]
        }, {
            label: '% Calon 1',
            backgroundColor : ['#00a65a', '#f56954',  '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderWidth: 1,
            data: [{{number_format((float)$data['presentase1'], 2, '.', '')}}, 100]
        }, {
            label: '% Calon 2',
            backgroundColor : ['#f39c12', '#f56954', '#00a65a', '#00c0ef', '#3c8dbc', '#d2d6de'],
            borderWidth: 1,
            data: [{{number_format((float)$data['presentase2'], 2, '.', '')}}, 100]
        }],

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
</script> --}}


@endsection
