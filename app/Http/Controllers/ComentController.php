<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coment;
use JWTAuth;
class ComentController extends Controller
{
    public function index()
    {

    }
    public function create(Request $request,$id)
    {
        JWTAuth::parseToken()->Authenticate();
        $this->validate($request,[
            'body' => 'required'
        ]);
        $coment = $request->user()->coments()->create([
            'body' => $request->json('body'),
            'blog_id' => $id
        ]);
        return response()->json(['status' => 'true','coments' => $coment]);
    }
}
