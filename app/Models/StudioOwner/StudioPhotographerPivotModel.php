<?php

namespace App\Models\StudioOwner;

use Illuminate\Database\Eloquent\Model;

class StudioPhotographerPivotModel extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pvt_studio_photographers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'studio_id',
        'owner_id',
        'photographer_id',
        'services_id',
    ];

    /**
     * Get the service associated.
     */
    public function service()
    {
        return $this->belongsTo(ServicesModel::class, 'services_id');
    }

    /**
     * Get the photographer associated.
     */
    public function photographer()
    {
        return $this->belongsTo(UserModel::class, 'photographer_id');
    }

    /**
     * Get the studio associated.
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
        return $this->belongsTo(UserModel::class, 'owner_id');
    }
}