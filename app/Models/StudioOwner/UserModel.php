<?php

namespace App\Models\StudioOwner;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserModel extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uuid',
        'role',
        'first_name',
        'middle_name',
        'last_name',
        'user_type',
        'email',
        'mobile_number',
        'password',
        'profile_photo',
        'status',
        'email_verified',
        'verification_token',
        'token_expiry',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
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
            'token_expiry' => 'datetime',
        ];
    }

    /**
     * Get the studios owned by the user.
     */
    public function studios()
    {
        return $this->hasMany(StudiosModel::class, 'user_id');
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Check if user is a studio owner.
     *
     * @return bool
     */
    public function isStudioOwner()
    {
        return $this->role === 'owner';
    }

    /**
     * Get the freelancer profile if user is a freelancer.
     */
    public function freelancerProfile()
    {
        return $this->hasOne(\App\Models\Freelancer\ProfileModel::class, 'user_id');
    }

    /**
     * Get the studio profile if user is a studio owner.
     */
    public function studio()
    {
        return $this->hasOne(\App\Models\StudioOwner\StudiosModel::class, 'user_id');
    }
}