<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model {
    protected $fillable = ['user_id', 'date', 'start_time', 'end_time', 'slot_duration_minutes'];
    protected $casts = ['date' => 'date', 'start_time' => 'datetime:H:i', 'end_time' => 'datetime:H:i'];
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
