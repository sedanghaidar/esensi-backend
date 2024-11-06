<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'username',
            'email' => 'admin@domain.com',
            'name' => 'Anaz',
            'password' => \Hash::make('asdfasdf'),
        ]);
    }
}
