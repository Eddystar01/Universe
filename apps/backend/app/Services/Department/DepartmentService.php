<?php

namespace App\Services\Department;

use App\Models\Department;
use Illuminate\Database\Eloquent\Collection;

class DepartmentService
{
    public function index(): Collection
    {
        return Department::query()->latest()->get();
    }

    public function show(string $id): ?Department
    {
        return Department::query()->findOrFail($id);
    }

    public function store(array $data): Department
    {
        return Department::create($data);
    }

    public function update(string $id, array $data): Department
    {
        $department = Department::findOrFail($id);
        $department->update($data);

        return $department->refresh();
    }

    public function destroy(string $id): void
    {
        Department::findOrFail($id)->delete();
    }
}
