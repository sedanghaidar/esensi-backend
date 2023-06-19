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
    .border {
      border: 1px solid black;
      border-collapse: collapse;
    }

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
      text-align: center;
      font-family: Tahoma;
    }

    .center {
      text-align: center;
    }

    .center-image {
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    body {
      font-family: Tahoma;
      font-size: 14pt;
    }

    span {
      line-height: 1.5em;
    }

    img {
      height: auto;
      width: auto;
    }

  </style>
</head>
<body>
  <center>
    <h2 style="text-decoration: underline; font-family: Tahoma;">NOTULEN RAPAT</h2>
    <div>{{$kegiatan->name}}</div>
  </center>
  <br>
  <table>
    <tr>
      <td>Nomor</td>
      <td>:</td>
      <td>{{$notulen->nosurat}}</td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td>{{ (new \App\Helpers\MyHelper)->indonesian_date($kegiatan->date, 'd F Y') }}</td>
    </tr>
    <tr>
      <td>Waktu</td>
      <td>:</td>
      <td>{{ substr($kegiatan->time, 0,5) }} WIB s.d. Selesai</td>
    </tr>
    <tr>
      <td>Tempat</td>
      <td>:</td>
      <td>{{ $kegiatan->location }}</td>
    </tr>
    @if ($instansi_count <= 3) <tr>
      <td>Peserta</td>
      <td>:</td>
      <td></td>
      </tr>
      <?php $b = 0 ?>
      @foreach ($instansi as $key => $item)
      <tr>
        <td></td>
        <td></td>
        <td>{{$b+1}}. {{ $item->instansi }}</td>
      </tr>
      <?php $b++ ?>
      @endforeach
      @else
      <tr>
        <td>Peserta</td>
        <td>:</td>
        <td>Terlampir</td>
      </tr>
      @endif

  </table>
  <br>
  <strong>HASIL : </strong>
  {!!$notulen->hasil!!}


  <table style="width: 100%">
    <tr style="height: 10px">
      <td style="width: 50%; padding-left: 12px; padding-right: 12px;"></td>
      <td style="width: 50%; padding-left: 12px; padding-right: 12px;text-align: center;">{{$notulen->jabatan}}</td>
    </tr>

    <br>
    <br>
    <br>


    <tr style="height: 10px">
      <td style="width: 50%; padding-left: 12px; padding-right: 12px;"></td>
      <td style="width: 50%; text-decoration: underline; padding-left: 12px; padding-right: 12px;text-align: center;"><strong> {{$notulen->nama}}</strong></td>
    </tr>
    <tr style="height: 10px">

      <td style="width: 50%; padding-left: 12px; padding-right: 12px;"></td>
      <td style="width: 50%; padding-left: 12px; padding-right: 12px;text-align: center;">{{$notulen->pangkat}}</td>
    </tr>
    <tr style="height: 10px">

      <td style="width: 50%; padding-left: 12px; padding-right: 12px;"></td>
      <td style="width: 50%; padding-left: 12px; padding-right: 12px;text-align: center;">NIP. {{$notulen->nip}}</td>
    </tr>
  </table>

  <div class="page-break"></div>
  <p class="center">DOKUMENTASI</p>
  <img width="850" height="850" class="center-image" src="{{url('storage/images/'.$notulen->image1)}}">
  @if ($notulen->image2 != '')
  <img width="850" height="850" src="{{url('storage/images/'.$notulen->image1)}}" class="center-image">
  @endif
  @if ($notulen->image3 != '')
  <img width="850" height="850" src="{{url('storage/images/'.$notulen->image3)}}" class="center-image">
  @endif

  {{-- PESERTA --}}
  @if ($instansi_count > 3)
  <br />
  <br />
  <table>
    <tr>
      <td>PESERTA</td>
      <td>:</td>
    </tr>
    <?php $j = 0 ?>
    @foreach ($instansi as $key => $item)
    {{-- @for ($j = 0; $j < $instansi_count; $j++) <tr style="height: 10px"> --}}
    <tr>
      <td style="width: 3%; text-align: right; vertical-align:top;">{{$j+1}}</td>
      <td style="width: 97%; padding-left: 12px; padding-right: 12px;">{{ $item->instansi }}</td>
    </tr>
    <?php $j++ ?>
    @endforeach
    {{-- @endfor --}}
  </table>
  @endif
</body>
</html>
