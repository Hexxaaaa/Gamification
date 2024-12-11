<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'location',
        'total_points',
        'is_admin',
        'active',
        'last_activity',
        'provider',
        'provider_id',
        'phone_number',
        'profile_image',
        'gender',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = [
        'name',
        'email',
        'age',
        'location',
        'is_admin',
        'active',
        'last_activity',
        'total_points',
        'phone_number',
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
    protected static $logName = 'user';

    /**
     * Prevent logging if no attributes have changed.
     *
     * @var bool
     */
    public static $submitEmptyLogs = false;

    // Relationships
    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
                    ->withPivot('status')
                    ->withTimestamps();
    }
    public function userBadges()
    {
        return $this->hasMany(UserBadge::class);
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    public function checkIns()
    {
        return $this->hasMany(DailyCheckIn::class);
    }
    public function currentBadge()
    {
        return $this->badges()
                    ->whereHas('userBadges', function ($query) {
                        $query->where('user_id', $this->id)
                            ->where('status', 'collected');
                    })
                    ->orderBy('level', 'desc')
                    ->first();
    }
    public function collectedBadges()
    {
        return $this->badges()
                    ->wherePivot('status', 'collected')
                    ->orderBy('level', 'asc')
                    ->get();
    }
}