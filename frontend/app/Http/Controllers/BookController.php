<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $query = $request->only(['search', 'author_id', 'publisher_id', 'page', 'per_page', 'sort_by', 'sort_order']);
        $response = $this->api->get('/books', array_filter($query));

        if (!$response->successful()) {
            return redirect()->route('dashboard')->with('error', 'Failed to fetch books.');
        }

        $books = $response->json('data', []);
        $meta = $response->json('meta', ['current_page' => 1, 'per_page' => 15, 'total' => 0, 'last_page' => 1]);

        // Get authors and publishers for filter dropdowns
        $authorsResponse = $this->api->get('/authors', ['per_page' => 100]);
        $publishersResponse = $this->api->get('/publishers', ['per_page' => 100]);

        $authors = $authorsResponse->successful() ? $authorsResponse->json('data', []) : [];
        $publishers = $publishersResponse->successful() ? $publishersResponse->json('data', []) : [];

        return view('books.index', compact('books', 'meta', 'authors', 'publishers'));
    }

    public function create()
    {
        $authorsResponse = $this->api->get('/authors', ['per_page' => 100]);
        $publishersResponse = $this->api->get('/publishers', ['per_page' => 100]);

        $authors = $authorsResponse->successful() ? $authorsResponse->json('data', []) : [];
        $publishers = $publishersResponse->successful() ? $publishersResponse->json('data', []) : [];

        return view('books.form', compact('authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $data = $request->only(['title', 'author_id', 'publisher_id', 'isbn', 'description', 'published_at', 'pages']);
        $response = $this->api->post('/books', array_filter($data, fn($v) => $v !== null && $v !== ''));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('books.index')->with('success', 'Book created successfully.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Failed to create book.');

        return back()->withErrors($errors ?: ['error' => $message])->withInput();
    }

    public function edit($id)
    {
        $response = $this->api->get("/books/{$id}");

        if (!$response->successful()) {
            return redirect()->route('books.index')->with('error', 'Book not found.');
        }

        $book = $response->json('data');

        $authorsResponse = $this->api->get('/authors', ['per_page' => 100]);
        $publishersResponse = $this->api->get('/publishers', ['per_page' => 100]);

        $authors = $authorsResponse->successful() ? $authorsResponse->json('data', []) : [];
        $publishers = $publishersResponse->successful() ? $publishersResponse->json('data', []) : [];

        return view('books.form', compact('book', 'authors', 'publishers'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only(['title', 'author_id', 'publisher_id', 'isbn', 'description', 'published_at', 'pages']);
        $response = $this->api->put("/books/{$id}", $data);

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('books.index')->with('success', 'Book updated successfully.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Failed to update book.');

        return back()->withErrors($errors ?: ['error' => $message])->withInput();
    }

    public function destroy($id)
    {
        $response = $this->api->delete("/books/{$id}");

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
        }

        return redirect()->route('books.index')->with('error', 'Failed to delete book.');
    }
}
