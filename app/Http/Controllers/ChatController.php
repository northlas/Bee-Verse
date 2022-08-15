<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Field;
use App\Models\Participant;
use App\Models\Profile;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ChatController extends Controller
{
    public function index(){
        $rooms = auth()->user()->room;
        $room = null;
        $days = collect();
        $chats = collect();
        $receiver = null;

        

        if(session()->get('current_room')){
            $room = Room::find(session()->get('current_room'));
            $receiver = $room->user->where('id', '!=', auth()->user()->id)->first();

            if (count($room->chat)) {
                $chats = $room->chat->toQuery()->orderBy('created_at')->get()->reverse()->values();

                $days = $room->chat->toQuery()->orderBy('created_at')->get()->groupBy(function($item){
                    return $item->created_at->format('d');
                })->reverse()->values();
            }
        }

        return view('main.chat', [
            'rooms' => $rooms,
            'room' => $room,
            'receiver' => $receiver,
            'days' => $days,
            'chats' => $chats,
            'page' => 'chat',
        ]);
    }

    public function show_chat(Request $request){
        session()->put('current_room', $request['room']);

        return response()->json("Success");
    }

    public function open_chat(){
        if(count(auth()->user()->room)) session()->put('current_room', auth()->user()->room->first()->id);
        else session()->put('current_room', null);

        return $this->index();
    }

    public function send_chat(Request $request){
        $chat = new Chat();
        $chat->user_id = $request['user'];
        $chat->room_id = $request['room'];
        $chat->text = $request['chat'];
        $chat->save();

        return response()->json("Success");
    }
}
