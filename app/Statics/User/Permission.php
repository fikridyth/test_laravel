<?php

namespace App\Statics\User;

class Permission
{
    // permissions
    public static $PERMISSION_LIST = 6900;
    public static $PERMISSION_CREATE = 6901;
    public static $PERMISSION_EDIT = 6902;
    public static $PERMISSION_DELETE = 6903;
    
    // roles
    public static $ROLE_LIST = 7900;
    public static $ROLE_CREATE = 7901;
    public static $ROLE_EDIT = 7902;
    public static $ROLE_DELETE = 7903;
    
    // menus
    public static $MENU_LIST = 8900;
    public static $MENU_CREATE = 8901;
    public static $MENU_EDIT = 8902;
    public static $MENU_DELETE = 8903;
    
    // users
    public static $USER_RESET_PASSWORD = 9001;
    public static $USER_UNBLOCK = 9002;
    public static $USER_REMOVE_IP = 9003;
    public static $USERS_LAST_SEEN = 9004;
    public static $USERS_LOG_ACTIVITY = 9005;
    public static $USER_LIST = 9900;
    public static $USER_CREATE = 9901;
    public static $USER_EDIT = 9902;
    public static $USER_DELETE = 9903;
    
    // security
    public static $SECURITY = 9999;
}
