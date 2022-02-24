<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = \App\Models\User::factory()->create();
        \App\Models\Pengaturan::factory()->create();

        $role = Role::create(['name' => 'admin']);
        $permission = Permission::create(['name' => 'all']);

        $role2 = Role::create(['name' => 'kasir']);
        $permission2 = Permission::create(['name' => 'transaksi']);

        $role3 = Role::create(['name' => 'staff_gudang']);
        $permission3 = Permission::create(['name' => 'barang']);

        $role->givePermissionTo($permission);
        $permission->assignRole($role);

        $role2->givePermissionTo($permission2);
        $permission2->assignRole($role2);

        $role3->givePermissionTo($permission3);
        $permission3->assignRole($role3);
        
        $admin->assignRole($role);
    }
}
