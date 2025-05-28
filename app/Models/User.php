<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    public function MappingShift()
    {
        return $this->hasMany(MappingShift::class);
    }
    
    public function dinasLuar()
    {
        return $this->hasMany(dinasLuar::class);
    }
    
    public function Sip()
    {
        return $this->hasMany(Sip::class);
    }

    public function Lembur()
    {
        return $this->hasMany(Lembur::class);
    }

    public function Payroll()
    {
        return $this->hasMany(Payroll::class);
    }

    public function Pajak()
    {
        return $this->hasMany(Pajak::class);
    }

    public function Cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    public function Jabatan()
    {
        return $this->belongsTo(Jabatan::class);
    }

    public function Lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
