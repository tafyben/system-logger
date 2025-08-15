<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Log extends Model
{
    use LogsActivity;
    protected $fillable = [
        'user_id',
        'log_type_id',
        'title',
        'description',
        'affected_system',
        'changes',
        'event_time'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty() // only log changed fields
            ->useLogName('log_changes')
            ->setDescriptionForEvent(function (string $eventName) {
                return "Log entry was {$eventName}";
            });
    }

    protected $casts = [
        'changes' => 'array',
        'event_time' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(LogType::class, 'log_type_id');
    }

    public function getEventTimeAttribute($value)
    {
        return Carbon::parse($value)->format('D d M Y H:i:s');
    }
}
