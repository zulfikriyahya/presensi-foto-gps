<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use App\Models\dinasLuar;
use App\Models\Jabatan;
use App\Models\Lembur;
use App\Models\Lokasi;
use App\Models\User;
use App\Models\MappingShift;
use App\Models\ResetCuti;
use App\Models\Shift;
use App\Models\Sip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Imports\UsersImport;
use App\Models\Golongan;
use App\Models\Payroll;
use Maatwebsite\Excel\Facades\Excel;


class karyawanController extends Controller
{
    public function index(Request $request)
    {
        $data = User::orderBy('name', 'ASC');
        if($request['search']){
            $searchTerm = $request['search'];
            $data = $data->where('name', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('email', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('telepon', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhere('username', 'LIKE', '%'.$searchTerm.'%')
                    ->orWhereHas('Jabatan', function ($query) use ($searchTerm) {
                        $query->where('nama_jabatan', 'LIKE', '%'.$searchTerm.'%');
                    })
                    ->orWhereHas('Golongan', function ($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', '%'.$searchTerm.'%');
                    });
        }

        return view('karyawan.index', [
            'title' => 'Pegawai',
            'data_user' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function importUsers(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xls,xlsx,csv|max:5000'
        ]);
        $file = $request->file('file_excel');
        $nama_file = $file->getClientOriginalName();
        $file->move('DataUser', $nama_file);

        Excel::import(new UsersImport, public_path('/DataUser/'.$nama_file));
        return back()->with('success', 'Data Berhasil Di Import');
    }

    public function tambahKaryawan()
    {
        return view('karyawan.tambah',[
            "title" => 'Tambah Pegawai',
            "data_jabatan" => Jabatan::all(),
            "data_lokasi" => Lokasi::where('status', 'approved')->get()
        ]);
    }

    public function tambahKaryawanProses(Request $request)
    {
        if($request["izin_cuti"] == null) {
            $request["izin_cuti"] = "0";
        } else {
            $request["izin_cuti"];
        }

        if($request["izin_lainnya"] == null) {
            $request["izin_lainnya"] = "0";
        }  else {
            $request["izin_lainnya"];
        }

        if($request["izin_telat"] == null) {
            $request["izin_telat"] = "0";
        }  else {
            $request["izin_telat"];
        }

        if($request["izin_pulang_cepat"] == null) {
            $request["izin_pulang_cepat"] = "0";
        }  else {
            $request["izin_pulang_cepat"];
        }


        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'email' => 'required|email:dns|unique:users',
            'telepon' => 'required',
            'username' => 'required|max:255|unique:users',
            'password' => 'required|min:6|max:255',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required',
            'izin_cuti' => 'required',
            'izin_lainnya' => 'required',
            'izin_telat' => 'required',
            'izin_pulang_cepat' => 'required',
            'is_admin' => 'required',
            'jabatan_id' => 'required',
            'lokasi_id' => 'required',
            'rekening' => 'nullable',
            'gaji_pokok' => 'required',
            'makan_transport' => 'required',
            'lembur' => 'required',
            'kehadiran' => 'required',
            'thr' => 'required',
            'bonus' => 'required',
            'izin' => 'required',
            'terlambat' => 'required',
            'mangkir' => 'required',
            'saldo_kasbon' => 'required',
        ]);

        $validatedData['gaji_pokok'] = str_replace(',', '', $validatedData['gaji_pokok']);
        $validatedData['makan_transport'] = str_replace(',', '', $validatedData['makan_transport']);
        $validatedData['lembur'] = str_replace(',', '', $validatedData['lembur']);
        $validatedData['kehadiran'] = str_replace(',', '', $validatedData['kehadiran']);
        $validatedData['thr'] = str_replace(',', '', $validatedData['thr']);
        $validatedData['bonus'] = str_replace(',', '', $validatedData['bonus']);
        $validatedData['izin'] = str_replace(',', '', $validatedData['izin']);
        $validatedData['terlambat'] = str_replace(',', '', $validatedData['terlambat']);
        $validatedData['mangkir'] = str_replace(',', '', $validatedData['mangkir']);
        $validatedData['saldo_kasbon'] = str_replace(',', '', $validatedData['saldo_kasbon']);

        if ($request->file('foto_karyawan')) {
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }

        $validatedData['password'] = Hash::make($validatedData['password']);
        User::create($validatedData);
        return redirect('/pegawai')->with('success', 'Data Berhasil di Tambahkan');
    }

    public function detail($id)
    {
        return view('karyawan.editkaryawan', [
            'title' => 'Detail Pegawai',
            'karyawan' => User::find($id),
            'data_jabatan' => Jabatan::all(),
            'data_lokasi' => Lokasi::where('status', 'approved')->get()
        ]);
    }

    public function editKaryawanProses(Request $request, $id)
    {
        if($request["izin_cuti"] == null) {
            $request["izin_cuti"] = "0";
        } else {
            $request["izin_cuti"];
        }

        if($request["izin_lainnya"] == null) {
            $request["izin_lainnya"] = "0";
        }  else {
            $request["izin_lainnya"];
        }

        if($request["izin_telat"] == null) {
            $request["izin_telat"] = "0";
        }  else {
            $request["izin_telat"];
        }

        if($request["izin_pulang_cepat"] == null) {
            $request["izin_pulang_cepat"] = "0";
        }  else {
            $request["izin_pulang_cepat"];
        }

        $rules = [
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required',
            'izin_cuti' => 'required',
            'izin_lainnya' => 'required',
            'izin_telat' => 'required',
            'izin_pulang_cepat' => 'required',
            'is_admin' => 'required',
            'jabatan_id' => 'required',
            'lokasi_id' => 'required',
            'rekening' => 'nullable',
            'gaji_pokok' => 'required',
            'makan_transport' => 'required',
            'lembur' => 'required',
            'kehadiran' => 'required',
            'thr' => 'required',
            'bonus' => 'required',
            'izin' => 'required',
            'terlambat' => 'required',
            'mangkir' => 'required',
            'saldo_kasbon' => 'required',
        ];


        $userId = User::find($id);

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);
        $validatedData['gaji_pokok'] = str_replace(',', '', $validatedData['gaji_pokok']);
        $validatedData['makan_transport'] = str_replace(',', '', $validatedData['makan_transport']);
        $validatedData['lembur'] = str_replace(',', '', $validatedData['lembur']);
        $validatedData['kehadiran'] = str_replace(',', '', $validatedData['kehadiran']);
        $validatedData['thr'] = str_replace(',', '', $validatedData['thr']);
        $validatedData['bonus'] = str_replace(',', '', $validatedData['bonus']);
        $validatedData['izin'] = str_replace(',', '', $validatedData['izin']);
        $validatedData['terlambat'] = str_replace(',', '', $validatedData['terlambat']);
        $validatedData['mangkir'] = str_replace(',', '', $validatedData['mangkir']);
        $validatedData['saldo_kasbon'] = str_replace(',', '', $validatedData['saldo_kasbon']);

        if ($request->file('foto_karyawan')) {
            if ($request->foto_karyawan_lama) {
                Storage::delete($request->foto_karyawan_lama);
            }
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }


        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/pegawai');
    }

    public function deleteKaryawan($id)
    {
        $delete = User::find($id);
        MappingShift::where('user_id', $id)->delete();
        Lembur::where('user_id', $id)->delete();
        Cuti::where('user_id', $id)->delete();
        Sip::where('user_id', $id)->delete();
        Payroll::where('user_id', $id)->delete();
        Storage::delete($delete->foto_karyawan);
        $delete->delete();
        return redirect('/pegawai')->with('success', 'Data Berhasil di Delete');
    }

    public function editpassword($id)
    {
        return view('karyawan.editpassword', [
            'title' => 'Edit Password',
            'karyawan' => User::find($id)
        ]);
    }

    public function face($id)
    {
        return view('karyawan.face', [
            'title' => 'Daftar Wajah',
            'karyawan' => User::find($id)
        ]);
    }

    public function ajaxDescrip(Request $request)
    {
        $json = file_get_contents('neural.json');
        if(strlen($json) > 4){
            $string = ',' . $request["myData"]; 
        }
        else{
            $string = $request["myData"];
        }
        $position = strlen($json) - 2; 
        $out = substr_replace( $json, $string, $position, 0 ); 
        file_put_contents('neural.json', $out);
    }

    public function ajaxPhoto(Request $request)
    {
        $image = $request["image"];

        $image_parts = explode(";base64,", $image);
    
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = 'foto_face_recognition/' . $request["path"] . '.png';
    
        Storage::put($fileName, $image_base64);

        $user = User::where('username', $request['path'])->update(["foto_face_recognition" => $fileName]);
        return $user;
    }

    public function editPasswordProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil Diganti');
        return redirect('/pegawai');
    }

