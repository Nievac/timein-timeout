<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage permissions']);
        Permission::create(['name' => 'manage roles']);
        Permission::create(['name' => 'access web-bundy']);
        Permission::create(['name' => 'add time corrections']);

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo('manage users');
        $adminRole->givePermissionTo('manage permissions');
        $adminRole->givePermissionTo('manage roles');
        $adminRole->givePermissionTo('access web-bundy');

        $employeeRole = Role::create(['name' => 'employee']);
        $employeeRole->givePermissionTo('access web-bundy');


        // create demo users
        $admin = \App\Models\User::factory()->create([
            'fname' => 'IT',
            'lname' => 'Admin',
            'email' => 'admin@admin.com',
        ]);
        $admin->assignRole($adminRole);


        $employeeUsers = \App\Models\User::factory(10)->create();

        foreach($employeeUsers as $user) {
            $user->assignRole($employeeRole);
        }

    }
}
