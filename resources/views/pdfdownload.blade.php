<html>
<head>
    <title>{{$kegiatan->name}}</title>
    <style>
      .page-break {
        page-break-after: always;
      }
      /* table, th, td {
        border: 1px solid black;
        border-collapse: collapse;
      } */
      .border{
        border: 1px solid black;
        border-collapse: collapse;
      }
      h1, h2, h3, h4, h5, h6 {text-align: center; font-family: Calibri;}
      .center{text-align: center;}
      body{font-family: Calibri;}
    </style>
</head>
<body>
  <h2>DAFTAR HADIR</h2>
  <br>
  <table>
    <tr>
      <td>HARI</td>
      <td>:</td>
      <td>{{ (new \App\Helpers\MyHelper)->indonesian_date($kegiatan->date, 'l') }}</td>
    </tr>
    <tr>
      <td>TANGGAL</td>
      <td>:</td>
      <td>{{ (new \App\Helpers\MyHelper)->indonesian_date($kegiatan->date, 'd F Y') }}</td>
    </tr>
    <tr>
      <td>JAM</td>
      <td>:</td>
      <td>{{  substr($kegiatan->time, 0,5) }} WIB s.d. Selesai</td>
    </tr>
    <tr>
      <td>TEMPAT</td>
      <td>:</td>
      <td>{{ $kegiatan->location }}</td>
    </tr>
    <tr>
      <td>ACARA</td>
      <td>:</td>
      <td>{{ $kegiatan->name }}</td>
    </tr>
  </table>
  <br>

  <table style="width: 100%" class="border">
    <tr>
      <th class="border">NO.</th>
      <th class="border">NAMA</th>
      <th class="border">INSTANSI</th>
      <th class="border">WAKTU HADIR</th>
      <th class="border">TANDA TANGAN</th>
    </tr>
    @foreach ($results as $key => $item)

    <tr style="height: 30px">
      <td class="border" style="text-align: center;">{{$key+1}}</td>
      <td class="border" style="width: 30%; padding-left: 12px; padding-right: 12px;">{{$item->name}}</td>
      <td class="border" style="width: 30%; padding-left: 12px; padding-right: 12px;">{{$item->instansi}}</td>
      <td class="border" style="width: 20%; padding-left: 12px; padding-right: 12px;">{{$item->scanned_at}}</td>
      <td class="border center" style="width: 20%; height: 90px;"><img src="{{url('storage/signature/'.$item->signature)}}" height="90px" class="center"></td>
    </tr>
    @endforeach
  </table>

</body>
</html>