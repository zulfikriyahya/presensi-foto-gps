@extends('layouts.login')
@section('auth')
<div class="login-box">
  <div class="login-logo">
      <img src="{{ url('assets/img/absensi.png') }}" style="width: 100px" alt="" srcset="">
      <br>
      <a href="{{ url('/register') }}">Presensi Online</a>
  </div>
  <div class="card">
      @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register Account</p>
  
        <form action="{{ url('/register-proses') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="input-group mb-3">
            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Pegawai" name="name" value="{{ old('name') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            @error('name')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Username" name="username" value="{{ old('username') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            @error('username')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            @error('email')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" value="{{ old('password') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Retype password" name="password_confirmation" value={{ old('password_confirmation') }}>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            @error('password_confirmation')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control @error('telepon') is-invalid @enderror" placeholder="Phone" name="telepon" value={{ old('telepon') }}>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
            @error('telepon')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <select name="lokasi_id" id="lokasi_id" class="form-control selectpicker" data-live-search="true">
              <option value="">Pilih Lokasi Kantor</option>
              @foreach ($data_lokasi as $dl)
                @if(old('lokasi_id') == $dl->id)
                  <option value="{{ $dl->id }}" selected>{{ $dl->nama_lokasi }}</option>
                @else
                  <option value="{{ $dl->id }}">{{ $dl->nama_lokasi }}</option>
                @endif
              @endforeach
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-map-marker-alt"></span>
              </div>
            </div>
            @error('lokasi_id')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="datetime" class="form-control @error('tgl_lahir') is-invalid @enderror" placeholder="Tanggal Lahir" name="tgl_lahir" value={{ old('tgl_lahir') }}>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-baby-carriage"></span>
              </div>
            </div>
            @error('tgl_lahir')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
                              <?php $gender = array(
                              [
                                  "gender" => "Laki-Laki"
                              ],
                              [
                                  "gender" => "Perempuan"
                              ]);
                              ?>
                              <select name="gender" id="gender" class="form-control selectpicker" data-live-search="true">
                                  <option value="">Pilih Gender</option>
                                  @foreach ($gender as $g)
                                      @if(old('gender') == $g["gender"])
                                      <option value="{{ $g["gender"] }}" selected>{{ $g["gender"] }}</option>
                                      @else
                                      <option value="{{ $g["gender"] }}">{{ $g["gender"] }}</option>
                                      @endif
                                  @endforeach
                              </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-venus-mars"></span>
              </div>
            </div>
            @error('gender')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="datetime" class="form-control @error('tgl_join') is-invalid @enderror" placeholder="Tanggal Masuk Perusahaan" name="tgl_join" value={{ old('tgl_join') }}>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-building"></span>
              </div>
            </div>
            @error('tgl_join')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
                              <?php $sNikah = array(
                                              [
                                                  "status" => "Menikah"
                                              ],
                                              [
                                                  "status" => "Lajang"
                                              ]);
                                              ?>
                              <select name="status_nikah" id="status_nikah" class="form-control selectpicker" data-live-search="true">
                                  <option value="">Pilih Status Pernikahan</option>
                                  @foreach ($sNikah as $s)
                                  @if(old('status_nikah') == $s["status"])
                                  <option value="{{ $s["status"] }}" selected>{{ $s["status"] }}</option>
                                  @else
                                  <option value="{{ $s["status"] }}">{{ $s["status"] }}</option>
                                  @endif
                                  @endforeach
                              </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-ring"></span>
              </div>
            </div>
            @error('status_nikah')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <select name="jabatan_id" id="jabatan_id" class="form-control selectpicker" data-live-search="true">
              <option value="">Pilih Jabatan</option>
              @foreach ($data_jabatan as $dj)
                @if(old('jabatan_id') == $dj->id)
                  <option value="{{ $dj->id }}" selected>{{ $dj->nama_jabatan }}</option>
                @else
                  <option value="{{ $dj->id }}">{{ $dj->nama_jabatan }}</option>
                @endif
              @endforeach
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-university"></span>
              </div>
            </div>
            @error('jabatan_id')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat" name="alamat" value={{ old('alamat') }}>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-road"></span>
              </div>
            </div>
            @error('alamat')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <div class="input-group mb-3">
            <input type="file" class="form-control @error('foto_karyawan') is-invalid @enderror" placeholder="Foto Pegawai" name="foto_karyawan" value="{{ old('foto_karyawan') }}">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-images"></span>
              </div>
            </div>
            @error('foto_karyawan')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
            @enderror
          </div>
          <input type="hidden" name="is_admin" value="user">
          <input type="hidden" name="izin_cuti" value="0">
          <input type="hidden" name="izin_lainnya" value="0">
          <input type="hidden" name="izin_telat" value="0">
          <input type="hidden" name="izin_pulang_cepat" value="0">
          <div class="row">
              <div class="col-4">
  
              </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <br>
        <center>
            <a href="{{ url('/') }}" class="text-center">I already have a membership</a>
        </center>
      </div>
      <!-- /.form-box -->
  </div><!-- /.card -->
</div>
  
@endsection