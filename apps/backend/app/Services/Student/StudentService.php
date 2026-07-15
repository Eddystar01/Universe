<?php

namespace App\Services\Student;

use App\Models\Student;
use Illuminate\Database\Eloquent\Collection;

class StudentService
{
    public function index(): Collection
    {
        return Student::query()
            ->latest()
            ->get();
    }

    public function show(string $id): Student
    {
        return Student::query()
            ->findOrFail($id);
    }

    public function store(array $data): Student
    {
        return Student::create($data);
    }

    public function update(string $id, array $data): Student
    {
        $student = Student::query()->findOrFail($id);

        $student->update($data);

        return $student->fresh();
    }

    public function destroy(string $id): void
    {
        $student = Student::query()->findOrFail($id);

        $student->delete();
    }
}
