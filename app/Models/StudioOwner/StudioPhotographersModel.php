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
        'specialization', // Now FK to tbl_services.id
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
     * Get the service that is the photographer's specialization.
     */
    public function specializationService()
    {
        return $this->belongsTo(\App\Models\StudioOwner\ServicesModel::class, 'specialization');
    }

    /**
     * Get all services assigned to photographer through pivot.
     */
    public function services()
    {
        return $this->belongsToMany(
            \App\Models\StudioOwner\ServicesModel::class,
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

    /**
     * Get the category through the service.
     */
    public function category()
    {
        // Since specialization now points to tbl_categories.id directly
        return $this->belongsTo(\App\Models\Admin\CategoriesModel::class, 'specialization');
    }

    /**
     * Get the category that is the photographer's specialization.
     */
    public function specializationCategory()
    {
        return $this->belongsTo(\App\Models\Admin\CategoriesModel::class, 'specialization');
    }
}