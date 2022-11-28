<?php

namespace App\Models;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use HasFactory;

    protected $table = 'roles';
    public $incrementing = false;
    
    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_has_roles')->using(MenuHasRole::class);
    }
}
