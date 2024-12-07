<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class DailyCheckIn extends Model
{
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'day_count',
        'last_check_in',
        'points_earned'
    ];

    protected $casts = [
        'last_check_in' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}