<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use JWTAuth;
use Exception;
use App\Blog;
class BlogController extends Controller
{
    public function index()
    {
        // try {
        //     JWTAuth::parseToken()->Authenticate();
        // } catch (Exception $e) {
        //     if ($e instanceof Tymon\JWTAuth\Exception\TokenInvalidException) {
        //         return response()->json(['error' => 'Token Invalid'], 401);
        //     }elseif ($e instanceof Tymon\JWTAuth\Exception\TokenExpiredException) {
        //         return response()->json(['error' => 'Token Expired'], 400);
        //     }else {
        //         return response()->json(['error' => 'Token Not Found'], 404);
        //     }
        // }
        return Blog::with('coments')->get();
    }
    public function show(Request $request, $id)
    {
        // try {
        //     JWTAuth::parseToken()->Authenticate();
        // } catch (Exception $e) {
        //     if ($e instanceof Tymon\JWTAuth\Exception\TokenInvalidException) {
        //         return response()->json(['error' => 'Token Invalid'], 401);
        //     }elseif ($e instanceof Tymon\JWTAuth\Exception\TokenExpiredException) {
        //         return response()->json(['error' => 'Token Expired'], 400);
        //     }else {
        //         return response()->json(['error' => 'Token Not Found'], 404);
        //     }
        // }
        $blog = Blog::with('coments')->where('id',$id)->first();
        if ($blog) {
            return response()->json([
                'status'=> 'true',
                'blogs' => $blog
            ]);
        }else {
            return response()->json(['error' => 'oops data tidak di temukan'],403);
        }
    }
    public function edit(Request $request, $id)
    {
        JWTAuth::parseToken()->Authenticate();
        $this->validate($request,[
            'title' => 'required',
            'body' => 'required'
        ]);
        $blog = Blog::find($id);
        if ($request->user()->id != $blog->user_id) {
            return response()->json(['error' => 'tidak boleh komen punya orang']);
        }
        $blog->title = $request->json('title');
        $blog->slug = Str::slug($request->json('title'));
        $blog->body = $request->json('body');
        $blog->save();
        return response()->json([ 'status' => 'true','blogs' => $blog]);
    }
    public function store(Request $request)
    {
        try {
           $blog = JWTAuth::parseToken()->Authenticate();
        } catch (Exception $e) {
            if ($e instanceof Tymon\JWTAuth\Exception\TokenInvalidException) {
                return response()->json(['error' => 'token invalid'],403);
            } elseif ($e instanceof Tymon\JWTAuth\Exception\TokenExpiredException) {
                return response()->json(['error' => 'Token expired'],400);
            }else {
                return response()->json(['error' => 'Token Not Found'],404);
            }
        }
        $this->validate($request,[
            'title' => 'required',
            'body'  => 'required|min:6'
        ]);

        $blog = $request->user()->blogs()->create([
            'title' => $request->json('title'),
            'slug' => Str::slug($request->json('title')),
            'body' => $request->json('body')
        ]);
        return response()->json([
            'status' => 'berhasil',
            'blogs' => $blog
        ]);
    }
}
