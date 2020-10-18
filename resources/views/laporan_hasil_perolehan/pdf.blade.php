<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('dist/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
          overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
          font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-cly1{text-align:left;vertical-align:middle}
        .tg .tg-baqh{text-align:center;vertical-align:top}
        .tg .tg-nrix{text-align:center;vertical-align:middle}
        .tg .tg-0lax{text-align:left;vertical-align:top}
      </style>
</head>
<div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Laporan Hasil Perolehan</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                  <table class="tg" width="100%">
                  <thead>
                    <tr>
                      <th class="tg-nrix" rowspan="3">No</th>
                      <th class="tg-cly1" rowspan="3">Kecamatan</th>
                      <th class="tg-cly1" rowspan="3">Desa</th>
                      <th class="tg-nrix" colspan="3" rowspan="2">DPT</th>
                      <th class="tg-baqh" colspan="4">Surat Suara</th>
                      <th class="tg-0lax" colspan="{{count($candidateVoters) * 2}}">Perolehan Suara</th>
                      <th class='tg-cly1' rowspan="3">Partisipasi (%)</th>
                    </tr>
                    <tr>
                      <td class="tg-0lax" rowspan="2">Sah</td>
                      <td class="tg-baqh" rowspan="2">Tidak<br>Sah</td>
                      <td class="tg-baqh" rowspan="2">Tdk<br>Digunakan</td>
                      <td class="tg-0lax" rowspan="2">Jumlah</td>
                      @foreach($candidateVoters as $key=>$candidateVoter)
                        <td class="tg-0lax" colspan="2">Calon No Urut {{$key + 1}}</td>
                      @endforeach
                    </tr>
                    <tr>
                      <td class="tg-0lax">L</td>
                      <td class="tg-0lax">P</td>
                      <td class="tg-0lax">Jml</td>
                      @foreach($candidateVoters as $candidateVoter)
                        <td class="tg-0lax">Angka</td>
                        <td class="tg-0lax">%</td>
                      @endforeach
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>{{count($voters) >= 1 ? $voters[0]->kecamatan : ""}}</td>
                    <td>{{count($voters) >= 1 ? $voters[0]->desa_kelurahan : ""}}</td>
                      <td>{{$maleUsers}}</td>
                      <td>{{$femaleUsers}}</td>
                      <td>{{$maleUsers + $femaleUsers}}</td>
                      <td>{{count($voters)}}</td>
                      <td>{{$userNotVote}}</td>
                      <td>{{$userNotVote}}</td>
                      <td>{{$maleUsers + $femaleUsers}}</td>
                      @foreach($candidateVoters as $candidateVoter)
                        <td>{{$candidateVoter['count']}}</td>
                        <td>{{$candidateVoter['presentase']}}</td>
                      @endforeach
                      <td>{{count($voters) / count($users)}}</td>
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
</html>