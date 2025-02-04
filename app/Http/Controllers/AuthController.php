<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
class AuthController extends Controller
{
    //
    public function register(Request $reuqest){
        $validator = validator($reuqest->all(),[
            "username" => "required",
            "email"=>"required|unique:users,email",
            "password" => "required|confirmed|max:9",
            "role" => "sometimes|in:user,guest"
        ]);
        if($validator->fails()){
            return response()->json([
                "ok"=>false,
                "message" => "Request didn't pass validation!",
                "errors" => $validator->errors()
            ], 400);
        }
        $user = User::created($validator->validated());
        $user->token = $user->createToken("api-token")->accessToken;
        return response()->json([
            "ok"=>true,
            "message" => "Register sucessfully!",
            "data" => $user
        ], 201);
    }


    public function checkToken(Request $reuqest){
        return response()->json([
            "ok"=>true,
            "message" => "Retrieve successfully",
            "data" => $reuqest->user()
        ], 200);
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json([
            "ok"=>true,
            "message" => "Logout Sucessfully!"
        ], 200);
    }

    public function login(Request $request){
        $validator = validator($request->all(),[
            "username" => "required",
            "password" => "required"
        ]);
        if($validator->fails()){
            return response()->json([
                "ok"=>false,
                "message" => "Request didn't pass validation!",
                "errors" => $validator->errors()
            ], 400);
        }

        if(auth()->attempt($validator->validated())){
            $user = auth()->token();
            $user->token = $user->createToken("api-token")->accessToken;
            return response()->json([
                "ok"=>true,
                "message" => "Login Sucessfully!",
                "data" => $user
            ], 200);
        }
        return response()->json([
            "ok"=>false,
            "message" => "Request didn't pass validation!",
            "errors" => $validator->errors()
        ], 400);
    }
}
