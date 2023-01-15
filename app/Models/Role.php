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

    protected $fillable = ['id', 'name'];

    protected $guard_name = 'web';

    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'menu_role')->using(MenuHasRole::class);
    }
}
