<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'menus';
    public $incrementing = false;

    protected $guarded = ['id'];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'menu_has_roles')->using(MenuHasRole::class);
    }

    public function scopeFilterByRoles($query, $parent_id = 0, array $roles = [])
    {
        $query->where('parent_id', $parent_id)
            ->whereHas('roles', function(Builder $query) use ($roles){
                $query->whereIn('roles.id', $roles);
            })
            ->orderBy('order');
    }
}
