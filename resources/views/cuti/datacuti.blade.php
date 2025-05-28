@extends('layouts.dashboard')
@section('isi')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <a class="btn btn-primary btn-sm" href="{{ url('/data-cuti/tambah') }}">+ Tambah Cuti Pegawai</a>
        </div>
        <div class="card-body p-3">
                <form action="{{ url('/data-cuti') }}">
                        <div class="form-row">
                        <div class="col-3">
                            <input type="datetime" class="form-control" name="mulai" placeholder="Tanggal Mulai" id="mulai" value="{{ request('mulai') }}">
                        </div>
                        <div class="col-3">
                            <input type="datetime" class="form-control" name="akhir" placeholder="Tanggal Akhir" id="akhir" value="{{ request('akhir') }}">
                        </div>
                        <div>
                            <button type="submit" id="search" class="form-control btn btn-secondary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped" id="tablePayroll">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Pegawai</th>
                            <th>Nama Cuti</th>
                            <th>Tanggal</th>
                            <th>Alasan Cuti</th>
                            <th>Foto Cuti</th>
                            <th>Status Cuti</th>
                            <th>Catatan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_cuti as $dc)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dc->User->name }}</td>
                            <td>{{ $dc->nama_cuti }}</td>
                            <td>{{ $dc->tanggal}}</td>
                            <td>{{ $dc->alasan_cuti}}</td>
                            <td>
                                <img src="{{ url('storage/'.$dc->foto_cuti) }}" style="width: 200px" alt="">
                            </td>
                            <td>
                                @if($dc->status_cuti == "Diterima")
                                    <span class="badge badge-success">{{ $dc->status_cuti }}</span>
                                @elseif($dc->status_cuti == "Ditolak")
                                    <span class="badge badge-danger">{{ $dc->status_cuti }}</span>
                                @else
                                    <span class="badge badge-warning">{{ $dc->status_cuti }}</span>
                                @endif
                            </td>
                            <td>{{ $dc->catatan}}</td>
                            <td>
                                @if($dc->status_cuti == "Diterima")
                                    <span class="badge badge-success">Sudah Approve</span>
                                @else
                                    <a href="{{ url('/data-cuti/edit/'.$dc->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-exclamation-triangle"></i></a>
                                @endif

                                @if($dc->status_cuti == "Diterima")
                                    <span class="badge badge-success">Sudah Approve</span>
                                @else
                                    <form action="{{ url('/data-cuti/delete/'.$dc->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm" onClick="return confirm('Are You Sure')"><i class="fas fa-trash"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mr-4">
                {{ $data_cuti->links() }}
            </div>
    </div>
</div>
<br>
    @push('script')
        <script>
            $(document).ready(function() {
                $('#mulai').change(function(){
                    var mulai = $(this).val();
                $('#akhir').val(mulai);
                });
            });
        </script>
    @endpush
@endsection
