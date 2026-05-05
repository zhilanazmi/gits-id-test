<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of authors.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Author::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['name', 'created_at', 'birth_date'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $authors = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Authors retrieved successfully',
            'data' => $authors->items(),
            'meta' => [
                'current_page' => $authors->currentPage(),
                'per_page' => $authors->perPage(),
                'total' => $authors->total(),
                'last_page' => $authors->lastPage(),
            ],
        ]);
    }

    /**
     * Store a newly created author.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'birth_date' => 'nullable|date|before:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $author = Author::create($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Author created successfully',
            'data' => $author,
        ], 201);
    }

    /**
     * Display the specified author.
     */
    public function show(Author $author): JsonResponse
    {
        $author->load('books');

        return response()->json([
            'success' => true,
            'message' => 'Author retrieved successfully',
            'data' => $author,
        ]);
    }

    /**
     * Update the specified author.
     */
    public function update(Request $request, Author $author): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:2000',
            'birth_date' => 'nullable|date|before:today',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $author->update($validator->validated());

        return response()->json([
            'success' => true,
            'message' => 'Author updated successfully',
            'data' => $author,
        ]);
    }

    /**
     * Remove the specified author.
     */
    public function destroy(Author $author): JsonResponse
    {
        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Author deleted successfully',
        ]);
    }
}
