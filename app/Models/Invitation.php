<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    //
    protected $fillable = [
        "user_id",
        "to"
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }
}
