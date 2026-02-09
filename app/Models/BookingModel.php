<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingModel extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_bookings';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_reference',
        'client_id',
        'booking_type',
        'provider_id',
        'category_id',
        'event_name',
        'event_date',
        'start_time',
        'end_time',
        'location_type',
        'venue_name',
        'street',
        'barangay',
        'city',
        'province',
        'special_requests',
        'total_amount',
        'down_payment',
        'remaining_balance',
        'deposit_policy',
        'payment_type',
        'status',
        'payment_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',
        'total_amount' => 'decimal:2',
        'down_payment' => 'decimal:2',
        'remaining_balance' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the client who made the booking.
     */
    public function client()
    {
        return $this->belongsTo(UserModel::class, 'client_id');
    }

    /**
     * Get the studio for studio bookings.
     */
    public function studio()
    {
        if ($this->booking_type === 'studio') {
            return $this->belongsTo(\App\Models\StudioOwner\StudiosModel::class, 'provider_id');
        }
        return null;
    }

    /**
     * Get the freelancer for freelancer bookings.
     */
    public function freelancer()
    {
        if ($this->booking_type === 'freelancer') {
            return $this->belongsTo(\App\Models\Freelancer\ProfileModel::class, 'provider_id', 'user_id');
        }
        return null;
    }

    /**
     * Get the category for the booking.
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Admin\CategoriesModel::class, 'category_id');
    }

    /**
     * Get the packages for this booking.
     */
    public function packages()
    {
        return $this->hasMany(BookingPackageModel::class, 'booking_id');
    }

    /**
     * Get the payments for this booking.
     */
    public function payments()
    {
        return $this->hasMany(PaymentModel::class, 'booking_id');
    }

    /**
     * Get assigned photographers for this booking.
     */
    public function assignedPhotographers()
    {
        return $this->hasMany(\App\Models\StudioOwner\BookingAssignedPhotographerModel::class, 'booking_id');
    }

    /**
     * Get the provider based on booking type.
     */
    public function provider()
    {
        if ($this->booking_type === 'studio') {
            return $this->studio();
        } elseif ($this->booking_type === 'freelancer') {
            return $this->freelancer();
        }
        return null;
    }

    /**
     * Generate a unique booking reference.
     */
    public static function generateBookingReference()
    {
        do {
            $reference = 'BK-' . strtoupper(uniqid());
        } while (self::where('booking_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Check if booking is confirmed.
     */
    public function isConfirmed()
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if booking is paid.
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Check if booking is partially paid.
     */
    public function isPartiallyPaid()
    {
        return $this->payment_status === 'partially_paid';
    }

    /**
     * Check if payment type is full payment.
     */
    public function isFullPayment()
    {
        return $this->payment_type === 'full_payment';
    }

    /**
     * Get booking status badge class.
     */
    public function getStatusBadgeClass()
    {
        $classes = [
            'pending' => 'badge-soft-warning',
            'confirmed' => 'badge-soft-success',
            'in_progress' => 'badge-soft-info',
            'completed' => 'badge-soft-secondary',
            'cancelled' => 'badge-soft-danger'
        ];
        
        return $classes[$this->status] ?? 'badge-soft-secondary';
    }

    /**
     * Get payment status badge class.
     */
    public function getPaymentStatusBadgeClass()
    {
        $classes = [
            'pending' => 'badge-soft-warning',
            'partially_paid' => 'badge-soft-info',
            'paid' => 'badge-soft-success',
            'failed' => 'badge-soft-danger',
            'refunded' => 'badge-soft-secondary'
        ];
        
        return $classes[$this->payment_status] ?? 'badge-soft-secondary';
    }
}