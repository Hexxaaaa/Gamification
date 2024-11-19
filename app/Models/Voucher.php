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
}