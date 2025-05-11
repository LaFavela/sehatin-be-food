<?php

namespace App\Http\Controllers;

use App\Http\Requests\FoodGetRequest;
use App\Http\Requests\FoodRequest;
use App\Http\Resources\MessageResource;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use Illuminate\Http\JsonResponse;


class FoodController
{
    /**
     * Display a listing of the resource.
     */
    public function index(FoodGetRequest $request): JsonResponse
    {
        try {
            $validatedData = $request->validated();

            $query = Food::query();

            if (isset($validatedData['search'])) {
                $query->where('name', 'like', '%' . $validatedData['search'] . '%');
            }

            $sortBy = $validatedData['sort_by'] ?? 'created_at';
            $sortDirection = $validatedData['sort_direction'] ?? 'desc';

            $query->orderBy($sortBy, $sortDirection);

            if (isset($validatedData['per_page'])) {
                $food = $query->paginate($validatedData['per_page']);
                $food->appends($validatedData);
            } else {
                $food = $query->get();
            }
            if ($food->isEmpty()) {
                return (new MessageResource(null, false, 'Data not found'))->response()->setStatusCode(404);
            }
        } catch (\Exception $e) {
            return (new MessageResource(null, false, 'Failed to get food', $e->getMessage()))->response()->setStatusCode(500);
        }
        return (new MessageResource(FoodResource::collection($food), true, 'Food data found'))->response();
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $food = Food::find($id);
            if (!$food) {
                return (new MessageResource(null, false, 'Data not found'))->response()->setStatusCode(404);
            }
        } catch (\Exception $e) {
            return (new MessageResource(null, false, 'Failed to get food', $e->getMessage()))->response()->setStatusCode(500);
        }
        return (new MessageResource(new FoodResource($food), true, 'Food data found'))->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoodRequest $request): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return (new MessageResource(null, false, 'Validation failed', $request->validator->messages()))->response()->setStatusCode(400);
        }

        try {
            $validated = $request->validated();
            $food = Food::create($validated);
        } catch (\Exception $e) {
            return (new MessageResource(null, false, 'Failed to create food', $e->getMessage()))->response()->setStatusCode(500);
        }
        return (new MessageResource(new FoodResource($food), true, 'Food created successfully'))->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FoodRequest $request, $id): JsonResponse
    {
        if (isset($request->validator) && $request->validator->fails()) {
            return (new MessageResource(null, false, 'Validation failed', $request->validator->messages()))->response()->setStatusCode(400);
        }


        try {
            $food = Food::find($id);
            if (!$food) {
                return (new MessageResource(null, false, 'Data not found'))->response()->setStatusCode(404);
            }
            $validated = $request->validated();
            $food->update($validated);
        } catch (\Exception $e) {
            return (new MessageResource(null, false, 'Failed to update food', $e->getMessage()))->response()->setStatusCode(500);
        }
        return (new MessageResource(new FoodResource($food), true, 'Food updated successfully'))->response();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $food = Food::find($id);
        if (!$food) {
            return (new MessageResource(null, false, 'Data not found'))->response()->setStatusCode(404);
        }

        try {
            $food->delete();
        } catch (\Exception $e) {
            return (new MessageResource(null, false, 'Failed to delete food', $e->getMessage()))->response()->setStatusCode(500);
        }
        return (new MessageResource(new FoodResource($food), true, 'Food deleted successfully'))->response();
    }
}
