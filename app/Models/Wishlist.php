<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    public function follower(){
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function followed(){
        return $this->hasMany(Wishlist::class, 'followed_id');
    }
}
