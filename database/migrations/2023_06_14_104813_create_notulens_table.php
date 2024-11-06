<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotulensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notulens', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable(false)->unique('activity_id');
            $table->string('image1')->nullable(false);
            $table->string('image2')->nullable(true);
            $table->string('image3')->nullable(true);
            $table->string('nosurat')->nullable(false);
            $table->string('jabatan')->nullable(false);
            $table->string('nama')->nullable(false);
            $table->string('pangkat')->nullable(false);
            $table->string('nip')->nullable(false);
            $table->text('hasil')->nullable(false);
            $table->integer('created_by');
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
        Schema::dropIfExists('notulens');
    }
}
