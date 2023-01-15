<?php

namespace App\Models;

use Dyrynda\Database\Support\NullableFields;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, NullableFields;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $nullable = [
        'ip_address'
    ];

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class, 'id_unit_kerja', 'id');
    }

    public function scopeSearchByName($query, array $filters)
    {
        $query->when($filters['nama'] ?? false, function ($query, $nama) {
            return $query->where('name', 'ILIKE', '%' . $nama . '%');
        });
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['role'] ?? false, function ($query, $role) {
            return $query->whereHas('roles', function (Builder $query) use ($role) {
                $query->where('name', $role);
            });
        })->when($filters['status_blokir'] ?? false, function ($query, $status_blokir) {
            return $query->where('is_blokir', $status_blokir);
        });
    }
}
