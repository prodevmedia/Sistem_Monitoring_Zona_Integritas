<?php

namespace Database\Seeders;

use App\Models\MasterUnitKerja;
use App\Models\UserUnitKerja;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserUnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // UnitKerja::truncate();
        $master = MasterUnitKerja::first();
        $faker = Faker::create();
        UserUnitKerja::create([
            "name" => $faker->name,
            "email" => $faker->email,
            'password' => Hash::make(123456),
            'master_unit_kerja_id' => $master->id
        ]);
    }
}
