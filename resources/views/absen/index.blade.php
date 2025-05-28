@extends('layouts.dashboard')

@section('isi')
    @if($shift_karyawan->count() > 0)
        @foreach ($shift_karyawan as $sk)
            <?php $skid = $sk->id ?>
            <?php $sktanggal = $sk->tanggal ?>
            <?php $sknamas = $sk->Shift->nama_shift  ?>
            <?php $skjamas = $sk->Shift->jam_masuk ?>
            <?php $skjamkel = $sk->Shift->jam_keluar ?>
            <?php $skjamab = $sk->jam_absen ?>
            <?php $skjampul = $sk->jam_pulang ?>
            <?php $skstatus = $sk->status_absen ?>

        @endforeach
    @else
        <?php $skid = "-" ?>
        <?php $sktanggal = "-" ?>
        <?php $sknamas = "-"  ?>
        <?php $skjamas = "-" ?>
        <?php $skjamkel = "-" ?>
        <?php $skjamab = "-" ?>
        <?php $skjampul = "-" ?>
        <?php $skstatus = "-" ?>
    @endif
    <div class="container-fluid">
        <center>
            <p class="p mb-2 text-gray-800">Tanggal : {{ $sktanggal }}</p>
            <b><p class="p mb-2 text-gray-800">Presensi {{ $sknamas}} ({{ $skjamas }} - {{  $skjamkel }})</p></b>
        </center>

        <style>
            .jam-digital-malasngoding {
              overflow: hidden;
              float: center;
              width: 100px;
              margin: 0px auto;
              /*border: 0px solid #efefef;*/
            }

            .kotak {
              float: left;
              width: 30px;
              height: 30px;
              background-color: #041F33;
              /*border: 1px solid #fff;*/
              border-radius: 5px;
            }

            .jam-digital-malasngoding p {
              color: #fff;
              font-size: 14px;
              text-align: center;
              margin-top: 3px;
            }
        </style>

        <div class="jam-digital-malasngoding">
            <div class="kotak">
              <p id="jam"></p>
            </div>
            <div class="kotak">
              <p id="menit"></p>
            </div>
            <div class="kotak">
              <p id="detik"></p>
            </div>
        </div>

        <script>
            window.setTimeout("waktu()", 1000);

            function waktu() {
              var waktu = new Date();
              setTimeout("waktu()", 1000);
              document.getElementById("jam").innerHTML = waktu.getHours();
              document.getElementById("menit").innerHTML = waktu.getMinutes();
              document.getElementById("detik").innerHTML = waktu.getSeconds();
            }
        </script>
        <br>

        <div class="d-flex justify-content-center">
            <form action="{{ url('/my-location') }}" method="get">
                @csrf
                <input type="hidden" name="lat" id="lat2">
                <input type="hidden" name="long" id="long2">
                <input type="hidden" name="userid" value="{{ auth()->user()->id }}">
                <button type="submit" class="btn btn-danger">Lihat Lokasi Saya</button>
            </form>
        </div>

        @if($shift_karyawan->count() == 0)
        <br>
        <div class="card col-lg-12">
        <div class="mt-5">
            <div class="mb-5">
                <center>
                    <h5>Hubungi Admin!</h5>
                </center>
            </div>
        </div>
        </div>
        @elseif($skstatus == "Libur")
        <br>
        <div class="card col-lg-12">
        <div class="mt-5">
            <div class="mb-5">
                <center>
                    <h5>Hari ini anda libur.</h5>
                </center>
            </div>
        </div>
        </div>
        @elseif($skstatus == "Cuti")
        <br>
        <div class="card col-lg-12">
        <div class="mt-5">
            <div class="mb-5">
            <center>
                <h5>Hari Ini Anda Cuti.</h5>
            </center>
            </div>
        </div>
        </div>
        @else
            @if($skjamab == null)
            <br>
                <div class="card col-lg-12">
                    <div class="mt-4">
                        <form method="post" action="{{ url('/absen/masuk/'.$skid) }}">
                            @method('put')
                            @csrf
                            <div class="form-row">
                                <div class="col"></div>
                                <div class="col">
                                    <center>
                                        <h5><b>Presensi Masuk</b></h5>
                                        <div class="webcam" id="results"></div>
                                    </center>
                                </div>
                                <div class="col">
                                    <input type="hidden" name="jam_absen">
                                    <input type="hidden" name="foto_jam_absen" class="image-tag">
                                    <input type="hidden" name="lat_absen" id="lat">
                                    <input type="hidden" name="long_absen" id="long">
                                    <input type="hidden" name="telat">
                                    <input type="hidden" name="jarak_masuk">
                                    <input type="hidden" name="status_absen">
                                </div>
                            </div>
                            <br>
                            <center>
                                <button type="submit" class="btn btn-block btn-lg btn-primary" value="Ambil Foto" onClick="take_snapshot()"><b><i class="fas fa-camera"></i> Masuk</b></button>
                            </center>
                            </form>
                            <br>
                    </div>
                </div>
                <br><br>

                <script type="text/javascript" src="{{ url('webcamjs/webcam.min.js') }}"></script>
                <script language="JavaScript">
                Webcam.set({
                    width: 240,
                    height: 240,
                    image_format: 'jpeg',
                    jpeg_quality: 80
                });
                Webcam.attach( '.webcam' );
                </script>
                <script language="JavaScript">
                function take_snapshot() {
                    // take snapshot and get image data
                    Webcam.snap( function(data_uri) {
                            $(".image-tag").val(data_uri);
                    // display results in page
                    document.getElementById('results').innerHTML =
                        '<img src="'+data_uri+'"/>';
                    } );
                }
                </script>

            @elseif($skjampul == null)
            <br>
            <div class="card col-lg-12">
                <div class="mt-4">
                    <form method="post" action="{{ url('/absen/pulang/'.$skid) }}">
                        @method('put')
                        @csrf
                        <div class="form-row">
                            <div class="col"></div>
                            <div class="col">
                                <center>
                                <h5><b>Presensi Pulang</b></h5>
                                    <div class="webcam" id="results"></div>
                                </center>
                            </div>
                            <div class="col">
                                <input type="hidden" name="jam_pulang">
                                <input type="hidden" name="foto_jam_pulang" class="image-tag">
                                <input type="hidden" name="lat_pulang" id="lat">
                                <input type="hidden" name="long_pulang" id="long">
                                <input type="hidden" name="pulang_cepat">
                                <input type="hidden" name="jarak_pulang">
                            </div>
                        </div>
                        <br>
                        <center>
                            <button type="submit" class="btn btn-block btn-lg btn-danger" value="Ambil Foto" onClick="take_snapshot()"><b><i class="fas fa-camera"></i> Pulang</b></button>
                        </center>
                    </form>
                    <br>
                </div>
            </div>
            <br><br>

            <script type="text/javascript" src="{{ url('webcamjs/webcam.min.js') }}"></script>
            <script language="JavaScript">
            Webcam.set({
                width: 240,
                height: 240,
                image_format: 'jpeg',
                jpeg_quality: 80
            });
            Webcam.attach( '.webcam' );
            </script>
            <script language="JavaScript">
            function take_snapshot() {
                // take snapshot and get image data
                Webcam.snap( function(data_uri) {
                        $(".image-tag").val(data_uri);
                // display results in page
                document.getElementById('results').innerHTML =
                    '<img src="'+data_uri+'"/>';
                } );
            }
            </script>

            @else
            <br>
            <div class="card col-lg-12">
                <div class="mt-5">
                <div class="mb-5">
                    <center>
                        <h2>Presensi selesai.</h2>
                    </center>
                </div>
                </div>
            </div>

            @endif
        @endif


    </div>
    <br>
@endsection
