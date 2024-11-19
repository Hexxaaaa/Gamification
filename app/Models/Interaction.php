<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Interaction extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'user_id',
        'task_id',
        'type',
        'content', // New field for comments
    ];

    /**
     * Attributes that should be logged.
     *
     * @var array
     */
    protected static $logAttributes = [
        'type',
        'content',
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
    protected static $logName = 'interaction';

    /**
     * Prevent logging if no attributes have changed.
     *
     * @var bool
     */
    public static $submitEmptyLogs = false;

    /**
     * Determine if the model should be logged.
     *
     * @return bool
     */
    public function shouldLogActivity(): bool
    {
        return true;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}