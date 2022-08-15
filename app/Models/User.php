<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function profile(){
        return $this->hasMany(Profile::class);
    }

    public function avatar(){
        return $this->belongsToMany(Avatar::class, 'profiles');
    }

    public function interest(){
        return $this->hasMany(Interest::class);
    }

    public function field(){
        return $this->belongsToMany(Field::class, 'interests');
    }

    public function follower(){
        return $this->hasMany(Wishlist::class, 'followed_id');
    }

    public function following(){
        return $this->hasMany(Wishlist::class, 'follower_id');
    }

    public function network(){
        return $this->hasMany(Network::class);
    }

    public function room(){
        return $this->belongsToMany(Room::class, 'participants');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'gender',
        'mobile',
        'balance',
        'visibility',
        'slug',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
