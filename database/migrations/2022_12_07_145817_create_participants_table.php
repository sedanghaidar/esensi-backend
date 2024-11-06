<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable(false);
            $table->string('name')->nullable(false);
            $table->string('nip')->nullable(true);                      //optional tidwak wajib
            $table->string('jabatan');
            $table->string('instansi');
            $table->string('nohp');
            $table->string('signature')->nullable(true);                //path image tanda tangan
            $table->string('qr_code')->nullable(true);                  //kode qr versi string
            $table->integer('scanned_by')->nullable(true);      //user yang scan qr
            $table->dateTime('scanned_at')->nullable(true);     //waktu record scan qr
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
        Schema::dropIfExists('participants');
    }
}
