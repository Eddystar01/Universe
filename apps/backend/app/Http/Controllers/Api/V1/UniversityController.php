<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\University\StoreUniversityRequest;
use App\Http\Requests\University\UpdateUniversityRequest;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use App\Services\University\UniversityService;
use Illuminate\Http\JsonResponse;

class UniversityController extends Controller
{
    public function __construct(
        protected UniversityService $service
    ) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => UniversityResource::collection(
                $this->service->index()
            ),
        ]);
    }

    public function show(University $university): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => new UniversityResource(
                $this->service->show($university)
            ),
        ]);
    }

    public function store(StoreUniversityRequest $request): JsonResponse
    {
        $university = $this->service->store(
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'University created successfully.',
            'data' => new UniversityResource($university),
        ], 201);
    }

    public function update(
        UpdateUniversityRequest $request,
        University $university
    ): JsonResponse {
        $university = $this->service->update(
            $university,
            $request->validated()
        );

        return response()->json([
            'success' => true,
            'message' => 'University updated successfully.',
            'data' => new UniversityResource($university),
        ]);
    }

    public function destroy(University $university): JsonResponse
    {
        $this->service->destroy($university);

        return response()->json([
            'success' => true,
            'message' => 'University deleted successfully.',
        ]);
    }
}
