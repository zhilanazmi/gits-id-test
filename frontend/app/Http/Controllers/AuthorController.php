<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $query = $request->only(['search', 'page', 'per_page', 'sort_by', 'sort_order']);
        $response = $this->api->get('/authors', $query);

        if (!$response->successful()) {
            return redirect()->route('dashboard')->with('error', 'Failed to fetch authors.');
        }

        $authors = $response->json('data', []);
        $meta = $response->json('meta', ['current_page' => 1, 'per_page' => 15, 'total' => 0, 'last_page' => 1]);

        return view('authors.index', compact('authors', 'meta'));
    }

    public function create()
    {
        return view('authors.form');
    }

    public function store(Request $request)
    {
        $response = $this->api->post('/authors', $request->only(['name', 'bio', 'birth_date']));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('authors.index')->with('success', 'Author created successfully.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Failed to create author.');

        return back()->withErrors($errors ?: ['error' => $message])->withInput();
    }

    public function edit($id)
    {
        $response = $this->api->get("/authors/{$id}");

        if (!$response->successful()) {
            return redirect()->route('authors.index')->with('error', 'Author not found.');
        }

        $author = $response->json('data');

        return view('authors.form', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->api->put("/authors/{$id}", $request->only(['name', 'bio', 'birth_date']));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Failed to update author.');

        return back()->withErrors($errors ?: ['error' => $message])->withInput();
    }

    public function destroy($id)
    {
        $response = $this->api->delete("/authors/{$id}");

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
        }

        return redirect()->route('authors.index')->with('error', 'Failed to delete author.');
    }
}
