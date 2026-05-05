<?php

namespace App\Http\Controllers;

use App\Services\ApiService;

class DashboardController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function index()
    {
        // Get stats
        $authorsResponse = $this->api->get('/authors', ['per_page' => 1]);
        $booksResponse = $this->api->get('/books', ['per_page' => 5, 'sort_by' => 'created_at', 'sort_order' => 'desc']);
        $publishersResponse = $this->api->get('/publishers', ['per_page' => 1]);

        $stats = [
            'authors' => $authorsResponse->successful() ? $authorsResponse->json('meta.total', 0) : 0,
            'books' => $booksResponse->successful() ? $booksResponse->json('meta.total', 0) : 0,
            'publishers' => $publishersResponse->successful() ? $publishersResponse->json('meta.total', 0) : 0,
            'users' => 0,
        ];

        $recentBooks = $booksResponse->successful() ? $booksResponse->json('data', []) : [];

        return view('dashboard.index', compact('stats', 'recentBooks'));
    }
}
