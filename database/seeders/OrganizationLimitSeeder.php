<?php

namespace Database\Seeders;

use App\Models\OrganizationLimit;
use Illuminate\Database\Seeder;

class OrganizationLimitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrganizationLimit::create([
            'id' => 1,
            'activity_id' => 1,
            'organization_id' => 2,
            'max_participant' => 10,
            'created_by' => 1
        ]);
    }
}
