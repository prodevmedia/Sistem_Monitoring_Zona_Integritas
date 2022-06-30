<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scoring_sub_area_perubahans', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('area_perubahan_id')->after('id');   
            $table->foreign('area_perubahan_id')->references('id')->on('area_perubahans');
        });
        Schema::table('scoring_area_perubahans', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('area_perubahan_id')->after('id');
            $table->foreign('area_perubahan_id')->references('id')->on('area_perubahans');
            $table->unsignedBigInteger('sub_area_perubahan_id')->after('area_perubahan_id');
            $table->foreign('sub_area_perubahan_id')->references('id')->on('sub_area_perubahans');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scoring_sub_area_perubahans', function (Blueprint $table) {
            //
        });
    }
}
