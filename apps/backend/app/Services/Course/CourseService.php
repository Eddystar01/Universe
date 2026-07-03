<?php

namespace App\Services\Course;

use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    public function index(): Collection
    {
        return Course::query()->latest()->get();
    }

    public function show(string $id): ?Course
    {
        return Course::query()->findOrFail($id);
    }

    public function store(array $data): Course
    {
        return Course::create($data);
    }

    public function update(string $id, array $data): Course
    {
        $course = Course::findOrFail($id);

        $course->update($data);

        return $course->refresh();
    }

    public function destroy(string $id): void
    {
        Course::findOrFail($id)->delete();
    }
}
