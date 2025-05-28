@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success" style="border-radius: 7px; background-color:  #082e67 !important">
                    <div class="inner">
                        <h3>{{ $jumlah_user }}</h3>

                        <p>Total Pegawai</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{ url('/pegawai') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success" style="border-radius: 7px; background-color:  #082e67 !important">
                  <div class="inner">
                    <h3>{{ $jumlah_masuk + $jumlah_izin_telat + $jumlah_izin_pulang_cepat  }}</h3>

                    <p>Masuk</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ url('/data-absen') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger" style="border-radius: 7px; background-color:  #082e67 !important">
                  <div class="inner">
                    <h3>{{ $jumlah_tidak_masuk }}</h3>

                    <p>Alfa</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="{{ url('/data-absen') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info" style="border-radius: 7px; background-color:  #082e67 !important">
                  <div class="inner">
                    <h3>{{ $jumlah_libur }}</h3>

                    <p>Libur</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-calendar"></i>
                  </div>
                  <a href="{{ url('/data-absen') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

        </div>
        
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success" style="border-radius: 7px; background-color:  #082e67 !important">
                  <div class="inner">
                    <h3>{{ $jumlah_karyawan_lembur }}</h3>

                    <p>Lembur</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-calendar"></i>
                  </div>
                  <a href="{{ url('/data-lembur') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
              <div class="small-box bg-success" style="border-radius: 7px; background-color:  #082e67 !important">
                <div class="inner">
                    <h3>{{ $jumlah_cuti }}</h3>

                    <p>Izin</p>
                </div>
                <div class="icon">
                    <i class="ion ion-clock"></i>
                </div>
                <a href="{{ url('/data-cuti') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info" style="border-radius: 7px; background-color:  #082e67 !important">
                  <div class="inner">
                    <h3>{{ $jumlah_izin_telat }}</h3>

                    <p>Izin Telat</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-calendar"></i>
                  </div>
                  <a href="{{ url('/data-absen') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger" style="border-radius: 7px; background-color:  #082e67 !important">
                  <div class="inner">
                    <h3>{{ $jumlah_izin_pulang_cepat }}</h3>

                    <p>Izin Pulang Cepat</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ url('/data-absen') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
        
        <div class="row">
          <div id="external-events">
          </div>
          <!-- /.col -->
          <div class="col-md-12">
            <div class="card card-primary" style="border-radius: 7px !important">
              <div class="card-body p-0">
                <!-- THE CALENDAR -->
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

    </div>
    <br>
@endsection
