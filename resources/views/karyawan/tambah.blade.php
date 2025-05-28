@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card col-lg-12">
            <div class="mt-4 p-4">
                <form method="post" action="{{ url('/pegawai/tambah-pegawai-proses') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col">
                            <label for="name">Nama Pegawai</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" autofocus value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="foto_karyawan" class="form-label">Foto Pegawai</label>
                            <input class="form-control @error('foto_karyawan') is-invalid @enderror" type="file" id="foto_karyawan" name="foto_karyawan">
                            @error('foto_karyawan')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="telepon">Nomor Telfon</label>
                            <input type="number" class="form-control @error('telepon') is-invalid @enderror" id="telepon" name="telepon" value="{{ old('telepon') }}">
                            @error('telepon')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}">
                            @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="password" au class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="lokasi_id">Lokasi Kantor</label>
                            <select name="lokasi_id" id="lokasi_id" class="form-control @error('lokasi_id') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">Pilih Lokasi Kantor</option>
                                @foreach ($data_lokasi as $dl)
                                    @if(old('lokasi_id') == $dl->id)
                                        <option value="{{ $dl->id }}" selected>{{ $dl->nama_lokasi }}</option>
                                    @else
                                        <option value="{{ $dl->id }}">{{ $dl->nama_lokasi }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('lokasi_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="tgl_lahir">Tanggal Lahir</label>
                            <input type="datetime" class="form-control @error('tgl_lahir') is-invalid @enderror" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                            @error('tgl_lahir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <?php $gender = array(
                            [
                                "gender" => "Laki-Laki"
                            ],
                            [
                                "gender" => "Perempuan"
                            ]);
                            ?>
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control @error('gender') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">Pilih Gender</option>
                                @foreach ($gender as $g)
                                    @if(old('gender') == $g["gender"])
                                    <option value="{{ $g["gender"] }}" selected>{{ $g["gender"] }}</option>
                                    @else
                                    <option value="{{ $g["gender"] }}">{{ $g["gender"] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('gender')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="tgl_join">Tanggal Masuk Perusahaan</label>
                            <input type="datetime" class="form-control @error('tgl_join') is-invalid @enderror" id="tgl_join" name="tgl_join" value="{{ old('tgl_join') }}">
                            @error('tgl_join')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <?php $sNikah = array(
                                            [
                                                "status" => "Menikah"
                                            ],
                                            [
                                                "status" => "Lajang"
                                            ]);
                                            ?>
                            <label for="status_nikah">Status Pernikahan</label>
                            <select name="status_nikah" id="status_nikah" class="form-control @error('status_nikah') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">Pilih Status Pernikahan</option>
                                @foreach ($sNikah as $s)
                                    @if(old('status_nikah') == $s["status"])
                                        <option value="{{ $s["status"] }}" selected>{{ $s["status"] }}</option>
                                    @else
                                        <option value="{{ $s["status"] }}">{{ $s["status"] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('status_nikah')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" id="jabatan_id" class="form-control @error('jabatan_id') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">Pilih Jabatan</option>
                                @foreach ($data_jabatan as $dj)
                                    @if(old('jabatan_id') == $dj->id)
                                    <option value="{{ $dj->id }}" selected>{{ $dj->nama_jabatan }}</option>
                                    @else
                                    <option value="{{ $dj->id }}">{{ $dj->nama_jabatan }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('jabatan_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <?php $is_admin = array(
                            [
                                "is_admin" => "admin"
                            ],
                            [
                                "is_admin" => "user"
                            ]);
                            ?>
                            <label for="is_admin">Level User</label>
                            <select name="is_admin" id="is_admin" class="form-control @error('is_admin') is-invalid @enderror selectpicker" data-live-search="true">
                                <option value="">Pilih Level</option>
                                @foreach ($is_admin as $a)
                                    @if(old('is_admin') == $a["is_admin"])
                                    <option value="{{ $a["is_admin"] }}" selected>{{ $a["is_admin"] }}</option>
                                    @else
                                    <option value="{{ $a["is_admin"] }}">{{ $a["is_admin"] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('is_admin')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="rekening">Rekening</label>
                            <input type="number" class="form-control @error('rekening') is-invalid @enderror" id="rekening" name="rekening" value="{{ old('rekening') }}">
                            @error('rekening')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row mb-2">
                        <h3 style="color: blue">Cuti & Izin</h3>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="izin_cuti">Cuti</label>
                            <input type="number" class="form-control @error('izin_cuti') is-invalid @enderror" id="izin_cuti" name="izin_cuti" value="{{ old('izin_cuti') }}">
                            @error('izin_cuti')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="izin_lainnya">Izin Masuk</label>
                            <input type="number" class="form-control @error('izin_lainnya') is-invalid @enderror" id="izin_lainnya" name="izin_lainnya" value="{{ old('izin_lainnya') }}">
                            @error('izin_lainnya')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="izin_telat">Izin Telat</label>
                            <input type="number" class="form-control @error('izin_telat') is-invalid @enderror" id="izin_telat" name="izin_telat" value="{{ old('izin_telat') }}">
                            @error('izin_telat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="izin_pulang_cepat">Izin Pulang Cepat</label>
                            <input type="number" class="form-control @error('izin_pulang_cepat') is-invalid @enderror" id="izin_pulang_cepat" name="izin_pulang_cepat" value="{{ old('izin_pulang_cepat') }}">
                            @error('izin_pulang_cepat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <br>
                    <div class="form-row mb-2">
                        <h3 style="color: blue">Penjumlahan Gaji</h3>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="gaji_pokok">Gaji Pokok</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('gaji_pokok') is-invalid @enderror" name="gaji_pokok" value="{{ old('gaji_pokok') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Bulan</span>
                                </div>
                                </div>
                                @error('gaji_pokok')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <label for="makan_transport">Makan Dan Transport</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('makan_transport') is-invalid @enderror" name="makan_transport" value="{{ old('makan_transport') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Bulan</span>
                                </div>
                                </div>
                                @error('makan_transport')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="lembur">Lembur</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('lembur') is-invalid @enderror" name="lembur" value="{{ old('lembur') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Jam</span>
                                </div>
                                </div>
                                @error('lembur')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <label for="kehadiran">100% Kehadiran</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('kehadiran') is-invalid @enderror" name="kehadiran" value="{{ old('kehadiran') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Bulan</span>
                                </div>
                                </div>
                                @error('kehadiran')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="thr">THR</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('thr') is-invalid @enderror" name="thr" value="{{ old('thr') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Bulan</span>
                                </div>
                                </div>
                                @error('thr')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <label for="bonus">Bonus</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('bonus') is-invalid @enderror" name="bonus" value="{{ old('bonus') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Bulan</span>
                                </div>
                                </div>
                                @error('bonus')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row mb-2">
                        <h3 style="color: blue">Pengurangan Gaji</h3>
                    </div>
                    <div class="form-row">
                        <div class="col">
                            <label for="izin">Izin</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('izin') is-invalid @enderror" name="izin" value="{{ old('izin') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ hari</span>
                                </div>
                                </div>
                                @error('izin')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <label for="terlambat">Terlambat</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('terlambat') is-invalid @enderror" name="terlambat" value="{{ old('terlambat') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ hari</span>
                                </div>
                                </div>
                                @error('terlambat')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col">
                            <label for="mangkir">Mangkir</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('mangkir') is-invalid @enderror" name="mangkir" value="{{ old('mangkir') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ hari</span>
                                </div>
                                </div>
                                @error('mangkir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col">
                            <label for="saldo_kasbon">Saldo Kasbon</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control money @error('saldo_kasbon') is-invalid @enderror" name="saldo_kasbon" value="{{ old('saldo_kasbon') }}">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                    <span>/ Tahun</span>
                                </div>
                                </div>
                                @error('saldo_kasbon')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <br>
                    <button type="submit" class="btn btn-primary float-right">Submit</button>
                  </form>
                  <br>
            </div>
        </div>
    </div>
    <br>
    @push('script')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.money').mask('000,000,000,000,000', {
                    reverse: true
                });
            });
        </script>
    @endpush
@endsection
