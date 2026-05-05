<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublisherController extends Controller
{
    /**
     * Display a listing of publishers.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Publisher::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['name', 'created_at'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $publishers = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Publishers retrieved successfully',
            'data' => $publishers->items(),
            'meta' => [
                'current_page' => $publishers->currentPage(),
                'per_page' => $publishers->perPage(),
                'total' => $publishers->total(),
                'last_page' => $publishers->lastPage(),
            ],
        ]);
    }

    /**
     * Store a newly created publisher.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $publisher = Publisher::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Publisher created successfully',
            'data' => $publisher,
        ], 201);
    }

    /**
     * Display the specified publisher.
     */
    public function show(Publisher $publisher): JsonResponse
    {
        $publisher->load('books');

        return response()->json([
            'success' => true,
            'message' => 'Publisher retrieved successfully',
            'data' => $publisher,
        ]);
    }

    /**
     * Update the specified publisher.
     */
    public function update(Request $request, Publisher $publisher): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $publisher->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Publisher updated successfully',
            'data' => $publisher,
        ]);
    }

    /**
     * Remove the specified publisher.
     */
    public function destroy(Publisher $publisher): JsonResponse
    {
        $publisher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Publisher deleted successfully',
        ]);
    }
}
