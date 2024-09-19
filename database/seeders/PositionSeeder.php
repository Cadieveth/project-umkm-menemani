<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            '1' => ['dashboards'],
            '2' =>  [
                'users-list',
                'users-create',
                'users-edit',
                'users-delete'
            ],
            '3' =>  [
                'product-list',
                'product-create',
                'product-edit',
                'product-delete'
            ],
            '4' =>  [
                'order-list',
                'order-create',
                'order-edit',
                'order-delete'
            ],
            '5' =>  [
                'transaksi-list',
                'transaksi-create',
                'transaksi-edit',
                'transaksi-delete'
            ],
        ];

        foreach ($permissions as $permission => $values) {
            foreach ($values as $value) {
                Permission::create(['parent' => $permission, 'name' => $value]);
            }
        }
    }
}