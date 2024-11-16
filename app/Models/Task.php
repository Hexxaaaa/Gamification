<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'points',
        'status',
        'deadline',
        'video_url', // New field for video link
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['description', 'points', 'status', 'deadline', 'video_url'])
            ->useLogName('task')
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // Relasi dengan UserTask
    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }
}