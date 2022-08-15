<?php

namespace App\Http\Controllers;

use App\Models\Avatar;
use App\Models\Connection;
use App\Models\Field;
use App\Models\Interest;
use App\Models\Network;
use App\Models\Participant;
use App\Models\Profile;
use App\Models\Room;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index(User $user, Request $request){
        $avatars = $user->avatar->toQuery()->orderBy('id', 'asc')->get();

        $room = null;
        
        $isFriend = $isFollowed = $isFollower = false;

        $follower = $user->follower;
        $following = $user->following;

        if(auth()->user()){
            $isFollower = count($following->where('followed_id', auth()->user()->id));
            $isFollowed = count($follower->where('follower_id', auth()->user()->id));
            $isFriend = ($isFollower && $isFollowed);
        }

        if(count($user->room)){
            $room = $user->room->toQuery()->whereHas('user', fn($query) => $query->where('user_id', auth()->user()->id))->first();
        }
        $connections = Connection::where('user_id_1', $user->id)->orWhere('user_id_2', $user->id)->get();
        
        $networks = Network::where('user_id', '!=', $user->id)->whereHas('connection', fn($query) => $query->where('user_id_1', $user->id)->orWhere('user_id_2', $user->id))->get();

        $field_name = [];

        foreach ($user->field as $value) {
            array_push($field_name, __($value->name));
        }

        if($request['tab']){
            $tab = $request['tab'];
        }
        else{
            $tab = 'collector';
        }

        if(auth()->user()) $me = $user->id == auth()->user()->id;
        else $me = false;

        return view('main.profile', [
            'user' => $user,
            'avatars' => $avatars,
            'connections' => $networks,
            'me' => $me,
            'isFollowed' => $isFollowed,
            'isFollower' => $isFollower,
            'isFriend' => $isFriend,
            'connection' => count($connections),
            'tab' => $tab,
            'room' => $room,
            'fields' => implode(', ', $field_name),
            'page' => 'home',
        ]);
    }

    public function follow(User $user){
        $wishlist = new Wishlist();
        $wishlist->followed_id = $user->id;
        $wishlist->follower_id = auth()->user()->id;
        $wishlist->save();

        $followed = $user->following->where('followed_id', auth()->user()->id);

        if(count($followed)){
            $connection = new Connection();
            $connection->user_id_1 = $user->id;
            $connection->user_id_2 = auth()->user()->id;
            $connection->save();

            $network = new Network();
            $network->user_id = $user->id;
            $network->connection_id = $connection->id;
            $network->save();

            $network = new Network();
            $network->user_id = auth()->user()->id;
            $network->connection_id = $connection->id;
            $network->save();

            $room = new Room();
            $room->save();

            $participant = new Participant();
            $participant->user_id = $user->id;
            $participant->room_id = $room->id;
            $participant->save();

            $participant = new Participant();
            $participant->user_id = auth()->user()->id;
            $participant->room_id = $room->id;
            $participant->save();
        }

        return redirect()->back();
    }

    public function unfollow(User $user){
        $following = auth()->user()->following->where('followed_id', $user->id);
        
        $network = auth()->user()->network;
        
        if(count($network)){
            $network = $network->toQuery()->whereHas('connection', fn($query) => $query->where('user_id_1', $user->id)->orWhere('user_id_2', $user->id))->get();
            
            if(count($network)){
                $connection = $network->first()->connection;
                $connection->delete();

                $room = $user->room->toQuery()->whereHas('user', fn($query) => $query->where('user_id', $user->id))->first();
                $room->delete();
            }
            
            session()->put('current_room', null);
        }

        $following->first()->delete();

        return redirect()->back();
    }

    public function search(Request $request){
        $output = '';

        if($request['tab'] == 'collector'){
            $avatars = User::find($request['id'])->avatar;

            if($request['search']){
                $keyword = $request['search'];
                $avatars = $avatars->toQuery()->where('name', 'LIKE', "%$keyword%")->get();
            }

            $output = '';

            foreach ($avatars as $avatar) {
                $card = $request['me'] ? '<div class="card shadow-sm h-100 bg-dark-secondary border border-white" onclick="avatar('.$avatar->id.')" style="cursor: pointer">' : 
                                            '<div class="card shadow-sm h-100 bg-dark-secondary border border-white">';

                $output .= '
                <div class="col mb-3">
                    '.$card.'
                        <img src="../storage/Assets/Avatar/'.$avatar->image.'" class="card-img-top">
                        <div class="card-body">
                            <h6 class="card-title text-white">'.$avatar->name.'</h6>
                            <div class="d-flex text-warning">
                                <i class="fa-solid fa-coins me-2"></i>
                                <p class="card-text text-warning" style="font-size: 12px">'.$avatar->price.' '.__('COIN').'</p>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }
        else{
            if (count(Network::where('user_id', '!=', $request['id'])->get())) {
                $networks = Network::where('user_id', '!=', $request['id'])->whereHas('connection', fn($query) => $query->where('user_id_1', $request['id'])->orWhere('user_id_2', $request['id']))->get();

                if($request['search']){
                    $keyword = $request['search'];
                    $networks = $networks->toQuery()->whereHas('user', fn($query) => $query->where('name', 'LIKE', "%$keyword%"))->get();
                }

                

                foreach ($networks as $network) {
                    $field_name = [];

                    foreach ($network->field as $value) {
                        array_push($field_name, __($value->name));
                    }

                    $output .= '
                    <div class="col mb-3">
                        <a href="/profile/'.$network->user->slug.'" class="text-decoration-none">
                            <div class="card shadow-sm h-100 bg-dark-secondary border border-white">
                                <img src="../storage/Assets/Avatar/'.$network->user->profile->where('active', true)->first()->avatar->image.'" class="card-img-top">
                                <div class="card-body">
                                    <h6 class="card-title text-white">'.$network->user->name.'</h6>
                                    <p class="card-text text-white-50" style="font-size: 12px">'.implode(", ", $field_name).'</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    ';
                }
            }
        }
            

        if($output == '') $output = '
            <div class="col text-muted ms-3">
                <h3>'.__("No result").'</h3>
            </div>
        ';
        
        return response()->json($output);
    }

    public function show_avatar(Request $request){
        $avatar = Avatar::find($request['avatar']);
        $profile = auth()->user()->profile->where('avatar_id', $avatar->id)->first();

        if($profile->active){
            $alert = [
                'title' => $avatar->name,
                'padding' => '0 2em 2em',
                'showConfirmButton' => false,
                'showCancelButton' => true,
                'cancelButtonText' => '<i class="fa-solid fa-check me-2"></i>'.__("Active"),
                'imageUrl' => '../storage/Assets/Avatar/'.$avatar->image,
            ];
        }
        else if(auth()->user()->visibility){
            $alert = [
                'title' => $avatar->name,
                'padding' => '0 2em 2em',
                'confirmButtonText' => '<i class="fa-solid fa-pen me-2"></i>'.__("Set as active"),
                'imageUrl' => '../storage/Assets/Avatar/'.$avatar->image,
            ];
        }
        else{
            $alert = [
                'title' => $avatar->name,
                'padding' => '0 2em 2em',
                'showConfirmButton' => false,
                'showCancelButton' => true,
                'cancelButtonText' => '<i class="fa-solid fa-eye me-2"></i></i>'.__("Set account to public to set this avatar as active"),
                'imageUrl' => '../storage/Assets/Avatar/'.$avatar->image,
            ];
        }

        return response()->json($alert);
    }

    public function set_avatar(Request $request){
        $old = auth()->user()->profile->where('active', true)->first();
        $old->active = false;

        $new = auth()->user()->profile->where('avatar_id', $request['avatar'])->first();
        $new->active = true;
    
        $new->save();
        $old->save();

        return response()->json([$new, $old]);
    }

    public function top_up(){
        $user = User::find(auth()->user()->id);
        $balance = $user->balance + 100;

        $user->update(['balance' => $balance]);

        return response()->json("Success");
    }

    public function change_visibility(Request $request){
        $user = User::find(auth()->user()->id);
        $balance = $user->balance - $request['price'];

        $visible = $user->visibility;

        if($visible){
            $rand = rand(3, 5);

            $old = $user->profile->where('active', true)->first();
            $old->active = false;
            $old->save();

            $new = new Profile();
            $new->user_id = $user->id;
            $new->avatar_id = $rand;
            $new->active = true;
            $new->save();

            $user->visibility = false;
            $user->save();
        }
        else{
            $old = $user->profile->where('active', true)->first();
            $old->delete();

            $new = $user->profile->toQuery()->latest('updated_at')->first();
            $new->active = true;
            $new->save();

            $user->visibility = true;
            $user->save();
        }

        $user->update(['balance' => $balance]);

        return response()->json($new);
    }

    public function get_register(Request $request){
        $user = $request->session()->get('user');
        $genders = ['Female', 'Male'];
        $fields = Field::all();

        return view('main.register', [
            'genders' => $genders,
            'fields' => $fields,
            'user' => $user,
        ]);
    }

    public function post_register(Request $request){
        // dd($request->chk_job);

        $data = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'gender' => 'required',
            'mobile' => 'required|numeric',
            'chk_job' => 'required|min:3'
        ]);

        $interests = collect($request['chk_job']);

        // foreach ($request['chk_job'] as $job) {
        //     $interests->push($job);
        // }

        $request->session()->put('user', $data);
        $request->session()->put('interests', $interests);
        
        return redirect()->route('payment');
    }

    public function get_payment(Request $request){
        if($request->session()->has('user')){
            $user = $request->session()->get('user');
            $price = $request->session()->get('price');

            // dd($user, $price);
    
            if(empty($user)){
                return redirect()->route('register');
            }
    
            if(empty($price)){
                $price = rand(100000, 125000);
                $request->session()->put('price', $price);
            }
            
            return view('main.payment', [
                'user' => $user,
                'price' => $price,
            ]);
        }
        else{
            return redirect()->route('register');
        }
    }

    public function post_payment(Request $request){
        $price = $request->session()->get('price');

        $data = $request->validate([
            'payment' => 'required|numeric|min:'.$price
        ]);

        $amount = $data['payment'];

        if($amount > $price){
            $alert = [
                'title' => __('Amount Overpaid'),
                'text' => __('Sorry you overpaid ').($amount-$price).__(', would you like to add the overpaid amount to your balance?'),
                'icon' => 'question',
                'showDenyButton' => true,
                'denyButtonText' => __('No'),
                'confirmButtonText' => __('Yes'),
                'reverseButtons' => true,
            ];

            $request->session()->put('balance', $amount-$price);
            return redirect()->back()->with('alert', json_encode($alert));
        }

        $alert = [
            'title' => __('Confirm payment'),
            'text' => __('Proceed to payment process?'),
            'icon' => 'question',
            'showDenyButton' => true,
            'denyButtonText' => __('No'),
            'confirmButtonText' => __('Yes'),
            'reverseButtons' => true,
        ];

        $request->session()->put('balance', $amount-$price);
        return redirect()->back()->with('alert', json_encode($alert));
    }

    public function create_user(Request $request){
        $data = $request->session()->get('user');
        $interests = $request->session()->get('interests');
        $balance = $request->session()->get('balance');

        $default = 'default-'.strtolower($data['gender']).'png';

        $user = new User();
        $user->fill($data);
        $user->name = Str::title($user->name);
        $user->slug = Str::slug($user->name, '-');
        $user->balance = $balance + 100;
        $user->password = bcrypt($user->password);
        $user->save();

        $default = 'default-'.strtolower($user->gender).'.png';

        $profile = new Profile();
        $profile->user_id = $user->id;
        $profile->avatar_id = Avatar::where('image', $default)->first()->id;
        $profile->active = true;
        $profile->save();

        foreach ($interests as $item) {
            $interest = new Interest();
            $interest->user_id = $user->id;
            $interest->field_id = intval($item);
            $interest->save();
        }

        $request->session()->forget('user');
        $request->session()->forget('interests');
        $request->session()->forget('balance');

        return response()->json(url('/login'));
    }

    public function get_login(){
        return redirect()->route('dashboard')->with('message','want-login');
    }

    public function just_login(){
        session()->put('message', 'just-login');
        return response()->json("Success");
    }

    public function done_login(){
        session()->put('message', '');
        return response()->json("Successsss");
    }

    public function post_login(Request $request){
        $data = array();
        $data['email'] = $request['email'];
        $data['password'] = $request['password'];
        $remember_me = json_decode($request['remember_me']);

        if(!auth()->attempt($data, $remember_me)) return response()->json(false);

        return response()->json(true);
    }

    public function logout(Request $request){
        Auth::logout();
        $lang = Config::get('app.locale');
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();

        Session::put('applocale', $lang);
    
        return redirect('/');
    }
}
