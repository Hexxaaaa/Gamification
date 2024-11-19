<?php

namespace App\Models;

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
}