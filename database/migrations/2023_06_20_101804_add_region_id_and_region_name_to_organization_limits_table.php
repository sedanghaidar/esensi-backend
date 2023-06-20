<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegionIdAndRegionNameToOrganizationLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('organization_limits', function (Blueprint $table) {
            $table->integer('region_id')->after('organization_id')->nullable();
            $table->string('region_name')->after('region_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('organization_limits', function (Blueprint $table) {
            //
        });
    }
}
