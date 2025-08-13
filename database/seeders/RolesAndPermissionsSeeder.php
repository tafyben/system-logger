<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache to avoid duplication issues
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions
        Permission::create(['name' => 'view logs']);
        Permission::create(['name' => 'create logs']);
        Permission::create(['name' => 'edit logs']);
        Permission::create(['name' => 'delete logs']);

        // Roles
        $admin = Role::create(['name' => 'Admin']);
        $technician = Role::create(['name' => 'Technician']);
        $auditor = Role::create(['name' => 'Auditor']);
        $viewer = Role::create(['name' => 'Viewer']);

        // Assign permissions to roles
        $admin->givePermissionTo(Permission::all());

        $technician->givePermissionTo(['view logs', 'create logs', 'edit logs', 'delete logs']);

        $auditor->givePermissionTo(['view logs']);

        $viewer->givePermissionTo(['view logs']);
    }
}
