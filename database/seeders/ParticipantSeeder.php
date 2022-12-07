<?php

namespace Database\Seeders;

use App\Models\Participant;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Participant::create([
            'activity_id' => 1,
            'name' => "Anaz",
            'nip' => null,
            'jabatan' => "ketua kelas",
            'instansi' => "selalu merdeka",
            'nohp' => "08122558899",
        ]);
        Participant::create([
            'activity_id' => 1,
            'name' => "Aji",
            'nip' => null,
            'jabatan' => "wakil ketua kelas",
            'instansi' => "selalu merdeka",
            'nohp' => "082445235534",
        ]);
    }
}
