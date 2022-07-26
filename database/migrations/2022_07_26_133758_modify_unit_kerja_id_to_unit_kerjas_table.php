<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUnitKerjaIdToUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->renameColumn('unit_kerja_id', 'master_unit_kerja_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unit_kerjas', function (Blueprint $table) {
            $table->renameColumn('master_unit_kerja_id', 'unit_kerja_id');
        });
    }
}
