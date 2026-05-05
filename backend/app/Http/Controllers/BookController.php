<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of books.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Book::with(['author', 'publisher']);

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter by author_id
        if ($request->has('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        // Filter by publisher_id
        if ($request->has('publisher_id')) {
            $query->where('publisher_id', $request->publisher_id);
        }

        // Filter by published_at range
        if ($request->has('published_from')) {
            $query->where('published_at', '>=', $request->published_from);
        }
        if ($request->has('published_to')) {
            $query->where('published_at', '<=', $request->published_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $allowedSorts = ['title', 'published_at', 'created_at'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'asc' ? 'asc' : 'desc');
        }

        // Pagination
        $perPage = min($request->get('per_page', 15), 100);
        $books = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Books retrieved successfully',
            'data' => $books->items(),
            'meta' => [
                'current_page' => $books->currentPage(),
                'per_page' => $books->perPage(),
                'total' => $books->total(),
                'last_page' => $books->lastPage(),
            ],
        ]);
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'isbn' => 'required|string|unique:books,isbn',
            'description' => 'nullable|string|max:5000',
            'published_at' => 'nullable|date',
            'pages' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $book = Book::create($validator->validated());
        $book->load(['author', 'publisher']);

        return response()->json([
            'success' => true,
            'message' => 'Book created successfully',
            'data' => $book,
        ], 201);
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): JsonResponse
    {
        $book->load(['author', 'publisher']);

        return response()->json([
            'success' => true,
            'message' => 'Book retrieved successfully',
            'data' => $book,
        ]);
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'isbn' => 'required|string|unique:books,isbn,' . $book->id,
            'description' => 'nullable|string|max:5000',
            'published_at' => 'nullable|date',
            'pages' => 'nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $book->update($validator->validated());
        $book->load(['author', 'publisher']);

        return response()->json([
            'success' => true,
            'message' => 'Book updated successfully',
            'data' => $book,
        ]);
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book): JsonResponse
    {
        $book->delete();

        return response()->json([
            'success' => true,
            'message' => 'Book deleted successfully',
        ]);
    }
}
