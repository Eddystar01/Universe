<?php

namespace App\Http\Requests\AttendanceSession;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceSessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'course_id' => ['required', 'exists:courses,id'],
            'lecturer_id' => ['required', 'exists:lecturers,id'],
            'title' => ['required', 'string', 'max:255'],
            'session_date' => ['required', 'date'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date', 'after:starts_at'],
            'location_latitude' => ['nullable', 'numeric'],
            'location_longitude' => ['nullable', 'numeric'],
            'allowed_radius' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
