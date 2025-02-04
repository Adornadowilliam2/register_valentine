<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
class InvitationController extends Controller
{
    //

    public function createInvitation(Request $request){
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

        $invitation = Invitation::create($validator->validated());
        return response()->json([
            "ok"=>true,
            "message" => "Created successfully",
            "data" => $invitation
        ], 200);
    }
}
