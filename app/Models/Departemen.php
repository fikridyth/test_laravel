<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;

    protected $table = 'tbl_master_departemen';

    protected $guarded = ['id'];

    function scopeAktif($query)
    {
        return $query->where('status_data', 1);
    }
}
