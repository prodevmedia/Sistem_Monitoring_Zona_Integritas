<?php

namespace Database\Seeders;

use App\Models\MasterUnitKerja;
use Illuminate\Database\Seeder;

class MasterUnitKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MasterUnitKerja::truncate();
        MasterUnitKerja::create([
            'name_unit_kerja' => "Manajemen Pelaksana"
        ]);
    }
}
