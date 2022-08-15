<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Chat extends Model
{
    use HasFactory;

    public function isToday(){
        return Carbon::createFromTimestamp(strtotime($this->created_at))->isToday();
    }

    public function isYesterday(){
        return Carbon::createFromTimestamp(strtotime($this->created_at))->isYesterday();
    }

    public function isSameMinute($compare){
        return Carbon::createFromTimestamp(strtotime($this->created_at))->isSameMinute($compare);
    }
}
