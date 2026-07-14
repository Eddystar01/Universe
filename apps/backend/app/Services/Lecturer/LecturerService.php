<?php

namespace App\Services\Lecturer;

use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Collection;

class LecturerService
{
    public function index(): Collection
    {
        return Lecturer::query()
            ->latest()
            ->get();
    }

    public function show(string $id): Lecturer
    {
        return Lecturer::query()
            ->findOrFail($id);
    }

    public function store(array $data): Lecturer
    {
        return Lecturer::query()
            ->create($data);
    }

    public function update(string $id, array $data): Lecturer
    {
        $lecturer = Lecturer::query()->findOrFail($id);

        $lecturer->update($data);

        return $lecturer->fresh();
    }

    public function destroy(string $id): void
    {
        Lecturer::query()
            ->findOrFail($id)
            ->delete();
    }
}