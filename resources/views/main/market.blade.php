@extends('template.master')
@section('title', 'Bee Verse')

@section('navbar')
    @include('template.navbar')
@endsection

@section('content')
    <div class="d-flex h-100" style="min-height: 94vh">
        @include('template.sidebar')
        <div class="py-3 px-5 w-100">
            <div class="d-flex justify-content-between">
                <div class="d-flex text-white align-items-center">
                    <div class="nav-item d-flex align-items-center ms-3 fs-5">
                        <label for="search">
                            <i class="fa-solid fa-magnifying-glass me-2"></i>
                        </label>
                        <input type="text" class="fs-5 form-control p-0 ps-2 me-2 bg-transparent border-0 text-white" placeholder="{{__("Search by name")}}" id="search" oninput="search(this)">
                    </div>
                </div>
            </div>
            <div>
                <hr class="m-0 my-2" style="background-color:#dee2e6;height:2px;">
            </div>
            <div class="row d-flex flex-column align-items-center mt-4">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 p-0" id="card">
                    @foreach ($avatars as $avatar)
                        <div class="col mb-3">
                            <div class="card shadow-sm h-100 bg-dark-secondary border border-white" onclick="avatar({{$avatar->id}}, {{$avatar->price}})" style="cursor: pointer">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var search_value;
        var balance = {{auth()->user() ? auth()->user()->balance : 0}}

        const swalBuy = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success ms-1',
                denyButton: 'btn btn-outline-secondary me-1',
                title: 'p-0',
            },
            buttonsStyling: false
        });

        const swalSend = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-outline-secondary me-1',
                cancelButton: 'btn btn-secondary ms-1',
                title: 'p-0',
            },
            buttonsStyling: false
        });

        function check_balance(price){
            return balance >= price;
        }

        function avatar(avatar, price){
            console.log(avatar, price);
            $.ajax({
                url:"/offer-avatar",
                type:"POST",
                data: {avatar: avatar},
                dataType: 'json',
                async:false,
                success:function(response){
                    if(response.hasAvatar){
                        swalSend.fire(response.alert).then((result) => {
                            if(result.isConfirmed){
                                if(check_balance(price)){
                                    $.ajax({
                                        url:"/select-connection",
                                        type:"POST",
                                        async:false,
                                        success:function(response){
                                            (async() => {
                                                const { value: friend } = await Swal.fire({
                                                    title: {!! "'".__('Select recipient')."'" !!},
                                                    input: 'select',
                                                    inputOptions: response,
                                                    inputPlaceholder: {!! "'".__('Click to select')."'" !!},
                                                    showCancelButton: true,
                                                    inputValidator: (value) => {
                                                        return new Promise((resolve) => {
                                                            if (value) {
                                                                resolve()
                                                            } else {
                                                                resolve({!! "'".__('You need to select a connection!')."'" !!})
                                                            }
                                                        })
                                                    }
                                                })
    
                                                $.ajax({
                                                    url:"/check-avatar",
                                                    type:"POST",
                                                    data: {avatar: avatar, id: friend},
                                                    dataType: 'json',
                                                    async:false,
                                                    success:function(response){
                                                        if(!response.hasAvatar){
                                                            Swal.fire({
                                                                title: {!! "'".__('Processing payment')."'" !!},
                                                                timer: '1200',
                                                                timerProgressBar: true,
                                                                didOpen: () => {
                                                                    Swal.showLoading()
                                                                },
                                                                willClose: () => {
                                                                    $.ajax({
                                                                        url:"/send-avatar",
                                                                        type:"POST",
                                                                        data: {avatar: avatar, id: friend},
                                                                        dataType: 'json',
                                                                        async:false,
                                                                        success:function(response){
                                                                            console.log(response);
                                                                            Swal.fire({
                                                                                title: {!! "'".__('Purchase complete!')."'" !!},
                                                                                html: "<i><b>"+response.avatar+"</b></i> "+ {!! "'".__("avatar has been successfully sent to")."'" !!}+"<br><b>"+response.user+"</b>",
                                                                                icon: 'success',
                                                                                didClose: () => {
                                                                                    location.reload();
                                                                                }
                                                                            });
                                                                        }
                                                                    });
                                                                }
                                                            });
                                                        }
                                                        else{
                                                            Swal.fire({
                                                                title: {!! "'".__("Sorry, you can\'t gift this avatar")."'" !!},
                                                                text: response.user+{!! "'".__(' already has this avatar')."'" !!},
                                                                icon: 'info',
                                                            });
                                                        }
                                                    }
                                                });
                                            })();
                                            console.log(document.querySelector('option').hidden = true);
                                        },
                                        error:function(){
                                            Swal.fire({
                                                title: {!! "'".__("You don\'t have any connection!")."'" !!},
                                                text: {!! "'".__("Go to home page to find some connections!")."'" !!},
                                                icon: 'info',
                                            });
                                        }
                                    });
                                }
                                else{
                                    Swal.fire({
                                        title: {!! "'".__('Insufficient balance!')."'" !!},
                                        text: {!! "'".__('You need ')."'" !!}+(price-balance)+{!! "'".__(' more coins')."'" !!},
                                        icon: 'info',
                                    });
                                }
                            }
                        });
                        swalSend.getConfirmButton().blur();
                        swalSend.getCancelButton().blur();
                    }
                    else{
                        swalBuy.fire(response.alert).then((result) => {
                            if(result.isConfirmed){
                                if(check_balance(price)){
                                    Swal.fire({
                                        title: {!! "'".__('Processing payment')."'" !!},
                                        timer: '1200',
                                        timerProgressBar: true,
                                        didOpen: () => {
                                            Swal.showLoading()
                                        },
                                        willClose: () => {
                                            $.ajax({
                                                url:"/buy-avatar",
                                                type:"POST",
                                                data: {avatar: avatar},
                                                dataType: 'json',
                                                async:false,
                                                success:function(response){
                                                    console.log(response);
                                                    Swal.fire({
                                                        title: {!! "'".__('Purchase complete!')."'" !!},
                                                        text: {!! "'".__("Check your profile\'s collector to use this avatar")."'" !!},
                                                        icon: 'success',
                                                        didClose: () => {
                                                            location.reload();
                                                        }
                                                    });
                                                }
                                            });
                                        }
                                    });
                                }
                                else{
                                    Swal.fire({
                                        title: {!! "'".__('Insufficient balance!')."'" !!},
                                        text: {!! "'".__('You need ')."'" !!}+(price-balance)+{!! "'".__(' more coins')."'" !!},
                                        icon: 'info',
                                    });
                                }
                            }
                            else if(result.isDenied){
                                if(check_balance(price)){
                                    $.ajax({
                                        url:"/select-connection",
                                        type:"POST",
                                        async:false,
                                        success:function(response){
                                            (async() => {
                                                const { value: friend } = await Swal.fire({
                                                    title: {!! "'".__('Select recipient')."'" !!},
                                                    input: 'select',
                                                    inputOptions: response,
                                                    inputPlaceholder: {!! "'".__('Click to select')."'" !!},
                                                    showCancelButton: true,
                                                    inputValidator: (value) => {
                                                        return new Promise((resolve) => {
                                                            if (value) {
                                                                resolve()
                                                            } else {
                                                                resolve({!! "'".__('You need to select a connection!')."'" !!})
                                                            }
                                                        })
                                                    }
                                                })

                                                $.ajax({
                                                    url:"/check-avatar",
                                                    type:"POST",
                                                    data: {avatar: avatar, id: friend},
                                                    dataType: 'json',
                                                    async:false,
                                                    success:function(response){
                                                        if(!response.hasAvatar){
                                                            if(check_balance(price)){
                                                                Swal.fire({
                                                                    title: {!! "'".__('Processing payment')."'" !!},
                                                                    timer: '1200',
                                                                    timerProgressBar: true,
                                                                    didOpen: () => {
                                                                        Swal.showLoading()
                                                                    },
                                                                    willClose: () => {
                                                                        $.ajax({
                                                                            url:"/send-avatar",
                                                                            type:"POST",
                                                                            data: {avatar: avatar, id: friend},
                                                                            dataType: 'json',
                                                                            async:false,
                                                                            success:function(response){
                                                                                console.log(response);
                                                                                Swal.fire({
                                                                                    title: {!! "'".__('Purchase complete!')."'" !!},
                                                                                    html: "<i><b>"+response.avatar+"</b></i> "+ {!! "'".__("avatar has been successfully sent to")."'" !!}+"<br><b>"+response.user+"</b>",
                                                                                    icon: 'success',
                                                                                    didClose: () => {
                                                                                        location.reload();
                                                                                    }
                                                                                });
                                                                            }
                                                                        });
                                                                    }
                                                                });
                                                            }
                                                            else{
                                                                Swal.fire({
                                                                    title: {!! "'".__('Insufficient balance!')."'" !!},
                                                                    text: {!! "'".__('You need ')."'" !!}+(price-balance)+{!! "'".__(' more coins')."'" !!},
                                                                    icon: 'info',
                                                                });
                                                            }
                                                        }
                                                        else{
                                                            Swal.fire({
                                                                title: {!! "'".__("Sorry, you can\'t gift this avatar")."'" !!},
                                                                text: response.user+{!! "'".__(' already has this avatar')."'" !!},
                                                                icon: 'info',
                                                            });
                                                        }
                                                    }
                                                });
                                            })();
                                            console.log(document.querySelector('option').hidden = true);
                                        },
                                        error:function(){
                                            Swal.fire({
                                                title: {!! "'".__("You don\'t have any connection!")."'" !!},
                                                text: {!! "'".__("Go to home page to find some connections!")."'" !!},
                                                icon: 'info',
                                            });
                                        }
                                    });
                                }
                                else{
                                    Swal.fire({
                                        title: {!! "'".__('Insufficient balance!')."'" !!},
                                        text: {!! "'".__('You need ')."'" !!}+(price-balance)+{!! "'".__(' more coins')."'" !!},
                                        icon: 'info',
                                    });
                                }
                            }
                        });
                        swalBuy.getConfirmButton().blur();
                    }
                }
            })            
        }

        function search(e){
            search_value = document.getElementById("search").value;

            $.ajax({
                url:"/market",
                type:"POST",
                data: {search: search_value},
                dataType: 'json',
                async:false,
                success:function(response){
                    document.getElementById('card').innerHTML = response;
                }
            })
        }
    </script>
@endsection