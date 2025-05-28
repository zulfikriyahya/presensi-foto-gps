@extends('layouts.dashboard')
@section('isi')
   <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-body">
                <form action="{{ url('/rekap-data/get-data') }}">
                        <div class="form-row">
                        <div class="col-3">
                            <input type="datetime" class="form-control" name="mulai" placeholder="Tanggal Mulai" id="mulai" value="{{ request('mulai') }}">
                        </div>
                        <div class="col-3">
                            <input type="datetime" class="form-control" name="akhir" placeholder="Tanggal Akhir" id="akhir" value="{{ request('akhir') }}">
                        </div>
                        <div>
                            <button type="submit" id="search" class="form-control btn btn-primary"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
                <table class="table table-striped" id="tableprintrekap">
                    <thead>
                        <tr>
                            <th>Nama Pegawai</th>
                            <th>Total Cuti</th>
                            <th>Total Izin Masuk</th>
                            <th>Total Izin Telat</th>
                            <th>Total Izin Pulang Cepat</th>
                            <th>Total Hadir</th>
                            <th>Total Alfa</th>
                            <th>Total Libur</th>
                            <th>Total Telat</th>
                            <th>Total Pulang Cepat</th>
                            <th>Total Lembur</th>
                            <th>Persentase Kehadiran</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_user as $du)
                        <tr>
                            <td>
                                {{ $du->name }}
                            </td>

                            <td>
                                @php
                                    echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Izin Cuti')->where('status_cuti', 'Diterima')->count() . " x";
                                @endphp
                            </td>
                            <td>
                                @php
                                    echo $du->Cuti->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('nama_cuti', 'Izin Masuk')->where('status_cuti', 'Diterima')->count() . " x";
                                @endphp
                            </td>
                            <td>
                                @php
                                    $jumlah_izin_telat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Telat')->count();
                                @endphp
                                {{ $jumlah_izin_telat . " x" }}
                            </td>
                            <td>
                                @php
                                    $jumlah_izin_pulang_cepat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Izin Pulang Cepat')->count();
                                @endphp
                                {{ $jumlah_izin_pulang_cepat . " x" }}
                            </td>
                            <td>
                                @php
                                    $jumlah_hadir = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', '=', 'Masuk')->count();
                                @endphp
                                {{ $jumlah_hadir + $jumlah_izin_telat + $jumlah_izin_pulang_cepat. " x" }}
                            </td>
                            <td>
                                @php
                                    echo $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Tidak Masuk')->count() . " x";
                                @endphp
                            </td>
                            <td>
                                @php
                                    $libur = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('status_absen', 'Libur')->count();
                                @endphp
                                {{ $libur }} x
                            </td>
                            <td>
                                @php
                                    $total_telat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('telat');
                                    $jam   = floor($total_telat / (60 * 60));
                                    $menit = $total_telat - ( $jam * (60 * 60) );
                                    $menit2 = floor($menit / 60);
                                    $jumlah_telat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('telat', '>', 0)->count();
                                @endphp

                                @if($jam <= 0 && $menit2 <= 0)
                                    <span class="badge badge-success">Tidak Pernah Telat</span>
                                @else
                                    <span class="badge badge-danger">{{ $jam." Jam ".$menit2." Menit" }}</span>
                                    <br>
                                    <span class="badge badge-danger">{{ $jumlah_telat }} x</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $total_pulang_cepat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('pulang_cepat');
                                    $jam_cepat   = floor($total_pulang_cepat / (60 * 60));
                                    $menit_cepat = $total_pulang_cepat - ( $jam_cepat * (60 * 60) );
                                    $menit_cepat2 = floor($menit_cepat / 60);
                                    $jumlah_pulang_cepat = $du->MappingShift->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->where('pulang_cepat', '>', 0)->count();
                                @endphp

                                @if($jam_cepat <= 0 && $menit_cepat2 <= 0)
                                    <span class="badge badge-success">Tidak Pernah Pulang Cepat</span>
                                @else
                                    <span class="badge badge-danger">{{ $jam_cepat." Jam ".$menit_cepat2." Menit" }}</span>
                                    <br>
                                    <span class="badge badge-danger">{{ $jumlah_pulang_cepat }} x</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $total_lembur = $du->Lembur->where('status', 'Approved')->whereBetween('tanggal', [$tanggal_mulai, $tanggal_akhir])->sum('total_lembur');
                                    $jam   = floor($total_lembur / (60 * 60));
                                    $menit = $total_lembur - ( $jam * (60 * 60) );
                                    $menit2 = floor($menit / 60);
                                    $detik = $total_lembur % 60;
                                @endphp

                                <span class="badge badge-success">{{ $jam." Jam ".$menit2." Menit" }}</span>
                            </td>
                            <td>
                                @php
                                    $timestamp_mulai = strtotime($tanggal_mulai);
                                    $timestamp_akhir = strtotime($tanggal_akhir);
                                    $selisih_timestamp = $timestamp_akhir - $timestamp_mulai;
                                    $jumlah_hari = (floor($selisih_timestamp / (60 * 60 * 24)))+1;
                                    $persentase_kehadiran = (($jumlah_hadir + $jumlah_izin_telat + $jumlah_izin_pulang_cepat + $libur) / $jumlah_hari) * 100;
                                @endphp
                                {{ $persentase_kehadiran }} %
                            </td>
                            <td>
                                @php
                                    $pecah_tanggal = explode("-", $tanggal_mulai);
                                    $tahun_filter = $pecah_tanggal[0];
                                    $bulan_filter = $pecah_tanggal[1];
                                    $payroll = App\Models\Payroll::where('user_id', $du->id)->where('bulan', $bulan_filter)->where('tahun', $tahun_filter)->first();
                                @endphp
                                @if ($payroll)
                                    <span class="badge badge-success">Terinput</span>
                                @else
                                    <a href="{{ url('/rekap-data/payroll/'.$du->id) }}{{ $_GET?'?'.$_SERVER['QUERY_STRING']: '' }}" class="btn btn-sm btn-secondary" title="Input Gaji">Input Gaji</a>
                                @endif
                                <a href="{{ url('/data-absen/export?user_id='.$du->id) }}{{ $_GET?'&'.$_SERVER['QUERY_STRING']: '' }}" class="btn btn-sm btn-primary" title="Download Absen"><i class="fa fa-print"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mr-4">
                    {{ $data_user->links() }}
                </div>
            </div>
        </div>
    </div>
<br>
@endsection
