<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lecturer\StoreLecturerRequest;
use App\Http\Requests\Lecturer\UpdateLecturerRequest;
use App\Http\Resources\LecturerResource;
use App\Services\Lecturer\LecturerService;
use Illuminate\Http\JsonResponse;

class LecturerController extends Controller
{
    public function __construct(
        private readonly LecturerService $lecturerService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => LecturerResource::collection(
                $this->lecturerService->index()
            ),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new LecturerResource(
                $this->lecturerService->show($id)
            ),
        ]);
    }

    public function store(StoreLecturerRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new LecturerResource(
                $this->lecturerService->store(
                    $request->validated()
                )
            ),
        ], 201);
    }

    public function update(
        UpdateLecturerRequest $request,
        string $id
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'data' => new LecturerResource(
                $this->lecturerService->update(
                    $id,
                    $request->validated()
                )
            ),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->lecturerService->destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Lecturer deleted successfully.',
        ]);
    }
}