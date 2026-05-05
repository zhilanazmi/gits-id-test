<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index(Request $request)
    {
        $query = $request->only(['search', 'page', 'per_page', 'sort_by', 'sort_order']);
        $response = $this->api->get('/publishers', $query);

        if (!$response->successful()) {
            return redirect()->route('dashboard')->with('error', 'Failed to fetch publishers.');
        }

        $publishers = $response->json('data', []);
        $meta = $response->json('meta', ['current_page' => 1, 'per_page' => 15, 'total' => 0, 'last_page' => 1]);

        return view('publishers.index', compact('publishers', 'meta'));
    }

    public function create()
    {
        return view('publishers.form');
    }

    public function store(Request $request)
    {
        $response = $this->api->post('/publishers', $request->only(['name', 'address', 'phone', 'email']));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('publishers.index')->with('success', 'Publisher created successfully.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Failed to create publisher.');

        return back()->withErrors($errors ?: ['error' => $message])->withInput();
    }

    public function edit($id)
    {
        $response = $this->api->get("/publishers/{$id}");

        if (!$response->successful()) {
            return redirect()->route('publishers.index')->with('error', 'Publisher not found.');
        }

        $publisher = $response->json('data');

        return view('publishers.form', compact('publisher'));
    }

    public function update(Request $request, $id)
    {
        $response = $this->api->put("/publishers/{$id}", $request->only(['name', 'address', 'phone', 'email']));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('publishers.index')->with('success', 'Publisher updated successfully.');
        }

        $errors = $response->json('errors', []);
        $message = $response->json('message', 'Failed to update publisher.');

        return back()->withErrors($errors ?: ['error' => $message])->withInput();
    }

    public function destroy($id)
    {
        $response = $this->api->delete("/publishers/{$id}");

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('publishers.index')->with('success', 'Publisher deleted successfully.');
        }

        return redirect()->route('publishers.index')->with('error', 'Failed to delete publisher.');
    }
}
