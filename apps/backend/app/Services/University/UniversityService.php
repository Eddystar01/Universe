<?php

namespace App\Services\University;

use App\Models\University;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class UniversityService
{
    public function index(): Collection
    {
        return University::query()
            ->latest()
            ->get();
    }

    public function show(University $university): University
    {
        return $university;
    }

    public function store(array $data): University
    {
        $data['slug'] = Str::slug($data['name']);

        return University::create($data);
    }

    public function update(University $university, array $data): University
    {
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $university->update($data);

        return $university->refresh();
    }

    public function destroy(University $university): void
    {
        $university->delete();
    }
}
