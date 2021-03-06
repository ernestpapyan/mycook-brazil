<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');

        $email = $request->input('email');
        $user = User::where('email', $email)->with('Seller')->first();

        if (!$user) {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        if ($user->role !== 'admin' and $user->role !== 'vendedor') {
            return response()->json(['error' => 'invalid_credentials'], 401);
        }

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function check()
    {

        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            return response(['authenticated' => false, 'user'=>null]);
        }

        if ($user->role === 'admin') {
            return response(['authenticated' => true, 'user'=>$user]);
        }
        if ($user->role === 'vendedor') {
            return response(['authenticated' => true, 'user'=>$user, 'seller_id'=>$user->seller->id]);
        }

        return response(['authenticated' => false, 'user'=>null]);
    }

    public function logout()
    {

        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }

        } catch (JWTException $e) {
            return response()->json($e->getMessage(), 401);
        }

        return response()->json(['message' => 'Log out success'], 200);
    }
}
