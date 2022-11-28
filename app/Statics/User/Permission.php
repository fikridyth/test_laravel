<?php

namespace App\Statics\User;

class Permission
{
    // permissions
    public static $PERMISSION_LIST = 6000;
    public static $PERMISSION_CREATE = 6001;
    public static $PERMISSION_EDIT = 6002;
    public static $PERMISSION_DELETE = 6003;
    
    // roles
    public static $ROLE_LIST = 7000;
    public static $ROLE_CREATE = 7001;
    public static $ROLE_EDIT = 7002;
    public static $ROLE_DELETE = 7003;
    
    // menus
    public static $MENU_LIST = 8000;
    public static $MENU_CREATE = 8001;
    public static $MENU_EDIT = 8002;
    public static $MENU_DELETE = 8003;
    
    // users
    public static $USER_LIST = 9000;
    public static $USER_CREATE = 9001;
    public static $USER_EDIT = 9002;
    public static $USER_DELETE = 9003;
    public static $USER_RESET_PASSWORD = 9004;
    public static $USER_UNBLOCK = 9005;
    public static $USER_REMOVE_IP = 9006;
    public static $USERS_LAST_SEEN = 9007;
    public static $USERS_LOG_ACTIVITY = 9008;
    
    // security
    public static $SECURITY = 9999;
}
