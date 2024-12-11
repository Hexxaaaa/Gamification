<?php

namespace App\Models;

use App\Models\Interaction;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Task extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'description',
        'points',
        'status',
        'deadline',
        'video_type',
        'video_url',
        'thumbnail_url',
        'featured',
    ];

    /**
     * Attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = [
        'description',
        'points',
        'status',
        'deadline',
        'video_url',
        'thumbnail_url',
        'featured',
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
    protected static $logName = 'task';

    /**
     * Prevent logging if no attributes have changed.
     *
     * @var bool
     */
    public static $submitEmptyLogs = false;

    // Relationship with UserTask
    public function userTasks()
    {
        return $this->hasMany(UserTask::class);
    }

    // Add the comments relationship
    public function comments()
    {
        return $this->hasMany(Interaction::class)->where('type', 'comment');
    }

    // Existing interactions relationship
    public function interactions()
    {
        return $this->hasMany(Interaction::class);
    }

    // Add this method to check if user liked the task
    public function isLikedByUser($userId)
    {
        return $this->interactions()
            ->where('user_id', $userId)
            ->where('type', 'like')
            ->exists();
    }

    // Add this accessor for likes count
    public function getLikesCountAttribute()
    {
        return $this->interactions()
            ->where('type', 'like')
            ->count();
    }

    public function getCurrentStatus()
    {
        if ($this->status === 'completed') {
            return 'completed';
        }

        if ($this->deadline && Carbon::parse($this->deadline)->isPast()) {
            // Update the status in database
            $this->update(['status' => 'expired']);
            return 'expired';
        }

        return $this->status;
    }

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function ($task) {
            if ($task->deadline && Carbon::parse($task->deadline)->isPast() && $task->status === 'active') {
                $task->status = 'expired';
                $task->save();
            }
        });
    }
}