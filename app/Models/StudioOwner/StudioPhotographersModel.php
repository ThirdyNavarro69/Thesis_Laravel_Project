<?php

namespace App\Models\StudioOwner;

use Illuminate\Database\Eloquent\Model;

class StudioPhotographersModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_studio_photographers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studio_id',
        'owner_id',
        'photographer_id',
        'position',
        'specialization',
        'years_of_experience',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the studio associated with the photographer.
     */
    public function studio()
    {
        return $this->belongsTo(StudiosModel::class, 'studio_id');
    }

    /**
     * Get the owner who added the photographer.
     */
    public function owner()
    {
        return $this->belongsTo(\App\Models\StudioOwner\UserModel::class, 'owner_id');
    }

    /**
     * Get the photographer user details.
     */
    public function photographer()
    {
        return $this->belongsTo(\App\Models\StudioOwner\UserModel::class, 'photographer_id');
    }

    /**
     * Get the services through pivot table.
     */
    public function services()
    {
        return $this->belongsToMany(
            ServicesModel::class,
            'pvt_studio_photographers',
            'photographer_id',
            'services_id'
        )->withTimestamps();
    }

    /**
     * Get the pivot records.
     */
    public function photographerServices()
    {
        return $this->hasMany(StudioPhotographerPivotModel::class, 'photographer_id', 'photographer_id');
    }

    /**
     * Check if photographer is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->status === 'active';
    }
}