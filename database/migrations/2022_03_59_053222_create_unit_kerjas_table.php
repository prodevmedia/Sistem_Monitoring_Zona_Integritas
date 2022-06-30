<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('name',150);
            $table->string('email',100)->unique();
            // $table->string('username',10);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            // $table->string('unit_kerja',150);
            $table->unsignedBigInteger('unit_kerja_id');
            $table->foreign('unit_kerja_id')->references('id')->on('master_unit_kerjas')->onDelete('cascade');
            $table->rememberToken();
            $table->softDeletes();
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
        Schema::dropIfExists('unit_kerjas');        
    }
}
