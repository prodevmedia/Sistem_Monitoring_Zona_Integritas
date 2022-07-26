<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPenilaianToRencanaKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rencana_kerjas', function (Blueprint $table) {
            $table->enum('status', ['Belum Upload', 'Belum Evaluasi', 'Revisi', 'Sudah Evaluasi'])->default('Belum Upload')->after('rencana_aksi');
            $table->integer('nilai')->nullable()->after('status');
            $table->text('keterangan')->nullable()->after('nilai');
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
            $table->dropColumn('status');
            $table->dropColumn('nilai');
            $table->dropColumn('keterangan');
        });
    }
}
