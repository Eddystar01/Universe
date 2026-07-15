<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Services\Student\StudentService;
use Illuminate\Http\JsonResponse;

class StudentController extends Controller
{
    public function __construct(
        private readonly StudentService $studentService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => StudentResource::collection(
                $this->studentService->index()
            ),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new StudentResource(
                $this->studentService->show($id)
            ),
        ]);
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new StudentResource(
                $this->studentService->store($request->validated())
            ),
        ], 201);
    }

    public function update(UpdateStudentRequest $request, string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new StudentResource(
                $this->studentService->update($id, $request->validated())
            ),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->studentService->destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully.',
        ]);
    }
}
