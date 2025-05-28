<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\MappingShift;
use RealRashid\SweetAlert\Facades\Alert;

class CutiController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $user = User::findOrFail(auth()->user()->id);

        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');

        $cuti = Cuti::where('user_id', $user_id)
                    ->when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                        return $query->whereBetween('tanggal', [$mulai, $akhir]);
                                                            
                    })
                    ->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('cuti.index', [
            'title' => 'Tambah Permintaan Cuti Karyawan',
            'data_user' => $user,
            'data_cuti_user' => $cuti
        ]);
    }

    public function tambah(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if($request["tanggal_mulai"] == null) {
            $request["tanggal_mulai"] = $request["tanggal_akhir"];
        } else {
            $request["tanggal_mulai"] = $request["tanggal_mulai"];
        }

        if($request["tanggal_akhir"] == null) {
            $request["tanggal_akhir"] = $request["tanggal_mulai"];
        } else {
            $request["tanggal_akhir"] = $request["tanggal_akhir"];
        }

        $begin = new \DateTime($request["tanggal_mulai"]);
        $end = new \DateTime($request["tanggal_akhir"]);
        $end = $end->modify('+1 day');

        $interval = new \DateInterval('P1D'); //referensi : https://en.wikipedia.org/wiki/ISO_8601#Durations
        $daterange = new \DatePeriod($begin, $interval ,$end);

        foreach ($daterange as $date) {
            $request["tanggal"] = $date->format("Y-m-d");

            $request['status_cuti'] = "Pending";
            $validatedData = $request->validate([
                'user_id' => 'required',
                'nama_cuti' => 'required',
                'tanggal' => 'required',
                'alasan_cuti' => 'required',
                'foto_cuti' => 'image|file|max:10240',
                'status_cuti' => 'required',
            ]);

            if ($request->file('foto_cuti')) {
                $validatedData['foto_cuti'] = $request->file('foto_cuti')->store('foto_cuti');
            }

            Cuti::create($validatedData);
        }

        return redirect('/cuti')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function delete($id)
    {
        $delete = Cuti::find($id);
        // Storage::delete($delete->foto_cuti);
        $delete->delete();
        return redirect('/cuti')->with('success', 'Data Berhasil di Delete');
    }

    public function edit($id){
        return view('cuti.edit', [
            'title' => 'Edit Permintaan Cuti',
            'data_cuti_user' => Cuti::findOrFail($id)
        ]);
    }

    public function editProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'nama_cuti' => 'required',
            'tanggal' => 'required',
            'alasan_cuti' => 'required',
            'foto_cuti' => 'image|file|max:10240',
        ]);

        if ($request->file('foto_cuti')) {
            // if ($request->foto_cuti_lama) {
            //     Storage::delete($request->foto_cuti_lama);
            // }
            $validatedData['foto_cuti'] = $request->file('foto_cuti')->store('foto_cuti');
        }

        Cuti::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/cuti');
    }

    public function dataCuti()
    {
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');

        $cuti = Cuti::when($mulai && $akhir, function ($query) use ($mulai, $akhir) {
                        return $query->whereBetween('tanggal', [$mulai, $akhir]);
                                                            
                    })
                    ->orderBy('id', 'desc')->paginate(10)->withQueryString();
        
        return view('cuti.datacuti', [
            'title' => 'Data Cuti Karyawan',
            'data_cuti' => $cuti
        ]);
    }

    public function tambahAdmin()
    {
        return view('cuti.tambahadmin', [
            'title' => 'Tambah Cuti Pegawai',
            'data_user' => User::select('id', 'name')->get()
        ]);
    }

    public function getUserId(Request $request)
    {
        $id = $request["id"];
        $data_user = User::findOrfail($id);
        
        $izin_cuti = $data_user->izin_cuti;
        $izin_lainnya = $data_user->izin_lainnya;
        $izin_telat = $data_user->izin_telat;
        $izin_pulang_cepat = $data_user->izin_pulang_cepat;
        
        $data_cuti = array(
            [
                'nama' => 'Cuti',
                'nama_cuti' => 'Cuti ('.$izin_cuti.')'
            ],
            [
                'nama' => 'Izin Masuk',
                'nama_cuti' => 'Izin Masuk ('.$izin_lainnya.')'
            ],
            [
                'nama' => 'Izin Telat',
                'nama_cuti' => 'Izin Telat ('.$izin_telat.')'
            ],
            [
                'nama' => 'Izin Pulang Cepat',
                'nama_cuti' => 'Izin Pulang Cepat ('.$izin_pulang_cepat.')'
            ]
        );
                
        echo "<option value='' selected>Pilih Cuti</option>";
        foreach($data_cuti as $dc){
            echo "
                <option value='$dc[nama]'>$dc[nama_cuti]</option>
            ";
        }
    }

    public function tambahAdminProses(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');

        if($request["tanggal_mulai"] == null) {
            $request["tanggal_mulai"] = $request["tanggal_akhir"];
        } else {
            $request["tanggal_mulai"] = $request["tanggal_mulai"];
        }

        if($request["tanggal_akhir"] == null) {
            $request["tanggal_akhir"] = $request["tanggal_mulai"];
        } else {
            $request["tanggal_akhir"] = $request["tanggal_akhir"];
        }

        $begin = new \DateTime($request["tanggal_mulai"]);
        $end = new \DateTime($request["tanggal_akhir"]);
        $end = $end->modify('+1 day');

        $interval = new \DateInterval('P1D'); //referensi : https://en.wikipedia.org/wiki/ISO_8601#Durations
        $daterange = new \DatePeriod($begin, $interval ,$end);

        foreach ($daterange as $date) {
            $request["tanggal"] = $date->format("Y-m-d");

            $request['status_cuti'] = "Pending";
            $validatedData = $request->validate([
                'user_id' => 'required',
                'nama_cuti' => 'required',
                'tanggal' => 'required',
                'alasan_cuti' => 'required',
                'foto_cuti' => 'image|file|max:10240',
                'status_cuti' => 'required',
            ]);

            if ($request->file('foto_cuti')) {
                $validatedData['foto_cuti'] = $request->file('foto_cuti')->store('foto_cuti');
            }

            Cuti::create($validatedData);
        }

        return redirect('/data-cuti')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function deleteAdmin($id)
    {
        $delete = Cuti::find($id);
        // Storage::delete($delete->foto_cuti);
        $delete->delete();
        return redirect('/data-cuti')->with('success', 'Data Berhasil di Delete');
    }

    public function editAdmin($id)
    {
        return view('cuti.editadmin', [
            'title' => 'Edit Cuti Karyawan',
            'data_cuti_karyawan' => Cuti::findOrFail($id)
        ]);
    }

    public function editAdminProses(Request $request, $id)
     {
        $data_cuti = Cuti::find($id);

        $request["izin_cuti"] = $data_cuti->User->izin_cuti;
        $request["izin_lainnya"] = $data_cuti->User->izin_lainnya;
        $request["izin_telat"] = $data_cuti->User->izin_telat;
        $request["izin_pulang_cepat"] = $data_cuti->User->izin_pulang_cepat;
        $user_id = $data_cuti->user_id;
        $foto_cuti = $data_cuti->foto_cuti;
        
        $mapping_shift = MappingShift::where('tanggal', $request['tanggal'])->where('user_id', $user_id)->first();

        if(!$mapping_shift) {
            Alert::error('Error', 'Tidak Ada Shift Pada Tanggal ' . $request['tanggal'] . ', Harap Admin Input Shift Terlebih Dahulu');
            return back();
        } else {
            $mp_id = $mapping_shift->id;
            $status_absen = $mapping_shift->status_absen;
            $shift_masuk = $mapping_shift->Shift->jam_masuk;
            $shift_pulang = $mapping_shift->Shift->jam_keluar;
            $jam_absen = $mapping_shift->jam_absen;
            $telat = $mapping_shift->telat;
            $lat_absen = $mapping_shift->lat_absen;
            $long_absen = $mapping_shift->long_absen;
            $jarak_masuk = $mapping_shift->jarak_masuk;
            $foto_jam_absen = $mapping_shift->foto_jam_absen;
            $jam_pulang = $mapping_shift->jam_pulang;
            $pulang_cepat = $mapping_shift->pulang_cepat;
            $lat_pulang = $mapping_shift->lat_pulang;
            $long_pulang = $mapping_shift->long_pulang;
            $jarak_pulang = $mapping_shift->jarak_pulang;
            $foto_jam_pulang = $mapping_shift->foto_jam_pulang;
    
            if($request["status_cuti"] == "Diterima"){
                
                
                if($request["nama_cuti"] == "Cuti") {
                    $request["izin_cuti"] = $request["izin_cuti"] - 1;
                    $request['status_absen'] = $request["nama_cuti"];
                } elseif($request["nama_cuti"] == "Izin Masuk") {
                    $request["izin_lainnya"] = $request["izin_lainnya"] - 1;
                    $request['status_absen'] = $request["nama_cuti"];
                } elseif($request["nama_cuti"] == "Izin Telat") {
                    $request["izin_telat"] = $request["izin_telat"] - 1;
                    $request['status_absen'] = $request["nama_cuti"];
                    $request['jam_absen'] = $shift_masuk;
                    $request['telat'] = 0;
                    $request['lat_absen'] = "-6.3707314";
                    $request['long_absen'] = "106.8138057";
                    $request['jarak_masuk'] = "0";
                    $request['jam_pulang'] = $jam_pulang;
                    $request['foto_jam_absen'] = $foto_cuti;
                    $request['pulang_cepat'] = $pulang_cepat;
                    $request['lat_pulang'] = $lat_pulang;
                    $request['long_pulang'] = $long_pulang;
                    $request['jarak_pulang'] = $jarak_pulang;
                    $request['foto_jam_pulang'] = $foto_jam_pulang;
                } else {
                    $request["izin_pulang_cepat"] = $request["izin_pulang_cepat"] - 1;
                    $request['status_absen'] = $request["nama_cuti"];
                    $request['jam_pulang'] = $shift_pulang;
                    $request['pulang_cepat'] = 0;
                    $request['lat_pulang'] = "-6.3707314";
                    $request['long_pulang'] = "106.8138057";
                    $request['jarak_masuk'] = $jarak_masuk;
                    $request['foto_jam_pulang'] = $foto_cuti;
                    $request['jam_absen'] = $jam_absen;
                    $request['telat'] = $telat;
                    $request['lat_absen'] = $lat_absen;
                    $request['long_absen'] = $long_absen;
                    $request['jarak_pulang'] = "0";
                    $request['foto_jam_absen'] = $foto_jam_absen;
                }
            } else {
                $request["izin_cuti"];
                $request["izin_dinas_luar"];
                $request["izin_sakit"];
                $request["izin_cek_kesehatan"];
                $request["izin_keperluan_pribadi"];
                $request["izin_lainnya"];
                $request["izin_telat"];
                $request["izin_pulang_cepat"];
                $request['status_absen'] = $status_absen;
                $request["jam_absen"] = $jam_absen;
                $request["telat"] = $telat;
                $request["lat_absen"] = $lat_absen;
                $request["long_absen"] = $long_absen;
                $request["jarak_masuk"] = $jarak_masuk;
                $request["foto_jam_absen"] = $foto_jam_absen;
                $request["jam_pulang"] = $jam_pulang;
                $request["pulang_cepat"] = $pulang_cepat;
                $request["lat_pulang"] = $lat_pulang;
                $request["long_pulang"] = $long_pulang;
                $request["jarak_pulang"] = $jarak_pulang;
                $request["foto_jam_pulang"] = $foto_jam_pulang;
            }
    
            $rules1 = [
                'nama_cuti' => 'required',
                'tanggal' => 'required',
                'status_cuti' => 'required',
                'catatan' => 'nullable'
            ];
    
            $rules2 = [
                'izin_cuti' => 'required',
                'izin_lainnya' => 'required',
                'izin_telat' => 'required',
                'izin_pulang_cepat' => 'required',
            ];
    
            $rules3 = [
                'status_absen' => 'required',
                'jam_absen' => 'nullable',
                'telat' => 'nullable',
                'lat_absen' => 'nullable',
                'long_absen' => 'nullable',
                'jarak_masuk' => 'nullable',
                'foto_jam_absen' => 'nullable',
                'jam_pulang' => 'nullable',
                'pulang_cepat' => 'nullable',
                'foto_jam_pulang' => 'nullable',
                'lat_pulang' => 'nullable',
                'long_pulang' => 'nullable',
                'jarak_pulang' => 'nullable'
            ];
    
            $validatedData = $request->validate($rules1);
            $validatedData2 = $request->validate($rules2);
            $validatedData3 = $request->validate($rules3);
    
    
            Cuti::where('id', $id)->update($validatedData);
            User::where('id', $user_id)->update($validatedData2);
            MappingShift::where('id', $mp_id)->update($validatedData3);
            
    
            $request->session()->flash('success', 'Data Berhasil di Update');
            return redirect('/data-cuti');
        }
    }

}
