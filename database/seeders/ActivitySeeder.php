<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Activity::create([
            'name' => 'Kegiatan ',
            'date' => '2022-12-12',
            'time' => now(),
            'location' => 'Kantor Pusat',
            'created_by' => '1'
        ]);
        Activity::create([
            'name' => 'Kegiatan 2',
            'date' => '2022-12-13',
            'time' => now(),
            'location' => 'Kantor Pusat',
            'created_by' => '1'
        ]);
    }
}
