<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('foto_karyawan')->nullable();
            $table->string('foto_face_recognition')->nullable();
            $table->string('email');
            $table->string('telepon');
            $table->string('username');
            $table->string('password');
            $table->string('tgl_lahir');
            $table->string('gender');
            $table->string('tgl_join');
            $table->string('status_nikah');
            $table->text('alamat');
            $table->string('izin_cuti');
            $table->string('izin_lainnya');
            $table->string('izin_telat');
            $table->string('izin_pulang_cepat');
            $table->string('is_admin');
            $table->foreignId('jabatan_id');
            $table->foreignId('lokasi_id');
            $table->string('rekening')->nullable();
            $table->integer('gaji_pokok')->nullable();
            $table->integer('makan_transport')->nullable();
            $table->integer('lembur')->nullable();
            $table->integer('kehadiran')->nullable();
            $table->integer('thr')->nullable();
            $table->integer('bonus')->nullable();
            $table->integer('izin')->nullable();
            $table->integer('terlambat')->nullable();
            $table->integer('mangkir')->nullable();
            $table->integer('saldo_kasbon')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
