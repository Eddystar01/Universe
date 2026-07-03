<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\StoreDepartmentRequest;
use App\Http\Requests\Department\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentResource;
use App\Services\Department\DepartmentService;
use Illuminate\Http\JsonResponse;

class DepartmentController extends Controller
{
    public function __construct(
        private readonly DepartmentService $departmentService,
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => DepartmentResource::collection(
                $this->departmentService->index()
            ),
        ]);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new DepartmentResource(
                $this->departmentService->show($id)
            ),
        ]);
    }

    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new DepartmentResource(
                $this->departmentService->store($request->validated())
            ),
        ], 201);
    }

    public function update(UpdateDepartmentRequest $request, string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new DepartmentResource(
                $this->departmentService->update($id, $request->validated())
            ),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->departmentService->destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.',
        ]);
    }
}
