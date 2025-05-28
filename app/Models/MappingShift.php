<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingShift extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public static function dataAbsen()
    {
        date_default_timezone_set('Asia/Jakarta');
        $tglskrg = date('Y-m-d');

        $user_id = request()->input('user_id');
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');

        $data_absen = MappingShift::where('tanggal', $tglskrg)
                                    ->when($user_id, function ($query) use ($user_id) {
                                        return $query->where('user_id', $user_id);
                                    })
                                    ->when($mulai && $akhir, function ($query) use ($mulai, $akhir, $user_id) {
                                        return MappingShift::whereBetween('tanggal', [$mulai, $akhir])
                                                            ->when($user_id, function ($query) use ($user_id) {
                                                                return $query->where('user_id', $user_id);
                                                            });
                                    })
                                    ->orderBy('tanggal', 'ASC');

        return $data_absen;
    }
}
