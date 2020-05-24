<?php

namespace App\Http\Controllers;
use App\Http\Resources\User as userResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTAuth;

class UserController extends Controller
{
    public function index()
    {
        // return User::all();
        return JWTAuth::parseToken()->Authenticate();
    }
    public function create(Request $request)
    {
        $this->validate($request,[
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);
        $user = User::create([
            'username' => $request->json('username'),
            'email' => $request->json('email'),
            'password' => bcrypt($request->json('password'))
        ]);
        $credintial = $request->only('username','password');
        $token = auth()->attempt($credintial);
        return (new userResource($request->user()))
        ->additional(['meta' => [
            'token' => $token
        ]]);
    }
}
