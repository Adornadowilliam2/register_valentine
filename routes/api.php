<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InvitationController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:api')->get('/checkToken',[AuthController::class,'checkToken']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);

Route::prefix('/invitations')->middleware(['auth:api'])->group(function(){        
    Route::get('/',[InvitationController::class,'index']);
    Route::post('/',[InvitationController::class,'store']);
    Route::patch('/{invitation}',[InvitationController::class,'update']);
    Route::delete('/{invitation}',[InvitationController::class,'destroy']);
});
