<?php

namespace App\Services\AttendanceSession;

use App\Models\AttendanceSession;
use Illuminate\Database\Eloquent\Collection;

class AttendanceSessionService
{
    public function getAll(): Collection
    {
        return AttendanceSession::latest()->get();
    }

    public function getById(AttendanceSession $attendanceSession): AttendanceSession
    {
        return $attendanceSession;
    }

    public function create(array $data): AttendanceSession
    {
        return AttendanceSession::create($data);
    }

    public function update(AttendanceSession $attendanceSession, array $data): AttendanceSession
    {
        $attendanceSession->update($data);

        return $attendanceSession->refresh();
    }

    public function delete(AttendanceSession $attendanceSession): void
    {
        $attendanceSession->delete();
    }
}
