<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $studentId = $this->route('student');

        return [
            'user_id' => ['sometimes', 'exists:users,id'],
            'department_id' => ['sometimes', 'exists:departments,id'],

            'matric_number' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('students', 'matric_number')->ignore($studentId),
            ],

            'level' => ['sometimes', 'string', 'max:10'],
            'phone' => ['nullable', 'string', 'max:20'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }
}
