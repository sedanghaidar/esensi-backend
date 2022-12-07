<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);            // nama kegiatan
            $table->date('date')->nullable(false);          // tanggal kegiatan
            $table->time('time')->nullable(false);          // waktu kegiatan
            $table->string('location')->nullable(false);    // lokasi  kegiatan
            $table->integer('created_by');                 // User ID pembuat kegiatan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
