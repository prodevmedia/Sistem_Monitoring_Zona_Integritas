<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        $faker = Faker::create();
        for ($i=0; $i < 2; $i++) { 
            User::create([
                "name" => $faker->name,
                "email" => $faker->email,
                'role' => "eksekutif",
                'password' => Hash::make(123456)
            ]);
        }
        User::create([
            "name" => "Admin",
            "email" => "admin@test.com",
            'role' => "admin",
            'password' => Hash::make(123456)
        ]);
    }
}
