<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubAreaPerubahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_area_perubahans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('area_perubahan_id');
            $table->foreign('area_perubahan_id')->references('id')->on('area_perubahans');
            $table->string('name_sub_area_perubahan');
            $table->string('penjelasan');
            $table->string('pilihan_jawaban');            
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('sub_area_perubahans');
    }
}
