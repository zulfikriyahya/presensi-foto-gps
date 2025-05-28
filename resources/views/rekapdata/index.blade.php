@extends('layouts.dashboard')
@section('isi')
    <center>
        <div class="container-fluid">
            <div class="card col-lg-4">
                <div class="p-4">
                    <form method="get" action="{{ url('/rekap-data/get-data') }}">
                        <div class="form-group">
                            <label for="mulai" class="float-left">Tanggal Mulai</label>
                            <input type="datetime" class="form-control @error('mulai') is-invalid @enderror" id="mulai" name="mulai" autofocus value="{{ old('mulai') }}">
                            @error('mulai')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="akhir" class="float-left">Tanggal Akhir</label>
                            <input type="datetime" class="form-control @error('akhir') is-invalid @enderror" id="akhir" name="akhir" value="{{ old('akhir') }}">
                            @error('akhir')
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
