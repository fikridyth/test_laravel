<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    use HasFactory;

    protected $table = 'users_activity_log';

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public static function scopeLogActivityLists($query)
    {
        return $query->latest()->get();
    }

    public function scopeSearchByUser($query, array $filters)
    {
        $query->when($filters['user'] ?? false, function ($query, $user) {
            return $query->where('id_user', $user);
        });
    }

    public function scopeSearchByRole($query, array $filters)
    {
        $query->when($filters['role'] ?? false, function ($query, $role) {
            return $query->with('user', 'user.roles')->whereHas('user.roles', function (Builder $q) use ($role) {
                $q->where('name', $role);
            });
        });
    }
}
