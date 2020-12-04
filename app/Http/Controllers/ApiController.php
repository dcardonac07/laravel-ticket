<?php

namespace App\Http\Controllers;

use App\Models\User;
use JWTAuth;

class ApiController extends Controller
{
    /**
     * Simulate a successful login
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::first();
        return response()->json([
            'success' => true,
            'token' => JWTAuth::fromUser($user),
        ]);
    }
}
