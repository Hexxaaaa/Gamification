<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'points_required',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'points_required', 'description'])
            ->useLogName('badge')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function users()
{
    return $this->belongsToMany(User::class, 'user_badges')->withTimestamps();
}
}