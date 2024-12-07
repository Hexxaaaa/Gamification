<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Badge extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name', 'description', 'points_required', 'level', 'status',
    ];

    protected static $logAttributes = [
        'name', 'description', 'points_required', 'level', 'status',
    ];

    protected static $logOnlyDirty = true;

    protected static $logName = 'badge';

    public static $submitEmptyLogs = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')->withTimestamps();
    }
}