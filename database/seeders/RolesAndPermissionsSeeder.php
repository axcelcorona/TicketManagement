<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view_any_ticket',
            'view_ticket',
            'create_ticket',
            'update_ticket',
            'restore_ticket',
            'restore_any_ticket',
            'replicate_ticket',
            'reorder_ticket',
            'delete_ticket',
            'delete_any_ticket',
            'force_delete_ticket',
            'force_delete_any_ticket',
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'restore_user',
            'restore_any_user',
            'replicate_user',
            'reorder_user',
            'delete_user',
            'delete_any_user',
            'force_delete_user',
            'force_delete_any_user',
            'view_any_role',
            'view_role',
            'create_role',
            'update_role',
            'delete_role',
            'delete_any_role',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $superAdmin = Role::findOrCreate('super_admin', 'web');
        $panelUser = Role::findOrCreate('panel_user', 'web');

        $superAdmin->givePermissionTo(Permission::all());
        $panelUser->syncPermissions([
            'view_any_ticket',
            'view_ticket',
            'create_ticket',
            'update_ticket',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
