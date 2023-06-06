<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassHasAbsensiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_class_has_absensi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('class_id');
            $table->string('present')->nullable();
            $table->string('sick')->nullable();
            $table->string('permission')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('ket')->nullable();
            $table->string('lokasi')->nullable();
            $table->timestamp('created_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_class_has_absensi');
    }
}
