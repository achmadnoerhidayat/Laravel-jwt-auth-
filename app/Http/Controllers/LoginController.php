<?php

namespace App\Http\Controllers;
use App\Http\Resources\User as userResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request,[
            'username' => 'required', 'password' => 'required'
        ]);
        $credensial = $request->only('username','password');
        if(!$token = auth()->attempt($credensial)){
            return response()->json(['error' => 'invalid_credintial'], 401);
        }
        // return response()->json(compact('user','token'));
        return (new UserResource($request->user()))
        ->additional(['meta' => [
            'token' => $token
        ]]);

    }
}
