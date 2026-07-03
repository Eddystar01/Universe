<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Course
 */
class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'department_id' => $this->department_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'code' => $this->code,
            'level' => $this->level,
            'credit_units' => $this->credit_units,
            'description' => $this->description,
            'is_active' => $this->is_active,
        ];
    }
}
