<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Organization::create([
            'id' => 2,
            'name' => 'SEKRETARIAT BADAN PENANGGULANGAN BENCANA DAERAH',
            'short_name' => 'BPBD'
        ]);
    }
}
