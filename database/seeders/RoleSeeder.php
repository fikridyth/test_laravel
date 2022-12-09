<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use App\Statics\User\Role as StaticRole;
use App\Statics\User\Permission as StaticPermission;
use App\Statics\User\Menu as StaticMenu;
use App\Statics\User\NRIK as StaticNRIK;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // create permissions
        $collections = [
            ['id' => StaticPermission::$USER_LIST, 'name' => 'User List'],
            ['id' => StaticPermission::$USER_CREATE, 'name' => 'User Create'],
            ['id' => StaticPermission::$USER_EDIT, 'name' => 'User Edit'],
            ['id' => StaticPermission::$USER_DELETE, 'name' => 'User Delete'],
            ['id' => StaticPermission::$USER_UNBLOCK, 'name' => 'User Unblock'],
            ['id' => StaticPermission::$USER_REMOVE_IP, 'name' => 'User Remove IP'],
            ['id' => StaticPermission::$USER_RESET_PASSWORD, 'name' => 'User Reset Password'],
            ['id' => StaticPermission::$USERS_LAST_SEEN, 'name' => 'Users Last Seen'],
            ['id' => StaticPermission::$USERS_LOG_ACTIVITY, 'name' => 'Users Log Activity'],
            
            ['id' => StaticPermission::$MENU_LIST, 'name' => 'Menu List'],
            ['id' => StaticPermission::$MENU_CREATE, 'name' => 'Menu Create'],
            ['id' => StaticPermission::$MENU_EDIT, 'name' => 'Menu Edit'],
            ['id' => StaticPermission::$MENU_DELETE, 'name' => 'Menu Delete'],
            
            ['id' => StaticPermission::$PERMISSION_LIST, 'name' => 'Permission List'],
            ['id' => StaticPermission::$PERMISSION_CREATE, 'name' => 'Permission Create'],
            ['id' => StaticPermission::$PERMISSION_EDIT, 'name' => 'Permission Edit'],
            ['id' => StaticPermission::$PERMISSION_DELETE, 'name' => 'Permission Delete'],
            
            ['id' => StaticPermission::$ROLE_LIST, 'name' => 'Role List'],
            ['id' => StaticPermission::$ROLE_CREATE, 'name' => 'Role Create'],
            ['id' => StaticPermission::$ROLE_EDIT, 'name' => 'Role Edit'],
            ['id' => StaticPermission::$ROLE_DELETE, 'name' => 'Role Delete'],
            
            ['id' => StaticPermission::$SECURITY, 'name' => 'Security'],
        ];

        collect($collections)->each(function ($data) {
            Permission::create($data);
        });
        
        // create menus
        $collections = [
            ['id' => StaticMenu::$DASHBOARD, 'name' => 'Dashboard', 'route' => 'index', 'icon' => 'fa-dashboard', 'parent_id' => 0, 'order' => 1],
            
            ['id' => StaticMenu::$UTILITY, 'name' => 'Manajemen', 'route' => 'index', 'icon' => 'fa-dashboard', 'parent_id' => 0, 'order' => 4],
            ['id' => StaticMenu::$UTILITY_USER, 'name' => 'Manajemen User', 'route' => 'manajemen-user.index', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$UTILITY, 'order' => 1],
            ['id' => StaticMenu::$UTILITY_MENU, 'name' => 'Manajemen Menu', 'route' => 'v2.menu.index', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$UTILITY, 'order' => 2],
            ['id' => StaticMenu::$UTILITY_ROLE, 'name' => 'Manajemen Role', 'route' => 'v2.role.index', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$UTILITY, 'order' => 3],
            ['id' => StaticMenu::$UTILITY_PERMISSION, 'name' => 'Manajemen Akses', 'route' => 'v2.permission.index', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$UTILITY, 'order' => 4],
            ['id' => StaticMenu::$UTILITY_SECURITY, 'name' => 'Manajemen Keamanan', 'route' => 'manajemen-sekuriti', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$UTILITY, 'order' => 5],
            
            ['id' => StaticMenu::$USERS_ACTIVITY, 'name' => 'Aktivitas User', 'route' => 'index', 'icon' => 'fa-dashboard', 'parent_id' => 0, 'order' => 5],
            ['id' => StaticMenu::$USERS_ACTIVITY_LAST_SEEN, 'name' => 'Users Last Seen', 'route' => 'konfigurasi.last-seen', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$USERS_ACTIVITY, 'order' => 1],
            ['id' => StaticMenu::$USERS_ACTIVITY_LOG_ACTIVITY, 'name' => 'Catatan Aktivitas User', 'route' => 'konfigurasi.log-activity', 'icon' => 'fa-dashboard', 'parent_id' => StaticMenu::$USERS_ACTIVITY, 'order' => 2],
        ];

        collect($collections)->each(function ($data) {
            Menu::create($data);
        });

        // create roles
        $roles = StaticRole::getAllForCreate();
        foreach($roles as $role)
        {
            $roleDb = Role::create(['id' => $role['id'], 'name' => $role['name']]);
            $roleDb->givePermissionTo($role['permissions']);
            $roleDb->menus()->sync($role['menus']);
        }
        
        // assign users to roles
        $user_nriks = StaticNRIK::getAllForCreate();
        foreach($user_nriks as $nrik)
        {   
            $user = \App\Models\User::where('nrik', $nrik['nrik'])->first();
            $user->assignRole($nrik['roles']);
        }
    }
}