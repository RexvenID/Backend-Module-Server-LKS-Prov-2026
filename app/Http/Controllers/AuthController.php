<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $fields = ['id', 'name', 'email', 'created_at', 'updated_at'];

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create($data);
        return $this->ok('Registration successful', $this->pick($user, $this->fields, [
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]), 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!auth()->attempt($data)) {
            return $this->fail('Username or password incorrect', 401);
        }

        $user = auth()->user();
        return $this->ok('Login successful', $this->pick($user, $this->fields, [
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]));
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->ok('Logout successful');
    }
}
