<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'tbl_master_submenu';

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['status'] ?? false, function ($query, $status) {
            return $query->where('status_data', $status);
        })->when($filters['menu'] ?? false, function ($query, $menu) {
            return $query->where('id_menu', $menu);
        });
    }
}
