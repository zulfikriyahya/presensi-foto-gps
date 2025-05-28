@extends('layouts.dashboard')
@section('isi')
    <center>
        <div class="container-fluid">
            <div class="card col-lg-4">
                <div class="p-4">
                    <form method="post" action="{{ url('/jabatan/update/'.$data_jabatan->id) }}">
                        @method('put')
                        @csrf
                            <div class="form-group">
                                <label for="nama_jabatan" class="float-left">Nama Jabatan</label>
                                <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" name="nama_jabatan" autofocus value="{{ old('nama_jabatan', $data_jabatan->nama_jabatan) }}">
                                @error('nama_jabatan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                      </form>
                      <br>
                </div>
            </div>
        </div>
    </center>
    <br>
@endsection
