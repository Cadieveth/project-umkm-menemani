<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Setting::query()->truncate();
        Setting::create([
            'name' => 'Pabrik Snake',
            'company_name' => 'PT. Snake Ciki',
            'alamat' => 'Jalan Adipatidolken',
            'pimpinan' => 'Ir. Joko Widodo',
        ]);
    }
}