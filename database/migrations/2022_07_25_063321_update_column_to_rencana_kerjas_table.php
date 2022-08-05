<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnToRencanaKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->unsignedBigInteger('master_unit_kerja_id')->after('id');
            $table->foreign('master_unit_kerja_id')->references('id')->on('master_unit_kerjas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->dropForeign(['master_unit_kerja_id']);
            $table->dropColumn('master_unit_kerja_id');
        });
    }
}
