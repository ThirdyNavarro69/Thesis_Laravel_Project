<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemRevenueModel extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_system_revenue';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'transaction_reference',
        'booking_id',
        'payment_id',
        'total_amount',
        'platform_fee_percentage',
        'platform_fee_amount',
        'provider_amount',
        'provider_type',
        'provider_id',
        'client_id',
        'status',
        'breakdown',
        'settled_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_amount' => 'decimal:2',
        'platform_fee_percentage' => 'decimal:2',
        'platform_fee_amount' => 'decimal:2',
        'provider_amount' => 'decimal:2',
        'breakdown' => 'array',
        'settled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the booking associated with the revenue.
     */
    public function booking()
    {
        return $this->belongsTo(BookingModel::class, 'booking_id');
    }

    /**
     * Get the payment associated with the revenue.
     */
    public function payment()
    {
        return $this->belongsTo(PaymentModel::class, 'payment_id');
    }

    /**
     * Get the client who made the booking.
     */
    public function client()
    {
        return $this->belongsTo(UserModel::class, 'client_id');
    }

    /**
     * Get the provider (studio or freelancer).
     */
    public function provider()
    {
        if ($this->provider_type === 'studio') {
            return $this->belongsTo(\App\Models\StudioOwner\StudiosModel::class, 'provider_id');
        } else {
            return $this->belongsTo(\App\Models\Freelancer\ProfileModel::class, 'provider_id', 'user_id');
        }
    }

    /**
     * Generate a unique transaction reference.
     */
    public static function generateTransactionReference()
    {
        do {
            $reference = 'REV-' . strtoupper(uniqid());
        } while (self::where('transaction_reference', $reference)->exists());

        return $reference;
    }

    /**
     * Calculate revenue split for a given amount.
     */
    public static function calculateRevenueSplit($amount, $feePercentage = 10.00)
    {
        $platformFee = ($amount * $feePercentage) / 100;
        $providerAmount = $amount - $platformFee;
        
        return [
            'total_amount' => $amount,
            'platform_fee_percentage' => $feePercentage,
            'platform_fee_amount' => round($platformFee, 2),
            'provider_amount' => round($providerAmount, 2),
        ];
    }

    /**
     * Check if revenue is completed.
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Mark revenue as settled.
     */
    public function markAsSettled()
    {
        $this->update([
            'status' => 'completed',
            'settled_at' => now(),
        ]);
    }

    /**
     * Mark revenue as refunded.
     */
    public function markAsRefunded()
    {
        $this->update([
            'status' => 'refunded',
        ]);
    }

    /**
     * Get formatted status with badge class.
     */
    public function getStatusBadgeClass()
    {
        $classes = [
            'pending' => 'badge-soft-warning',
            'completed' => 'badge-soft-success',
            'refunded' => 'badge-soft-danger',
            'cancelled' => 'badge-soft-secondary',
        ];
        
        return $classes[$this->status] ?? 'badge-soft-secondary';
    }
}