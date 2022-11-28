<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MenuHasRole extends Pivot
{
    protected $table = 'menu_has_roles';
    public $incrementing = true;

    protected $guarded = ['id'];
}
