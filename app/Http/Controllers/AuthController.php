<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed|min:6'
        ]);
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        $token = $user->createToken('myAppToken')->plainTextToken;
        // $response = [
        //     'user' => $user,
        //     'token' => $token
        // ];
        // return response($response, 201);
        $response = [
            'success' => true,
            'message' => 'User Created Successfully',
            'data' => [$user, $token]
        ];
        return response()->json($response, 201);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string|min:6'
        ]);
        $credentials = $request->except('_token');
        $user = User::where('email', $fields['email'])->first();
        if (!auth()->attempt($credentials)) {
            //if (!$user || !Hash::check($fields['password'], $user->password)) {
            // return response([
            //     'message' => 'Bad Login attempt'
            // ], 401);

            //follow convention of rest api
            $response = [
                'error' => true,
                'message' => 'Bad Login Attempt',
                'data' => []
            ];
            return response()->json($response, 401);
        }

        $token = $user->createToken('myAppToken')->plainTextToken;
        //     $response = [
        //         'message' => 'Logged In',
        //         'user' => $user,
        //         'token' => $token
        //     ];
        //     return response($response, 201);
        // }
        $response = [
            'success' => true,
            'message' => 'Logged In',
            'data' => [$user, $token]
        ];
        return response()->json($response, 201);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();
        // return [
        //     'message' => 'Logged Out'
        // ];

        //rest api convention
        $response = [
            'success' => true,
            'message' => 'Logged Out',
            'data' => []
        ];
        return response()->json($response, 200);
    }
}