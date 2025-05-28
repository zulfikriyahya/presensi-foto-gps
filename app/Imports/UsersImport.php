<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            "name" => $row[0],
            "email" => $row[1],
            "telepon" => $row[2],
            "username" => $row[3],
            "password" => Hash::make($row[4]),
            "tgl_lahir" => $row[5],
            "gender" => $row[6],
            "tgl_join" => $row[7],
            "status_nikah" => $row[8],
            "alamat" => $row[9],
            "izin_cuti" => $row[10],
            "izin_lainnya" => $row[11],
            "izin_telat" => $row[12],
            "izin_pulang_cepat" => $row[13],
            "is_admin" => $row[14],
            "jabatan_id" => $row[15],
            "lokasi_id" => $row[16],
            "rekening" => $row[17],
            "gaji_pokok" => $row[18],
            "makan_transport" => $row[19],
            "lembur" => $row[20],
            "kehadiran" => $row[21],
            "thr" => $row[22],
            "bonus" => $row[23],
            "izin" => $row[24],
            "terlambat" => $row[25],
            "mangkir" => $row[26],
            "saldo_kasbon" => $row[27],
        ]);
    }
}
