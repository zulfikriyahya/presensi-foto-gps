@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card" style="border-radius: 20px">
            <div class="card-header">
                <a href="{{ url('/kasbon/tambah') }}" class="btn btn-sm btn-primary" style="border-radius: 10px">+ Tambah Data Kasbon</a>
            </div>
            <div class="card-body">
                <form action="{{ url('/kasbon') }}">
                    @php
                        $status = array(
                        [
                            "status" => "PENDING",
                        ],
                        [
                            "status" => "ACC",
                        ]);
                    @endphp
                    <div class="form-row mb-2">
                        <div class="col-2">
                            <input type="datetime" class="form-control" name="tanggal" placeholder="Tanggal" id="tanggal" value="{{ request('tanggal') }}">
                        </div>
                        <div class="col-2">
                            <select name="status" id="status" class="form-control selectpicker" data-live-search="true">
                                <option value=""selected>Status</option>
                                @foreach($status as $stat)
                                    @if(request('status') == $stat['status'])
                                        <option value="{{ $stat['status'] }}"selected>{{ $stat['status'] }}</option>
                                    @else
                                        <option value="{{ $stat['status'] }}">{{ $stat['status'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" id="search" class="form-control btn btn-secondary" style="border-radius: 10px"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <table id="tablePayroll" class="table table-striped">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Total</th>
                            <th>Keperluan</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->User->name  }}</td>
                                <td>Rp {{ number_format($d->nominal) }}</td>
                                <td>{{ $d->keperluan  }}</td>
                                <td>
                                    @if ($d->status == 'ACC')
                                        <span class="badge badge-success">{{ $d->status  }}</span>
                                    @else
                                        <span class="badge badge-warning">{{ $d->status  }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if (auth()->user()->is_admin == 'admin')
                                        @if ($d->status !== 'ACC')
                                            <a href="{{ url('/kasbon/edit/'.$d->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-solid fa-edit"></i></a>
                                        @endif
                                        <form action="{{ url('/kasbon/delete/'.$d->id) }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm btn-circle" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
                                        </form>
                                    @else
                                        @if ($d->status !== 'ACC')
                                            <a href="{{ url('/kasbon/edit/'.$d->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-solid fa-edit"></i></a>
                                            <form action="{{ url('/kasbon/delete/'.$d->id) }}" method="post" class="d-inline">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-danger btn-sm btn-circle" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
                                            </form>
                                        @else
                                        -
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mr-4">
                {{ $data->links() }}
            </div>
        </div>
    </div>
    <br>
@endsection
