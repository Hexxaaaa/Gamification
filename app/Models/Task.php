<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\Interaction;

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
}