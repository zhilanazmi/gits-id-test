<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class ApiService
{
    protected string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.api.base_url', env('API_BASE_URL', 'http://localhost:8000/api'));
    }

    /**
     * Get the JWT token from session.
     */
    protected function getToken(): ?string
    {
        return session('jwt_token');
    }

    /**
     * Make an authenticated GET request.
     */
    public function get(string $endpoint, array $query = []): Response
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->get($this->baseUrl . $endpoint, $query);
    }

    /**
     * Make an authenticated POST request.
     */
    public function post(string $endpoint, array $data = []): Response
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->post($this->baseUrl . $endpoint, $data);
    }

    /**
     * Make an authenticated PUT request.
     */
    public function put(string $endpoint, array $data = []): Response
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->put($this->baseUrl . $endpoint, $data);
    }

    /**
     * Make an authenticated DELETE request.
     */
    public function delete(string $endpoint): Response
    {
        return Http::withToken($this->getToken())
            ->acceptJson()
            ->delete($this->baseUrl . $endpoint);
    }

    /**
     * Login and store token in session.
     */
    public function login(string $email, string $password): Response
    {
        $response = Http::acceptJson()
            ->post($this->baseUrl . '/auth/login', [
                'email' => $email,
                'password' => $password,
            ]);

        if ($response->successful() && $response->json('success')) {
            session(['jwt_token' => $response->json('data.token')]);
            session(['user' => $response->json('data.user')]);
        }

        return $response;
    }

    /**
     * Register a new user.
     */
    public function register(array $data): Response
    {
        $response = Http::acceptJson()
            ->post($this->baseUrl . '/auth/register', $data);

        if ($response->successful() && $response->json('success')) {
            session(['jwt_token' => $response->json('data.token')]);
            session(['user' => $response->json('data.user')]);
        }

        return $response;
    }

    /**
     * Logout and clear session.
     */
    public function logout(): void
    {
        $this->post('/auth/logout');
        session()->forget(['jwt_token', 'user']);
    }

    /**
     * Check if user is authenticated.
     */
    public function isAuthenticated(): bool
    {
        return session()->has('jwt_token');
    }
}
