<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MenuRole extends Pivot
{
    protected $table = 'menu_role';

    public $incrementing = true;

    protected $guarded = ['id'];
}
