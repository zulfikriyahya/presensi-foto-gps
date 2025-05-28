@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <center>
                    
                </center>
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
                            <th>Status</th>
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
                                <td>{{ $dl->status }}</td>
                                <td>{{ $dl->CreatedBy->name }}</td>
                                <td>
                                    <form action="{{ url('/lokasi-kantor/update-pending-location/'.$dl->id) }}" method="post" class="d-inline">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button class="btn btn-success btn-sm" title="Approve" onClick="return confirm('Are You Sure To Approve?')"><i class="fa fa fa-check-circle"></i></button>
                                    </form>
                                    <form action="{{ url('/lokasi-kantor/update-pending-location/'.$dl->id) }}" method="post" class="d-inline">
                                        @method('put')
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button class="btn btn-danger btn-sm" title="Reject" onClick="return confirm('Are You Sure To Reject?')"><i class="fa fa-times-circle"></i></button>
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
