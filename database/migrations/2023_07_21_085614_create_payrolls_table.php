<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('persentase_kehadiran');
            $table->string('no_gaji');
            $table->integer('gaji_pokok');
            $table->integer('uang_transport');
            $table->integer('jumlah_mangkir');
            $table->integer('uang_mangkir');
            $table->integer('total_mangkir');
            $table->integer('jumlah_lembur');
            $table->integer('uang_lembur');
            $table->integer('total_lembur');
            $table->integer('jumlah_izin');
            $table->integer('uang_izin');
            $table->integer('total_izin');
            $table->integer('jumlah_bonus');
            $table->integer('uang_bonus');
            $table->integer('total_bonus');
            $table->integer('jumlah_terlambat');
            $table->integer('uang_terlambat');
            $table->integer('total_terlambat');
            $table->integer('jumlah_kehadiran');
            $table->integer('uang_kehadiran');
            $table->integer('total_kehadiran');
            $table->integer('saldo_kasbon');
            $table->integer('bayar_kasbon');
            $table->integer('jumlah_thr');
            $table->integer('uang_thr');
            $table->integer('total_thr');
            $table->integer('loss');
            $table->integer('total_penjumlahan');
            $table->integer('total_pengurangan');
            $table->integer('grand_total');
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
        Schema::dropIfExists('payrolls');
    }
}
