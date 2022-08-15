@extends('template.master')
@section('title')
    {{$user->name}}
@endsection

@section('navbar')
    @include('template.navbar')
@endsection

@section('content')
    <div class="d-flex" style="min-height: 94vh;">
        @include('template.sidebar')
        <div class="w-100">
            @if (count($user->profile->where('active', false)))
                <div class="w-100" style="height:300px; max-height:300px; background-image: url('../storage/Assets/Avatar/{{$user->profile->where('active', false)->random()->avatar->image}}'); background-size:103px;"></div>
            @else
                <div class="w-100" style="height:300px; max-height:300px; background-image: url('../storage/Assets/Avatar/{{$user->profile->where('active', true)->first()->avatar->image}}'); background-size:103px;"></div>
            @endif
            <div style="margin-top: -10% !important; padding: 20px 150px;">
                <div class="d-flex justify-content-start my-3" >
                    <div class="border rounded-circle border-5" style="border-color: #14181d !important;">
                        <img src="../storage/Assets/Avatar/{{$user->profile->where('active', true)->first()->avatar->image}}" class="rounded-circle" style="width: 150px;">
                    </div>
                </div>
                <div class="d-flex justify-content-between text-white">
                    <div class="" style="width:65%">
                        <h3>{{$user->name}}</h3>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-envelope me-2"></i>
                            <div>{{$user->email}}</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-phone me-2"></i>
                            <div>{{$user->mobile}}</div>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-briefcase me-2"></i>
                            <div>{{$fields}}</div>
                        </div>
                        @if (!$me)
                            <div class="d-flex mt-2">
                                @if (!$isFollowed)
                                    <a href="/profile/{{$user->slug}}/follow" class="btn btn-primary d-flex align-items-center text-decoration-none rounded-5 text-dark bg-primary-secondary me-2">
                                        <i class="fa-solid fa-thumbs-up me-2"></i>
                                            @if (!$isFollower)
                                                <div>{{__("Follow")}}</div>
                                            @else
                                                <div>{{__("Follow back")}}</div>
                                            @endif
                                    </a>
                                    <a class="btn d-flex align-items-center text-decoration-none rounded-5 bg-dark-secondary border border-white text-white me-2">
                                        <i class="fa-solid fa-lock me-2"></i>
                                        <div>{{__("Message")}}</div>
                                    </a>
                                @else
                                    @if ($isFriend)
                                        <a class="btn btn-primary d-flex align-items-center text-decoration-none rounded-5 text-dark bg-primary-secondary me-2" onclick="show_chat()">
                                            <i class="fa-solid fa-comment-dots me-2"></i>
                                            <div>{{__("Message")}}</div>
                                        </a>
                                    @else
                                        <a class="btn d-flex align-items-center text-decoration-none rounded-5 bg-dark-secondary border border-white text-white me-2">
                                            <i class="fa-solid fa-lock me-2"></i>
                                            <div>{{__("Message")}}</div>
                                        </a>
                                    @endif
                                    <a href="/profile/{{$user->slug}}/unfollow" class="btn d-flex align-items-center text-decoration-none rounded-5 bg-dark-secondary border border-white text-white me-2">
                                        <i class="fa-solid fa-thumbs-down me-2"></i>
                                        <div>{{__("Unfollow")}}</div>
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="btn text-decoration-none rounded-5 bg-dark-secondary text-white mt-3" onclick="anonymous()">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="decoy" style="opacity: 1" {{!$user->visibility ? 'checked disabled' : ''}}>
                                    <label class="form-check-label" style="opacity: 1">{{__("Private account")}}</label>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="border border-secondary rounded-3 p-3 d-flex flex-column justify-content-center" style="width: 30%">
                        <div class="mb-3">
                            <h5 class="m-0">{{__("AMOUNT INFO")}}</h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="text-muted">
                                <div class="mb-2">{{__("AVATARS")}}</div>
                                <div class="mb-2">{{__("CONNECTIONS")}}</div>
                                <div class="mb-2">LINKEDIN</div>
                            </div>
                            <div class="text-end">
                                <div class="mb-2">{{count($user->avatar)}}</div>
                                <div class="mb-2">{{$connection}}</div>
                                <div class="mb-2">
                                    <a href="https://www.linkedin.com/in/{{$user->username}}" target="_blank">
                                        {{Str::limit('www.linkedin.com/in/'.$user->username, 20, '...')}}
                                        <i class=" ms-2 fa-brands fa-linkedin"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="nav nav-tabs d-flex justify-content-between">
                        <form class="d-flex" action="/profile/{{$user->slug}}" method="GET" id="form">
                            <div class="nav-item">
                                <a class="nav-link {{$tab == 'collector' ? 'active' : 'text-white'}}" role="button" onclick="send_form('collector')">{{__("Collections")}}</a>
                            </div>
                            <div class="nav-item">
                                <a class="nav-link {{$tab == 'connection' ? 'active' : 'text-white'}}" role="button" onclick="send_form('connection')">{{__("Connections")}}</a>
                            </div>
                            <input type="hidden" name="tab" id="tab">
                        </form>
                        <div class="d-flex align-items-center text-white">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                            <div class="nav-item d-flex justify-content-end">
                                <input type="text" class="form-control ps-2 me-2 bg-transparent border-0 text-white" placeholder="{{__("Search by name")}}" id="search" oninput="search(this)">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="row d-flex flex-column align-items-center mt-4">
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 p-0" id="card">
                            @if ($tab == 'collector')
                                @foreach ($avatars as $avatar)
                                    <div class="col mb-3">
                                        @if ($me)
                                            <div class="card shadow-sm h-100 bg-dark-secondary border border-white" onclick="avatar({{$avatar->id}})" style="cursor: pointer">
                                        @else
                                            <div class="card shadow-sm h-100 bg-dark-secondary border border-white">
                                        @endif
                                            <img src="../storage/Assets/Avatar/{{$avatar->image}}" class="card-img-top">
                                            <div class="card-body">
                                                <h6 class="card-title text-white">{{$avatar->name}}</h6>
                                                <div class="d-flex text-warning">
                                                    <i class="fa-solid fa-coins me-2"></i>
                                                    <p class="card-text text-warning" style="font-size: 12px">{{$avatar->price}} {{__("COIN")}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @if (count($connections))
                                    @foreach ($connections as $network)
                                        <div class="col mb-3">
                                            <a href="/profile/{{$network->user->slug}}" class="text-decoration-none">
                                                <div class="card shadow-sm h-100 bg-dark-secondary border border-white">
                                                    <img src="../storage/Assets/Avatar/{{$network->user->profile->where('active', true)->first()->avatar->image}}" class="card-img-top">
                                                    <div class="card-body">
                                                        <h6 class="card-title text-white">{{$network->user->name}}</h6>
                                                        <p class="card-text text-white-50" style="font-size: 12px">{{$network->user->field->implode('name', ', ')}}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col text-muted ms-3">
                                        <h3>{{__("No connections")}}</h3>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var search_value;
        var user_id = {{$user->id}}
        var tab = {!! json_encode($tab) !!}
        var me = {{ json_encode($me) }};
        var visible = {{$user->visibility}};
        var room = {{$room ? $room->id : json_encode(null)}};

        function send_form(tab){
            document.getElementById('tab').value = tab;
            document.getElementById('form').submit();
        }

        function show_chat(){
            $.ajax({
                url: '/show-chat',
                type: "POST",
                data: {room: room},
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    location.href = '/chat'
                }
            });
        }

        function avatar(avatar){
            // console.log(avatar);
            $.ajax({
                url:"/profile/show-avatar",
                type:"POST",
                data: {avatar: avatar, visibility: visible},
                dataType: 'json',
                async:false,
                success:function(response){
                    Swal.fire(response).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url:"/profile/set-avatar",
                                type:"POST",
                                data: {avatar: avatar},
                                dataType: 'json',
                                async:false,
                                success:function(response){
                                    location.reload();
                                }
                            })
                        }
                    });
                }
            })            
        }

        function search(e){
            $.ajax({
                url:"/profile/search",
                type:"POST",
                data: {search: e.value, id: user_id, tab: tab, me: me},
                dataType: 'json',
                async:false,
                success:function(response){
                    document.getElementById('card').innerHTML = response;
                }
            })
        }

        const swalAnon = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ms-1',
                denyButton: 'btn btn-outline-secondary me-1',
            },
            buttonsStyling: false
        });

        function anonymous(){
            var balance = {{$user->balance}}
            if(visible){
                var confirm = {!! "'".__('private')."'" !!};
                var cancel = {!! "'".__('public')."'" !!};
                var price = 50;
            }
            else{
                var confirm = {!! "'".__('public')."'" !!};
                var cancel = {!! "'".__('private')."'" !!};
                var price = 5;
            }


            Swal.fire({
                title: {!! "'".__('Set account to ')."'" !!}+confirm+'?',
                text: {!! "'".__('Confirm and pay a fee of ')."'" !!}+price+{!! "' ".strtolower(__('COIN'))."'" !!},
                confirmButtonText: {!! "'".__('Set to ')."'" !!}+confirm,
                cancelButtonText: {!! "'".__('Stay ')."'" !!}+cancel,
                showCancelButton: true,
                reverseButtons: true,
            }).then((result) => {
                if(result.isConfirmed){
                    if(balance >= price){
                        $.ajax({
                            url:"/profile/change-visibility",
                            type:"POST",
                            data: {price: price},
                            dataType: 'json',
                            async:false,
                            success:function(response){
                                location.reload();
                            }
                        });
                    }
                    else{
                        Swal.fire({
                            title: {!! "'".__('Insufficient balance!')."'" !!},
                            text: {!! "'".__('You need ')."'" !!}+(50-balance)+{!! "'".__(' more coins')."'" !!},
                            icon: 'info',
                        });
                    }
                }
            });

            Swal.getConfirmButton().blur();
        }
    </script>
@endsection