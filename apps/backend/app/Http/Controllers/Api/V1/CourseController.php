<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Services\Course\CourseService;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    public function __construct(
        private readonly CourseService $courseService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => CourseResource::collection(
                $this->courseService->index()
            ),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new CourseResource(
                $this->courseService->show($id)
            ),
        ]);
    }

    public function store(StoreCourseRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new CourseResource(
                $this->courseService->store($request->validated())
            ),
        ], 201);
    }

    public function update(UpdateCourseRequest $request, string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new CourseResource(
                $this->courseService->update($id, $request->validated())
            ),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->courseService->destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully.',
        ]);
    }
}
