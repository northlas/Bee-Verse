@extends('template.master')
@section('title', 'Bee Verse')

@section('navbar')
    @include('template.navbar')
@endsection

@section('content')
    {{-- {{dd($room->id)}} --}}
    <div class="d-flex h-100" style="min-height: 94vh; max-height: 94vh;">
        @include('template.sidebar')
        <div class="py-3 px-5 w-100 d-flex">
            <div class="bg-dark-third w-25 rounded-3 me-3 d-flex flex-column">
                <div class="border-bottom text-white d-flex align-items-center ps-3" style="height: 10%">
                    <h4 class="m-0">{{__("Messaging")}}</h4>
                </div>
                <div class="d-flex flex-column align-items-center">
                    @foreach ($rooms as $value)
                        {{-- {{dd($value->chat->toQuery()->orderBy('created_at')->get()->last()->text)}} --}}
                        <div class="{{$value->id == session()->get('current_room') ? 'bg-light' : ''}} ps-3" style="--bs-bg-opacity: 0.1; cursor:pointer;" onclick="show_chat({{$value->id}})">
                            <div class="card my-2 border-0 bg-transparent text-white">
                                <div class="row g-0">
                                    <div class="col-lg-2 d-flex align-items-center">
                                        <div>
                                            <img src="./storage/Assets/Avatar/{{$value->user->where('id', '!=', auth()->user()->id)->first()->profile->where('active', true)->first()->avatar->image}}" class="img-fluid rounded-circle">
                                        </div>
                                    </div>
                                    <div class="col-lg-10 d-flex align-items-center">
                                        <div class="card-body">
                                            <h5 class="card-title">{{$value->user->where('id', '!=', auth()->user()->id)->first()->name}}</h5>
                                            @if (count($value->chat))
                                                <div class="text-muted">
                                                    {{Str::limit($value->chat->toQuery()->orderBy('created_at')->get()->last()->text, 30, '...')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="bg-dark-third w-75 rounded-3 d-flex flex-column">
                @if ($room)
                    <div class="border-bottom text-white d-flex align-items-center ps-3" style="height: 10%">
                        <h4 class="m-0">{{$room->user->where('id', '!=', auth()->user()->id)->first()->name}}</h4>
                    </div>
                @endif
                <div class="p-2" style="height: 80%">
                    <div class="d-flex flex-column-reverse p-3" style="min-height:100%; max-height: 100%; overflow-y:auto">
                        @foreach ($days as $item)
                            @foreach ($item->reverse()->values() as $chat)
                                @if ($chat->user_id == auth()->user()->id)
                                        @if (!$loop->last)
                                            @if ($item->reverse()->values()[$loop->iteration]->user_id == auth()->user()->id)
                                                <div class="d-flex justify-content-end w-100 mt-2">
                                            @else
                                                <div class="d-flex justify-content-end w-100 mt-4">
                                            @endif
                                        @else
                                            <div class="d-flex justify-content-end w-100 mt-4">
                                        @endif
                                        <div class="d-flex align-items-center justify-content-end" style="max-width: 60%">
                                        @if (!$loop->first)
                                            <div class="align-self-end">
                                                @if (!$chat->isSameMinute($item->reverse()->values()[$loop->index-1]->created_at) || $item->reverse()->values()[$loop->index-1]->user_id != $chat->user_id)
                                                    <div class="fs-6 text-muted">{{date_format($chat->created_at, "H:i")}}</div>
                                                @else
                                                    <div class=""></div>
                                                @endif
                                            </div>
                                        @else
                                            <div class="align-self-end">
                                                <div class="fs-6 text-muted">{{date_format($chat->created_at, "H:i")}}</div>
                                            </div>
                                        @endif
                                        <div class="d-flex align-items-center bg-chat-sender px-3 py-2 rounded-4 h-100 ms-2">
                                            <div class="">{{$chat->text}}</div>
                                        </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-start w-100">
                                    @if (!$loop->last)
                                        @if ($chats[$loop->iteration]->user_id == auth()->user()->id)
                                            <div class="d-flex justify-content-start align-items-center mt-4" style="max-width: 60%">
                                        @else
                                            <div class="d-flex justify-content-start align-items-center mt-2" style="max-width: 60%">
                                        @endif
                                    @else
                                        <div class="d-flex justify-content-start align-items-center mt-4" style="max-width: 60%">
                                    @endif
                                        <div class="d-flex align-items-center bg-chat-receiver text-white px-3 py-2 rounded-4 h-100 me-2">
                                            <div class="">{{$chat->text}}</div>
                                        </div>
                                        @if (!$loop->first)
                                            @if (!$chat->isSameMinute($item->reverse()->values()[$loop->index-1]->created_at) || $item->reverse()->values()[$loop->index-1]->user_id != $chat->user_id)
                                                <div class="align-self-end">
                                                    <div class="fs-6 text-muted">{{date_format($chat->created_at, "H:i")}}</div>
                                                </div>
                                            @endif
                                        @else
                                            <div class="align-self-end">
                                                <div class="fs-6 text-muted">{{date_format($chat->created_at, "H:i")}}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endif
    
                                @if ($loop->last)
                                    <div class="d-flex justify-content-center w-100 mt-4">
                                        <div class="d-flex align-items-center justify-content-center" style="max-width: 60%">
                                            <div class="d-flex align-items-center bg-date text-muted px-3 py-2 rounded-5 h-100 ms-2 bg-opacity-50">
                                                @if ($chat->isToday())
                                                    <div>{{__("Today")}}</div>
                                                @elseif($chat->isYesterday())
                                                    <div>{{__("Yesterday")}}</div>
                                                @else
                                                    <div>{{date_format($chat->created_at, "d F Y")}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    </div>
                </div>
                @if ($room)
                    <div class="d-flex px-3 border-top border-secondary" style="height: 10%">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <input type="text" class="chat form-control border-0 text-white" style="background-color: transparent;" placeholder="{{__("Type a message")}}" id="chat_field">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('style2')
    <style>
        ::placeholder { 
                color: #949494 !important;
                opacity: 1;
        }

        .chat:focus{
            box-shadow: none;
        }
    </style>
@endsection

@section('script')
    <script>
        const field = document.getElementById('chat_field');
        var room_id = {{$room ? $room->id : json_encode(null)}};
        var user_id = {{auth()->user()->id}};
        console.log({{session()->get('current_room')}}, room_id);

        function show_chat(id){
            console.log(id);
            $.ajax({
                url: '/show-chat',
                type: 'POST',
                data: {room: id},
                async: false,
                success: function(response){
                    console.log(response);
                    location.href = '/chat';
                }
            });
        }
        
        if(room_id){
            field.addEventListener('keyup', function(e){
                if(e.key == 'Enter'){
                    console.log(field.value);

                    $.ajax({
                        url: '/send-chat',
                        type: 'POST',
                        data: {chat: field.value, room: room_id, user: user_id},
                        async: false,
                        success: function(response){
                            console.log(response);
                            location.reload();
                        }
                    });

                    field.value = '';
                }
            });
        }
        
    </script>
@endsection