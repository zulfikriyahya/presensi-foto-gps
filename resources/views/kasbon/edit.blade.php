@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <center>
            <div class="card col-lg-5">
                <div class="p-4">
                    <form method="post" action="{{ url('/kasbon/update/'.$kasbon->id) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            @if (auth()->user()->is_admin == 'admin')
                                <label for="user_id" class="float-left">Nama Pegawai</label>
                                <select class="form-control selectpicker @error('user_id') is-invalid @enderror" id="user_id" name="user_id" data-live-search="true">
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($data_user as $du)
                                        @if(old('user_id', $kasbon->user_id) == $du->id)
                                            <option value="{{ $du->id }}" selected>{{ $du->name }}</option>
                                        @else
                                            <option value="{{ $du->id }}">{{ $du->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @else
                                <label for="pegawai" class="float-left">Nama Pegawai</label>
                                <input type="text" class="form-control @error('pegawai') is-invalid @enderror" id="pegawai" name="pegawai" value="{{ old('pegawai', $kasbon->User->name) }}" readonly>
                                <input type="hidden" name="user_id" id="user_id" value="{{ $kasbon->User->id }}">
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tanggal" class="float-left">Tanggal</label>
                            <input type="datetime" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $kasbon->tanggal) }}">
                            @error('tanggal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nominal" class="float-left">Nominal</label>
                            <input type="text" class="form-control money @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal', $kasbon->nominal) }}">
                            @error('nominal')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="keperluan" class="float-left">Keperluan</label>
                            <textarea name="keperluan" id="keperluan" class="form-control @error('keperluan') is-invalid @enderror">{{ old('keperluan', $kasbon->keperluan) }}</textarea>
                            @error('keperluan')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            @if (auth()->user()->is_admin == 'admin')
                                @php
                                    $status = array(
                                    [
                                        "status" => "PENDING",
                                    ],
                                    [
                                        "status" => "ACC",
                                    ]);
                                @endphp
                                <label for="status" class="float-left">Status</label>
                                <select class="form-control selectpicker @error('status') is-invalid @enderror" id="status" name="status" data-live-search="true">
                                    <option value="">Pilih Status</option>
                                    @foreach ($status as $stat)
                                        @if(old('status', $kasbon->status) == $stat['status'])
                                            <option value="{{ $stat['status'] }}" selected>{{ $stat['status'] }}</option>
                                        @else
                                            <option value="{{ $stat['status'] }}">{{ $stat['status'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            @else
                                <input type="hidden" name="status" value="{{ $kasbon->status }}">
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                      </form>
                </div>
            </div>
        </center>
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
