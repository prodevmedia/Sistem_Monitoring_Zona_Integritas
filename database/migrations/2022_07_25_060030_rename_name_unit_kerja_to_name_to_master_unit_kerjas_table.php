<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameNameUnitKerjaToNameToMasterUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_unit_kerjas', function (Blueprint $table) {
            $table->renameColumn('name_unit_kerja', 'name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_unit_kerjas', function (Blueprint $table) {
            $table->renameColumn('name', 'name_unit_kerja');
        });
    }
}
