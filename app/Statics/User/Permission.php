<?php

namespace App\Statics\User;

class Permission
{
    // permissions
    public static $PERMISSION_ACCESS = 6900;
    public static $PERMISSION_CREATE = 6901;
    public static $PERMISSION_EDIT = 6902;

    // roles
    public static $ROLE_ACCESS = 7900;
    public static $ROLE_CREATE = 7901;
    public static $ROLE_EDIT = 7902;

    // menus
    public static $MENU_ACCESS = 8900;
    public static $MENU_CREATE = 8901;
    public static $MENU_EDIT = 8902;
    public static $MENU_DELETE = 8903;

    // users
    public static $USER_RESET_PASSWORD = 9001;
    public static $USER_UNBLOCK = 9002;
    public static $USER_REMOVE_IP = 9003;
    public static $USERS_LAST_SEEN = 9004;
    public static $USERS_LOG_ACTIVITY = 9005;
    public static $USER_ACCESS = 9900;
    public static $USER_SHOW = 9901;
    public static $USER_CREATE = 9902;
    public static $USER_EDIT = 9903;
    public static $USER_DELETE = 9904;
    public static $DECRYPT = 9909;

    // security
    public static $SECURITY = 9999;
}
