<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    function signUp(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'first_name' => 'required',
            'mobile' => 'required|min:10',
            'email' => 'required|unique:users|max:65',
            'password' => 'required|min:6|max:25',
            'conf_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validation fails",
                "errors" => $validator->errors()
                ], 201
            );
        }

        $user = new User();
        $user->first_name = $req->input('first_name');
        $user->last_name = $req->input('last_name');
        $user->mobile = $req->input('mobile');
        $user->email = $req->input('email');
        $user->password = Hash::make($req->input('password'));
        $user->save();

        return response()->json([
            "message" => "Sign up successfull",
            "data" => $user
            ], 200
        );
    }

    function getUsers()
    {
        return User::all();
    }

    function getUser()
    {
        $users = DB::table('users')
            ->select('first_name', 'last_name', 'email AS username')
            ->get();

        return $users;
    }
}
