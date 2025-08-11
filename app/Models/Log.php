<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'user_id',
        'log_type_id',
        'title',
        'description',
        'affected_system',
        'changes',
        'event_time'
    ];

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
}
