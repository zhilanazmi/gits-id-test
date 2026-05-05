<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected ApiService $api;

    public function __construct(ApiService $api)
    {
        $this->api = $api;
    }

    public function showLogin()
    {
        if ($this->api->isAuthenticated()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $response = $this->api->login($request->email, $request->password);

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => $response->json('message', 'Invalid credentials')])->withInput();
    }

    public function showRegister()
    {
        if ($this->api->isAuthenticated()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $response = $this->api->register($request->only('name', 'email', 'password', 'password_confirmation'));

        if ($response->successful() && $response->json('success')) {
            return redirect()->route('dashboard')->with('success', 'Registration successful!');
        }

        $errors = $response->json('errors', []);
        return back()->withErrors($errors)->withInput();
    }

    public function logout()
    {
        $this->api->logout();

        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
