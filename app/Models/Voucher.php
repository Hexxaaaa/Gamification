<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','code', 'points_required', 'description', 'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'points_required', 'description', 'status'])
            ->useLogName('voucher')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relasi dengan UserVoucher
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }
}