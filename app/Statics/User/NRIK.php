<?php

namespace App\Statics\User;

class NRIK
{
    public static $SUPER_ADMIN = '00000000';
    public static $DEVELOPER = '99999999';
    public static $ADI = '99999998';
    public static $RENDY = '26011214';
    public static $KUSDHIAN = '28451215';
    public static $FIQQI = '42101120';
    public static $KAUTSAR = '46050522';
    public static $WILDAN = '47071022';

    public static function getAllForCreate()
    {
        return [
            [
                'nrik' => self::$SUPER_ADMIN,
                'roles' => [Role::$SUPER_ADMIN,],
            ],
            [
                'nrik' => self::$DEVELOPER,
                'roles' => [Role::$DEVELOPER, Role::$SUPER_ADMIN],
            ],
            [
                'nrik' => self::$ADI,
                'roles' => [Role::$DEVELOPER,],
            ],
            [
                'nrik' => self::$RENDY,
                'roles' => [Role::$DEVELOPER,],
            ],
            [
                'nrik' => self::$KUSDHIAN,
                'roles' => [Role::$DEVELOPER,],
            ],
            [
                'nrik' => self::$FIQQI,
                'roles' => [Role::$DEVELOPER,],
            ],
            [
                'nrik' => self::$KAUTSAR,
                'roles' => [Role::$DEVELOPER,],
            ],
            [
                'nrik' => self::$WILDAN,
                'roles' => [Role::$DEVELOPER,],
            ],

        ];
    }
}
