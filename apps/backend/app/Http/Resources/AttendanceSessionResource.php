<?php

namespace App\Http\Resources;

use App\Models\AttendanceSession;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AttendanceSession
 */
class AttendanceSessionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'course_id' => $this->course_id,
            'lecturer_id' => $this->lecturer_id,
            'started_by' => $this->started_by,
            'title' => $this->title,
            'session_date' => $this->session_date,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'attendance_code' => $this->attendance_code,
            'status' => $this->status,
            'location_latitude' => $this->location_latitude,
            'location_longitude' => $this->location_longitude,
            'allowed_radius' => $this->allowed_radius,
            'ended_at' => $this->ended_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
