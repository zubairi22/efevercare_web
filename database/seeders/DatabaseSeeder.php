<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            ['id' => 1, 'name' => 'view dashboard', 'guard_name' => 'web'],
            ['id' => 2, 'name' => 'view user', 'guard_name' => 'web'],
            ['id' => 3, 'name' => 'create user', 'guard_name' => 'web'],
            ['id' => 4, 'name' => 'update user', 'guard_name' => 'web'],
            ['id' => 5, 'name' => 'delete user', 'guard_name' => 'web'],
            ['id' => 6, 'name' => 'view menu', 'guard_name' => 'web'],
            ['id' => 7, 'name' => 'create menu', 'guard_name' => 'web'],
            ['id' => 8, 'name' => 'update menu', 'guard_name' => 'web'],
            ['id' => 9, 'name' => 'delete menu', 'guard_name' => 'web'],
            ['id' => 10, 'name' => 'view role', 'guard_name' => 'web'],
            ['id' => 11, 'name' => 'create role', 'guard_name' => 'web'],
            ['id' => 12, 'name' => 'update role', 'guard_name' => 'web'],
            ['id' => 13, 'name' => 'delete role', 'guard_name' => 'web'],
        ];

        Permission::insert($permissions);
        $permissions = Permission::all();

        $role = Role::create(['name' => 'Super-Admin']);
        $role->syncPermissions($permissions);

        $admin = User::factory()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
        ]);
        $admin->assignRole($role);

        $role = Role::create(['name' => 'User']);
        $role->syncPermissions(Permission::findById(1));

        $menus = [
            ['id' => 1, 'title' => 'Dashboard', 'url' => 'dashboard', 'parent_id' => null, 'icon' => 'ChartBarIcon', 'sort' => 1],
            ['id' => 2, 'title' => 'Master', 'url' => 'master', 'parent_id' => null, 'icon' => 'ComputerDesktopIcon', 'sort' => 10],
            ['id' => 3, 'title' => 'Users', 'url' => 'master.users.index', 'parent_id' => 2, 'icon' => 'UserIcon', 'sort' => 1],
            ['id' => 4, 'title' => 'Menus', 'url' => 'master.menus.index', 'parent_id' => 2, 'icon' => 'Bars4Icon', 'sort' => 2],
            ['id' => 5, 'title' => 'Roles', 'url' => 'master.roles.index', 'parent_id' => 2, 'icon' => 'UsersIcon', 'sort' => 3],
        ];

        Menu::insert($menus);

        $menuPermissions = [
            ['id' => 1, 'menu_id' => 1, 'permission_id' => 1],
            ['id' => 2, 'menu_id' => 2, 'permission_id' => 2],
            ['id' => 3, 'menu_id' => 2, 'permission_id' => 6],
            ['id' => 4, 'menu_id' => 2, 'permission_id' => 10],
            ['id' => 5, 'menu_id' => 3, 'permission_id' => 2],
            ['id' => 6, 'menu_id' => 3, 'permission_id' => 3],
            ['id' => 7, 'menu_id' => 3, 'permission_id' => 4],
            ['id' => 8, 'menu_id' => 3, 'permission_id' => 5],
            ['id' => 9, 'menu_id' => 4, 'permission_id' => 6],
            ['id' => 10, 'menu_id' => 4, 'permission_id' => 7],
            ['id' => 11, 'menu_id' => 4, 'permission_id' => 8],
            ['id' => 12, 'menu_id' => 4, 'permission_id' => 9],
            ['id' => 13, 'menu_id' => 5, 'permission_id' => 10],
            ['id' => 14, 'menu_id' => 5, 'permission_id' => 11],
            ['id' => 15, 'menu_id' => 5, 'permission_id' => 12],
            ['id' => 16, 'menu_id' => 5, 'permission_id' => 13],
        ];

        DB::table('menu_has_permissions')->insert($menuPermissions);
    }
}
