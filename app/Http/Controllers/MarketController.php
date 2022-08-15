<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Connection;
use App\Models\Field;
use App\Models\Network;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarketController extends Controller
{
    public function index(Request $request){
        $avatars = Avatar::where('price', '>', 0)->get();
        
        return view('main.market', [
            'avatars' => $avatars,
            'page' => 'market',
        ]);
    }

    public function search(Request $request){
        $avatars = Avatar::where('price', '>', 0)->get();

        if($request['search']){
            $keyword = $request['search'];
            $avatars = $avatars->toQuery()->where('name', 'LIKE', "%$keyword%")->get();
        }

        $output = '';

        foreach ($avatars as $avatar) {
            $card = '<div class="card shadow-sm h-100 bg-dark-secondary border border-white" onclick="avatar('.$avatar->id.','.$avatar->price.')" style="cursor: pointer">';

            $output .= '
                <div class="col mb-3">
                    '.$card.'
                        <img src="../storage/Assets/Avatar/'.$avatar->image.'" class="card-img-top">
                        <div class="card-body">
                            <h6 class="card-title text-white">'.$avatar->name.'</h6>
                            <div class="d-flex text-warning">
                                <i class="fa-solid fa-coins me-2"></i>
                                <p class="card-text text-warning" style="font-size: 12px">'.$avatar->price.' COIN</p>
                            </div>
                        </div>
                    </div>
                </div>
            ';
        }

        if($output == '') $output = '
            <div class="col text-muted ms-3">
                <h3>'.__("No result").'</h3>
            </div>
        ';
        
        return response()->json($output);
    }

    public function offer_avatar(Request $request){
        $avatar = Avatar::find($request['avatar']);
        $hasAvatar = count(auth()->user()->profile->where('avatar_id', $request['avatar']));

        if($hasAvatar){
            $alert = [
                'title' => $avatar->name,
                'html' => '<div class="text-warning"><i class="fa-solid fa-coins me-2"></i>'.$avatar->price.'</div',
                'padding' => '0 2em 2em',
                'confirmButtonText' => '<i class="fa-solid fa-gift me-2"></i>'.__("Send as gift"),
                'showCancelButton' => true,
                'cancelButtonText' => __('Purchased'),
                'imageUrl' => '../storage/Assets/Avatar/'.$avatar->image,
            ];
        }
        else{
            $alert = [
                'title' => $avatar->name,
                'html' => '<div class="text-warning"><i class="fa-solid fa-coins me-2"></i>'.$avatar->price.'</div',
                'padding' => '0 2em 2em',
                'showDenyButton' => true,
                'confirmButtonText' => '<i class="fa-solid fa-cart-shopping me-2"></i>'.__("Purchase"),
                'denyButtonText' => '<i class="fa-solid fa-gift me-2"></i>'.__("Send as gift"),
                'reverseButtons' => true,
                'imageUrl' => '../storage/Assets/Avatar/'.$avatar->image,
            ];
        }
            
        return response()->json(['hasAvatar' => $hasAvatar, 'alert' => $alert]);
    }

    public function buy_avatar(Request $request){
        $avatar = Avatar::find($request['avatar']);
        $user = User::find(auth()->user()->id);

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->avatar_id = $request['avatar'];
        $profile->save();

        $balance = $user->balance - $avatar->price;

        User::find(auth()->user()->id)->update(['balance' => $balance]);

        return response()->json("Success");
    }

    public function select_connection(){
        $user = auth()->user();
  
        $networks = Network::where('user_id', '!=', $user->id)->whereHas('connection', fn($query) => $query->where('user_id_1', $user->id)->orWhere('user_id_2', $user->id))->get();

        $select = array();

        foreach ($networks as $network) {
            $select[$network->user->id] = $network->user->name;
        }

        if(count($select)) return response()->json($select);
        else abort(402);   
    }

    public function check_avatar(Request $request){
        $user = User::find($request['id']);
        $hasAvatar = count($user->profile->where('avatar_id', $request['avatar']));
            
        return response()->json(['hasAvatar' => $hasAvatar, 'user' => $user->name]);
    }

    public function send_avatar(Request $request){
        $avatar = Avatar::find($request['avatar']);
        $user = User::find($request['id']);
        $me = User::find(auth()->user()->id);

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->avatar_id = $request['avatar'];
        $profile->save();

        $balance = $me->balance - $avatar->price;

        $me->update(['balance' => $balance]);

        return response()->json(['user' => $user->name, 'avatar' => $avatar->name]);
    }
}
