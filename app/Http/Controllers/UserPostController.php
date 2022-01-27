<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\UserPost;

class UserPostController extends Controller
{
    function addPost(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'user_id' => 'required',
            'post'    => 'required|min:2'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation fails",
                "errors" => $validator->errors()
                ], 201
            );
        }

        $post = new UserPost();
        $post->user_id = $req->input('user_id');
        $post->post = $req->input('post');
        $post->save();

        return response()->json([
            "message" => "Post added successfull",
            "data" => $post
            ], 200
        );
    }

    function getPosts()
    {
        $posts = DB::table('user_posts')
            ->join('users', 'user_posts.user_id', '=', 'users.id')
            ->select('user_posts.*', 'users.first_name', 'users.last_name')           
            ->get();
        
        if($posts)
        {
            return response()->json([
                "posts" => $posts
                ], 200
            );
        }
        else
        {
            return response()->json([
                "message" => "Post not found",  
                ], 404
            );
        }
    }

    function getPostById($id)
    {
        $post = DB::table('user_posts')
            ->join('users', 'user_posts.user_id', '=', 'users.id')
            ->select('user_posts.*', 'users.first_name', 'users.last_name')
            ->where('user_posts.id', '=', $id)
            ->get();

        if($post)
        {
            return response()->json([
                "post" => $post
                ], 200
            );
        }
        else{
            return response()->json([
                "message" => "Post not found",                    
                ], 404
            );
        }
    }
}
