<?php

namespace App\Statics\User;

class Role
{
    public static $SUPER_ADMIN = 1;
    public static $DEVELOPER = 2;
    
    public static function getAll()
    {
        return [
            self::$SUPER_ADMIN,
            self::$DEVELOPER,
        ];
    }
    
    public static function getAllForCreate()
    {
        return [
            [
                'id' => self::$SUPER_ADMIN,
                'name' => 'Super Admin',
                'permissions' => [
                    Permission::$USER_LIST,
                    Permission::$USER_CREATE,
                    Permission::$USER_EDIT,
                    Permission::$USER_DELETE,
                    Permission::$USER_RESET_PASSWORD,
                    Permission::$USER_UNBLOCK,
                    Permission::$USER_REMOVE_IP,
                    Permission::$USERS_LAST_SEEN,
                    Permission::$USERS_LOG_ACTIVITY,
                    
                    Permission::$MENU_LIST,
                    Permission::$MENU_CREATE,
                    Permission::$MENU_EDIT,
                    Permission::$MENU_DELETE,
                    
                    Permission::$ROLE_LIST,
                    Permission::$ROLE_CREATE,
                    Permission::$ROLE_EDIT,
                    Permission::$ROLE_DELETE,
                    
                    Permission::$PERMISSION_LIST,
                    Permission::$PERMISSION_CREATE,
                    Permission::$PERMISSION_EDIT,
                    Permission::$PERMISSION_DELETE,

                    Permission::$SECURITY,
                ],
                'menus' => [
                    Menu::$DASHBOARD,
                    Menu::$UTILITY,
                    Menu::$UTILITY_USER,
                    Menu::$UTILITY_ROLE,
                    Menu::$UTILITY_MENU,
                    Menu::$UTILITY_PERMISSION,
                    Menu::$UTILITY_SECURITY,
                    Menu::$USERS_ACTIVITY,
                    Menu::$USERS_ACTIVITY_LAST_SEEN,
                    Menu::$USERS_ACTIVITY_LOG_ACTIVITY,
                ],
            ],
            [
                'id' => self::$DEVELOPER,
                'name' => 'Developer',
                'permissions' => [
                    Permission::$USER_LIST,
                    Permission::$USER_CREATE,
                    Permission::$USER_EDIT,
                    Permission::$USER_DELETE,
                    Permission::$USER_RESET_PASSWORD,
                    Permission::$USER_UNBLOCK,
                    Permission::$USER_REMOVE_IP,
                    Permission::$USERS_LAST_SEEN,
                    Permission::$USERS_LOG_ACTIVITY,
                    
                    Permission::$MENU_LIST,
                    Permission::$MENU_CREATE,
                    Permission::$MENU_EDIT,
                    Permission::$MENU_DELETE,
                    
                    Permission::$ROLE_LIST,
                    Permission::$ROLE_CREATE,
                    Permission::$ROLE_EDIT,
                    Permission::$ROLE_DELETE,
                    
                    Permission::$PERMISSION_LIST,
                    Permission::$PERMISSION_CREATE,
                    Permission::$PERMISSION_EDIT,
                    Permission::$PERMISSION_DELETE,

                    Permission::$SECURITY,
                ],
                'menus' => [
                    Menu::$DASHBOARD,
                    Menu::$UTILITY,
                    Menu::$UTILITY_USER,
                    Menu::$UTILITY_ROLE,
                    Menu::$UTILITY_MENU,
                    Menu::$UTILITY_PERMISSION,
                    Menu::$UTILITY_SECURITY,
                    Menu::$USERS_ACTIVITY,
                    Menu::$USERS_ACTIVITY_LAST_SEEN,
                    Menu::$USERS_ACTIVITY_LOG_ACTIVITY,
                ],
            ],
        ];
    }
}
