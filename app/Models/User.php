<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
    ];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_enbaled' => 'boolean',
            'permissions' => AsArrayObject::class,
        ];
    }

    /**
     * Get the discussion mappings for the user.
     */
    public function discussionMappings(): HasMany
    {
        return $this->hasMany(DiscussionMapping::class);
    }

    protected function fullName(): Attribute
    {
        return new Attribute(
            get: fn (mixed $value, array $attributes) => "{$attributes['first_name']} {$attributes['last_name']}"
        );
    }

    public function uploadLogs(): HasMany
    {
        return $this->hasMany(UploadLog::class);
    }

    public function scopeExceptSuperAdmin(Builder $query): void
    {
        $query->where('username', '!=', config('app.super_user.username'));
    }
}
