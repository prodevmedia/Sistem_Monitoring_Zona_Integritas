<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRencanaKerjaIdToFileUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->unsignedBigInteger('rencana_kerja_id')->after('id');
            $table->foreign('rencana_kerja_id')->references('id')->on('rencana_kerjas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->dropForeign(['rencana_kerja_id']);
            $table->dropColumn('rencana_kerja_id');
        });
    }
}
