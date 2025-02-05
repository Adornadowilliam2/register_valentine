<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
class InvitationController extends Controller
{
    //

    public function store(Request $request){
        $validator =  validator($request->all(),[
            "user_id" => "required|exists:users,id",
            "to" => "required|unique:invitations,to"
        ]);
        if($validator->fails()){
            return response()->json([
                "ok"=>false,
                "message" => "Request didn't pass validation!",
                "errors" => $validator->errors()
            ], 400);
        }

        $invitation = Invitation::create($validator->validated());
        return response()->json([
            "ok"=>true,
            "message" => "Created successfully",
            "data" => $invitation
        ], 201);
    }

    public function index(){
        $invitation = Invitation::with(['users'])->get();
        return response()->json([
            'ok' => true,
            'message' => 'Retrieved Successfully',
            'data' => $invitation
        ], 200);
    }

    public function update(Request $request, Invitation $invitation){
        $validator =  validator($request->all(),[
            "user_id" => "required|exists:invitations,user_id",
            "to" => "required"
        ]);
        if($validator->validated()){
            return response()->json([
                "ok"=>false,
                "message" => "Request didn't pass validation!",
                "errors" => $validator->errors()
            ], 400);
        }
        $invitation->update($validator->validated());
        return response()->json([
            "ok"=>true,
            "message" => "Updated successfully",
            "data" => $invitation
        ], 200);
        
    }

    public function destroy(Request $request, Invitation $invitation){
        return response()->json([
            "ok"=>true,
            "message" => "Deleted successfully",
            "data" => $invitation->delete()
        ], 200);
    }
}
