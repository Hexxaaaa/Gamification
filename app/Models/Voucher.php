<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Voucher extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'code',
        'points_required',
        'description',
        'status',
        'background_color',
        'image',
        'user_limit',
        'expiration_date',
    ];

    /**
     * Attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = [
        'code',
        'points_required',
        'description',
        'status',
    ];

    /**
     * Only log the changed attributes.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * Name of the log.
     *
     * @var string
     */
    protected static $logName = 'voucher';

    /**
     * Prevent logging if no attributes have changed.
     *
     * @var bool
     */
    public static $submitEmptyLogs = false;

    // Relationships
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function isAvailable()
    {
        // Check if the user limit is reached and if the voucher is expired
        if ($this->userVouchers()->count() >= $this->user_limit) {
            return false; // No more users can redeem
        }

        if ($this->status == 'expired' || $this->expiration_date < now()->toDateString()) {
            return false; // Voucher is expired
        }

        return true;
    }

    public function getCurrentStatus()
    {
        if ($this->status === 'inactive') {
            return 'inactive';
        }
        
        if ($this->expiration_date && $this->expiration_date < now()) {
            return 'expired';
        }

        return 'active';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::retrieved(function ($voucher) {
            if ($voucher->expiration_date && $voucher->expiration_date < now() && $voucher->status === 'active') {
                $voucher->status = 'expired';
                $voucher->save();
            }
        });
    }
    public function isRedeemableBy(User $user)
    {
        // Check if user has already redeemed this voucher
        if ($this->userVouchers()->where('user_id', $user->id)->exists()) {
            return false;
        }
    
        // Check if user has enough points
        if ($user->total_points < $this->points_required) {
            return false;
        }
    
        // Check if voucher has reached limit
        if ($this->user_limit && $this->userVouchers()->count() >= $this->user_limit) {
            return false;
        }
    
        // Check if voucher is expired
        if ($this->expiration_date && $this->expiration_date < now()) {
            return false;
        }
    
        // Check if voucher is active
        if ($this->status !== 'active') {
            return false;
        }
    
        return true;
    }
    
}