    public function shift($id)
    {
        $tanggal = request()->input('tanggal');
        $mapping_shift = MappingShift::where('user_id', $id)
                                    ->when($tanggal, function ($query) use ($tanggal) {
                                        return $query->where('tanggal', $tanggal);
                                    })
                                    ->orderBy('tanggal', 'DESC')
                                    ->paginate(10)
                                    ->withQueryString();
        return view('karyawan.mappingshift', [
            'title' => 'Mapping Shift',
            'karyawan' => User::find($id),
            'shift_karyawan' => $mapping_shift,
            'shift' => Shift::all()
        ]);
    }

    public function dinasLuar($id)
    {
        return view('karyawan.dinasluar', [
            'title' => 'Mapping Dinas Luar',
            'karyawan' => User::find($id),
            'dinas_luar' => dinasLuar::where('user_id', $id)->orderBy('id', 'desc')->limit(100)->get(),
            'shift' => Shift::all()
        ]);
    }

    public function prosesTambahShift(Request $request)
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
            $tanggal = $date->format("Y-m-d");

            $cek = MappingShift::where('user_id', $request['user_id'])->where('tanggal', $tanggal)->first();

            if (!$cek) {
                if ($request["shift_id"] == 1) {
                    $request["status_absen"] = "Libur";
                } else {
                    $request["status_absen"] = "Tidak Masuk";
                }
    
                $request["tanggal"] = $tanggal;
    
                $validatedData = $request->validate([
                    'user_id' => 'required',
                    'shift_id' => 'required',
                    'tanggal' => 'required',
                    'status_absen' => 'required',
                ]);

                $validatedData['telat'] = 0;
                $validatedData['pulang_cepat'] = 0;
    
                MappingShift::create($validatedData);
            }
        }
        return redirect('/pegawai/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Tambahkan');
    }

    public function prosesTambahDinas(Request $request)
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
            $tanggal = $date->format("Y-m-d");

            if ($request["shift_id"] == 1) {
                $request["status_absen"] = "Libur";
            } else {
                $request["status_absen"] = "Tidak Masuk";
            }

            $request["tanggal"] = $tanggal;

            $validatedData = $request->validate([
                'user_id' => 'required',
                'shift_id' => 'required',
                'tanggal' => 'required',
                'status_absen' => 'required',
            ]);

            dinasLuar::create($validatedData);
        }
        return redirect('/pegawai/dinas-luar/' . $request["user_id"])->with('success', 'Data Berhasil di Tambahkan');
    }

    public function deleteShift(Request $request, $id)
    {
        $delete = MappingShift::find($id);
        $delete->delete();
        return redirect('/pegawai/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Delete');
    }

    public function deleteDinas(Request $request, $id)
    {
        $delete = dinasLuar::find($id);
        $delete->delete();
        return redirect('/pegawai/dinas-luar/' . $request["user_id"])->with('success', 'Data Berhasil di Delete');
    }

    public function editShift($id)
    {
        return view('karyawan.editshift', [
            'title' => 'Edit Shift',
            'shift_karyawan' => MappingShift::find($id),
            'shift' => Shift::all()
        ]);
    }

    public function editDinas($id)
    {
        return view('karyawan.editdinas', [
            'title' => 'Edit Dinas',
            'dinas_luar' => dinasLuar::find($id),
            'shift' => Shift::all()
        ]);
    }

    public function prosesEditShift(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');


        if ($request["shift_id"] == 1) {
            $request["status_absen"] = "Libur";
        } else {
            $request["status_absen"] = "Tidak Masuk";
        }

        $validatedData = $request->validate([
            'shift_id' => 'required',
            'tanggal' => 'required',
            'status_absen' => 'required'
        ]);

        MappingShift::where('id', $id)->update($validatedData);
        return redirect('/pegawai/shift/' . $request["user_id"])->with('success', 'Data Berhasil di Update');
    }

    public function prosesEditDinas(Request $request, $id)
    {
        date_default_timezone_set('Asia/Jakarta');


        if ($request["shift_id"] == 1) {
            $request["status_absen"] = "Libur";
        } else {
            $request["status_absen"] = "Tidak Masuk";
        }

        $validatedData = $request->validate([
            'shift_id' => 'required',
            'tanggal' => 'required',
            'status_absen' => 'required'
        ]);

        dinasLuar::where('id', $id)->update($validatedData);
        return redirect('/pegawai/dinas-luar/' . $request["user_id"])->with('success', 'Data Berhasil di Update');
    }

    public function myProfile()
    {
        return view('karyawan.myprofile', [
            'title' => 'My Profile',
            'data_jabatan' => Jabatan::all()
        ]);
    }

    public function myProfileUpdate(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:255',
            'foto_karyawan' => 'image|file|max:10240',
            'telepon' => 'required',
            'password' => 'required',
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'tgl_join' => 'required',
            'status_nikah' => 'required',
            'alamat' => 'required',
            'rekening' => 'required',
        ];


        $userId = User::find($id);

        if ($request->email != $userId->email) {
            $rules['email'] = 'required|email:dns|unique:users';
        }

        if ($request->username != $userId->username) {
            $rules['username'] = 'required|max:255|unique:users';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('foto_karyawan')) {
            if ($request->foto_karyawan_lama) {
                Storage::delete($request->foto_karyawan_lama);
            }
            $validatedData['foto_karyawan'] = $request->file('foto_karyawan')->store('foto_karyawan');
        }


        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Data Berhasil di Update');
        return redirect('/my-profile');
    }

    public function editPassMyProfile()
    {
        return view('karyawan.editpassmyprofile', [
            'title' => 'Ganti Password'
        ]);
    }

    public function editPassMyProfileProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required|min:6|max:255|confirmed',
        ]);

        $validatedData['password'] = Hash::make($request->password);

        User::where('id', $id)->update($validatedData);
        $request->session()->flash('success', 'Password Berhasil di Update');
        return redirect('/my-profile');
    }

    public function resetCuti()
    {
        return view('karyawan.masterreset', [
            'title' => 'Master Data Reset Cuti',
            'data_cuti' => ResetCuti::first()
        ]);
    }

    public function resetCutiProses(Request $request, $id)
    {
        $validatedData = $request->validate([
            'izin_cuti' => 'required',
            'izin_dinas_luar' => 'required',
            'izin_sakit' => 'required',
            'izin_cek_kesehatan' => 'required',
            'izin_keperluan_pribadi' => 'required',
            'izin_lainnya' => 'required',
            'izin_telat' => 'required',
            'izin_pulang_cepat' => 'required'
        ]);

        ResetCuti::where('id', $id)->update($validatedData);
        return redirect('/reset-cuti')->with('success', 'Master Cuti Berhasil Diupdate');
    }

}
