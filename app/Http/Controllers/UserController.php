<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (Auth::attempt($credentials)) {
            return response([
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('apptoken')->plainTextToken
            ]);
        } else {
            return response(['message' => 'Wrong credentials!'], 401);
        }
    }
    public function register(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|min:2|string',
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|min:6'
        ]);
        $attributes['password'] = Hash::make($request->password);
        $user = User::create($attributes);
        $token = $user->createToken('apptoken')->plainTextToken;
        return response([
            'user' => $user,
            'token' => $token
        ], 201);
    }

    public function update(Request $request)
    {
        $userId = Auth::user()->id;

        $attributes = $request->validate([
            'name' => 'sometimes|min:2|string',
            'email' => ['sometimes', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'sometimes|min:6'
        ]);

        if ($request->password ?? false) {
            $attributes['password'] = Hash::make($request->password);
        }

        $user = User::find($userId);
        $user->update($attributes);
        return response(['message' => 'User updated!']);
    }
    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return response(['message' => 'Logged out!']);
    }
}
