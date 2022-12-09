<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_limits', function (Blueprint $table) {
            $table->id();
            $table->integer('activity_id')->nullable(false);
            $table->integer('organization_id')->nullable(false);
            $table->integer('max_participant')->nullable(true);
            $table->integer('created_by')->nullable(false);
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
        Schema::dropIfExists('organization_limits');
    }
}
