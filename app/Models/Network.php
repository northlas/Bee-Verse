<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Network extends Model
{
    use HasFactory;

    public function connection(){
        return $this->belongsTo(Connection::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
