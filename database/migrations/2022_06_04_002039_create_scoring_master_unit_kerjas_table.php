<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoringMasterUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scoring_master_unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('unit_kerja_id');
            $table->foreign('unit_kerja_id')->references('id')->on('unit_kerjas');
            $table->unsignedBigInteger('file_id');
            $table->foreign('file_id')->references('id')->on('file_uploads');
            $table->unsignedDouble('bobot');
            $table->string("penjelasan",150)->default("-");
            $table->string("pilihan_jawaban",150)->default("-");
            $table->string("jawaban",150)->default("-");
            $table->unsignedInteger("nilai");
            $table->unsignedInteger("presentase");
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
        Schema::dropIfExists('scoring_master_unit_kerjas');
    }
}
