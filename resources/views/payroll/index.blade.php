@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="card" style="border-radius: 20px">
            <div class="card-body">
                <form action="{{ url('/payroll') }}">
                    @php
                        $bulan = array(
                        [
                            "id" => "1",
                            "bulan" => "Januari"
                        ],
                        [
                            "id" => "2",
                            "bulan" => "Februari"
                        ],
                        [
                            "id" => "3",
                            "bulan" => "Maret"
                        ],
                        [
                            "id" => "4",
                            "bulan" => "April"
                        ],
                        [
                            "id" => "5",
                            "bulan" => "Mei"
                        ],
                        [
                            "id" => "6",
                            "bulan" => "Juni"
                        ],
                        [
                            "id" => "7",
                            "bulan" => "Juli"
                        ],
                        [
                            "id" => "8",
                            "bulan" => "Agustus"
                        ],
                        [
                            "id" => "9",
                            "bulan" => "September"
                        ],
                        [
                            "id" => "10",
                            "bulan" => "Oktober"
                        ],
                        [
                            "id" => "11",
                            "bulan" => "November"
                        ],
                        [
                            "id" => "12",
                            "bulan" => "Desember"
                        ]);

                        $last = date('Y')-10;
                        $now = date('Y');
                    @endphp
                    <div class="form-row mb-2">
                        <div class="col-2">
                            <select name="tahun" id="tahun" class="form-control selectpicker" data-live-search="true">
                                @for ($i = $now; $i >= $last; $i--)
                                    @if(old('tahun', $now) == $i)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="bulan" id="bulan" class="form-control selectpicker" data-live-search="true">
                                <option value=""selected>Bulan</option>
                                @foreach($bulan as $bul)
                                    @if(request('bulan') == $bul['id'])
                                        <option value="{{ $bul['id'] }}"selected>{{ $bul['bulan'] }}</option>
                                    @else
                                        <option value="{{ $bul['id'] }}">{{ $bul['bulan'] }}</option>
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
                            <th>Nomor Gaji</th>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Bulan</th>
                            <th>Kasbon</th>
                            <th>Grand Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $d->no_gaji }}</td>
                                <td>{{ $d->User->name  }}</td>
                                <td>{{ $d->User->Jabatan->nama_jabatan  }}</td>
                                <td>
                                    @php
                                        if ($d->bulan == 1){
                                            $nama_bulan = 'Januari';
                                        } else if($d->bulan == 2) {
                                            $nama_bulan = 'Februari';
                                        } else if($d->bulan == 3) {
                                            $nama_bulan = 'Maret';
                                        } else if($d->bulan == 4) {
                                            $nama_bulan = 'April';
                                        } else if($d->bulan == 5) {
                                            $nama_bulan = 'Mei';
                                        } else if($d->bulan == 6) {
                                            $nama_bulan = 'Juni';
                                        } else if($d->bulan == 7) {
                                            $nama_bulan = 'Juli';
                                        } else if($d->bulan == 8) {
                                            $nama_bulan = 'Agustus';
                                        } else if($d->bulan == 9) {
                                            $nama_bulan = 'September';
                                        } else if($d->bulan == 10) {
                                            $nama_bulan = 'Oktober';
                                        } else if($d->bulan == 11) {
                                            $nama_bulan = 'November';
                                        } else if($d->bulan == 12) {
                                            $nama_bulan = 'Desember';
                                        } else {
                                            $nama_bulan = '-';
                                        }
                                    @endphp
                                    {{ $nama_bulan  }} {{ $d->tahun }}
                                </td>
                                <td>Rp {{ number_format($d->bayar_kasbon) }}</td>
                                <td>Rp {{ number_format($d->grand_total) }}</td>
                                <td>
                                    <a href="{{ url('/payroll/'.$d->id.'/download') }}" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-solid fa-print"></i></a>
                                    @can('admin')
                                        <a href="{{ url('/payroll/'.$d->id.'/edit') }}" class="btn btn-sm btn-warning"><i class="fa fa-solid fa-edit"></i></a>
                                        <form action="{{ url('/payroll/'.$d->id.'/delete') }}" method="post" class="d-inline">
                                            @method('delete')
                                            @csrf
                                            <button class="btn btn-danger btn-sm btn-circle" onClick="return confirm('Are You Sure')"><i class="fa fa-solid fa-trash"></i></button>
                                        </form>
                                    @endcan
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
