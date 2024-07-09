<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions for manage staffs
        Permission::firstOrCreate(['name' => 'create.staffs']);
        Permission::firstOrCreate(['name' => 'read.staffs']);
        Permission::firstOrCreate(['name' => 'update.staffs']);
        Permission::firstOrCreate(['name' => 'delete.staffs']);

        // create permissions for manage tasks
        Permission::firstOrCreate(['name' => 'create.tasks']);
        Permission::firstOrCreate(['name' => 'read.tasks']);
        Permission::firstOrCreate(['name' => 'update.tasks']);
        Permission::firstOrCreate(['name' => 'delete.tasks']);

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $staffRole->givePermissionTo([
            'read.tasks',
            'update.tasks',
        ]);

        // Create default admin
        $admin = User::updateOrCreate([
            'name' => 'Administrator',
            'phone' => '0123456789',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'user_type' => User::TYPE_ADMIN,
        ]);
        $admin->assignRole($adminRole);
    }
}
