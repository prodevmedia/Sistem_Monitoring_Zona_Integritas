<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRencanaKerjaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rencana_kerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_perubahan_id');
            $table->foreign('area_perubahan_id')->references('id')->on('area_perubahans');
            $table->dateTimeTz('tanggal_waktu');
            $table->string('realisasi');
            $table->string('rencana_aksi');
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
        Schema::dropIfExists('rencana_kerja');
    }
}
