<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function signIn(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($request->remember_me)
        {
            $myTTL = 60 * 24 * 30 * 12;
            JWTAuth::factory()->setTTL($myTTL);
        }
        else
        {
            $myTTL = 30;
            JWTAuth::factory()->setTTL($myTTL);
        }

        try 
        {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid credentials'], 400);
            }
        } catch (JWTException $e) 
        {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json([
            'token' => $token,
            'type' => 'Bearer',
            'expire' => $myTTL.' Minutes'
        ],200);
    }

    public function getAllUser()
    {
        $user = User::all();
        return response()->json([
            'data' => $user
        ]);
    }
}
