<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'phone',
        'role',
        'first_name',
        'last_name',
        'profile_image',
        'birth_date',
        'id_image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'birth_date' => 'date',
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
     * Check if user is pending
     */
    public function isPending()
    {
        return $this->status === "pending";
    }

    /**
     * Check if user is approved
     */
    public function isApproved()
    {
        return $this->status === "approved";
    }

    /**
     * Check if user is rejected
     */
    public function isRejected()
    {
        return $this->status === "rejected";
    }
}
