<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone',
        'role',
        'first_name',
        'last_name',
        'profile_image',
        'birth_date',
        'id_image',
        'is_approved',
        'password', // We'll still use password for authentication
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'is_approved' => 'boolean',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the user's full name
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Check if user is a tenant
     */
    public function isTenant()
    {
        return $this->role === 'tenant';
    }

    /**
     * Check if user is an owner
     */
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user is an admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is approved
     */
    public function isApproved()
    {
        return $this->is_approved;
    }
}
