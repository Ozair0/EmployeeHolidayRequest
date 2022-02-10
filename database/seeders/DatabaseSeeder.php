<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        for ($i=0; $i < 50; $i++) {
            $this->call([
            UserSeeder::class,
        ]);
        }
        // Manager info
        DB::table('users')->insert([
            'name' => 'Ozair',
            'email' =>  'ozairfarahi6@gmail.com',
            'password' => Hash::make('password'),
            'type' => 'mang'
        ]);
    }
}
