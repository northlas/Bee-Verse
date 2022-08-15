<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsToMany(User::class, 'participants');
    }

    public function chat(){
        return $this->hasMany(Chat::class);
    }
}
