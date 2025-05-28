@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <center>
                    <a href="{{ url('/lokasi-kantor/tambah') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data Lokasi</a>
                </center>
                <a href="{{ url('/lokasi-kantor/pending-location') }}" class="btn btn-warning float-right btn-sm"><i class="fa fa-hourglass-start mr-2"></i> Pending Location</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="tableprint" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Lokasi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Radius (Meter)</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_lokasi as $dl)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $dl->nama_lokasi }}</td>
                                <td>{{ $dl->lat_kantor }}</td>
                                <td>{{ $dl->long_kantor }}</td>
                                <td>{{ $dl->radius }}</td>
                                <td>{{ $dl->CreatedBy->name }}</td>
                                <td>
                                    <a href="{{ url('/lokasi-kantor/edit/'.$dl->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-solid fa-edit"></i></a>
                                    <form action="{{ url('/lokasi-kantor/delete/'.$dl->id) }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger btn-sm btn-circle" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <br>
@endsection
