<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    public function avatar(){
        return $this->belongsTo(Avatar::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
