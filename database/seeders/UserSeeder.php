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
        //
        User::query()->truncate();
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'gender' => '1',
            'password' => bcrypt('123123'),
            'role' => 1,
        ]);

        $gudang = User::create([
            'name' => 'Gudangman',
            'email' => 'gudang@gmail.com',
            'gender' => '1',
            'password' => bcrypt('123123'),
            'role' => 2,
        ]);

        $produksi = User::create([
            'name' => 'Produksi',
            'email' => 'produksi@gmail.com',
            'gender' => '2',
            'password' => bcrypt('123123'),
            'role' => 3,
        ]);

        $admin->assignRole('administrator');
        $gudang->assignRole('gudang');
        $produksi->assignRole('produksi');
    }
}