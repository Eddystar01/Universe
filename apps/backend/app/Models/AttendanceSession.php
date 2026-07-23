<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceSession extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'course_id',
        'lecturer_id',
        'started_by',
        'title',
        'session_date',
        'starts_at',
        'ends_at',
        'attendance_code',
        'status',
        'location_latitude',
        'location_longitude',
        'allowed_radius',
        'ended_at',
    ];

    protected function casts(): array
    {
        return [
            'session_date' => 'date',
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'ended_at' => 'datetime',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function lecturer(): BelongsTo
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function starter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'started_by');
    }
}
