<?php

namespace App\Http\Requests\Lecturer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLecturerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $lecturerId = $this->route('id');

        return [
            'department_id' => ['sometimes', 'exists:departments,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('lecturers', 'email')->ignore($lecturerId),
            ],
            'phone' => ['nullable', 'string', 'max:20'],
            'staff_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('lecturers', 'staff_id')->ignore($lecturerId),
            ],
            'rank' => ['required', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
