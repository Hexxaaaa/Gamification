<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'age',
        'location',
        'total_points',
        'is_admin',
        'provider',
        'provider_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email', 'age', 'location', 'is_admin', 'active', 'total_points'])
            ->useLogName('user')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
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
        return $this->belongsToMany(Badge::class, 'user_badges')->withTimestamps();
    }

    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }
}