<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;

class StoreLecturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],

            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email', 'max:255', 'unique:lecturers,email'],

            'phone' => ['nullable', 'string', 'max:20'],

            'staff_id' => ['required', 'string', 'max:50', 'unique:lecturers,staff_id'],

            'rank' => ['required', 'string', 'max:255'],

            'bio' => ['nullable', 'string'],

            'is_active' => ['required', 'boolean'],
        ];
    }
}
