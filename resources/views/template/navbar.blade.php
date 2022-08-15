<header>
    <nav class="navbar navbar-expand-lg p-0 bg-dark-secondary border border-start-0 border-secondary" style="height: 6vh">
        <div class="container-fluid p-0 ">
            <a class="navbar-brand mx-3 p-0 d-flex align-items-center" href="/">
                <img src="../storage/Assets/Icon/logo-full.png" width="110px">
            </a>
            <div class="d-flex justify-content-end align-items-center container-md p-0 m-0">
                <div class="navbar-nav">
                    <div class="nav-item dropdown d-flex align-items-center me-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-white-50 fs-5" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-globe me-3"></i>
                            <p class="m-0">{{strtoupper(Config::get('app.locale'))}}</p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-dark-secondary p-0" aria-labelledby="langDropdown">
                            @if (Config::get('app.locale') == 'en')
                                <div class="dropdown-item py-2 text-muted">English</div>
                                <a class="dropdown-item py-2 text-white" href="{{ route('switch-lang', 'id') }}">Indonesia</a>
                            @else
                                <a class="dropdown-item py-2 text-white" href="{{ route('switch-lang', 'en') }}">English</a>
                                <div class="dropdown-item py-2 text-muted">Indonesia</div>
                            @endif
                        </div>
                    </div>
                    @auth
                        <div class="nav-item px-3 d-flex flex-column justify-content-center border-start border-secondary" role="button" onclick="topup()">
                            <div class="text-muted" style="font-size: 14px">{{__("BALANCE")}}</div>
                            <div class="d-flex align-items-center text-warning">
                                <i class="fa-solid fa-coins me-2"></i>
                                <div>{{auth()->user()->balance}} {{__("COIN")}}</div>
                            </div>
                        </div>
                    @endauth
                    <div class="nav-item dropdown d-flex align-items-center border-start border-secondary px-3 ">
                        <a class="nav-link text-white-50 p-0 fs-3" id="userDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                            <i class="fa-solid fa-circle-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end p-0 bg-dark-secondary w-100" aria-labelledby="userDropdown">
                            @guest
                                <a class="dropdown-item text-white" role="button" onclick="open_login()">{{__("Sign In")}}</a>
                                <a class="dropdown-item text-white" href="/register">{{__("Register")}}</a>
                            @endguest
                            @auth
                                <a class="dropdown-item py-2 text-white" href="/profile/{{auth()->user()->slug}}">{{__("Profile")}}</a>
                                <a class="dropdown-item py-2 text-danger" href="/logout">{{__("Log Out")}}</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

@include('template.login')

@section('script3')
    <script>
        const swalTopUp = Swal.mixin({
            customClass: {
                    confirmButton: 'btn btn-warning ms-1',
                },
            buttonsStyling: false
        });
        
        function topup(){
            swalTopUp.fire({
                title: {!! "'".__('Coin Top Up')."'"!!},
                text: {!! "'".("Add 100 coin into your balance")."'" !!},
                showCloseButton: true,
                confirmButtonText: '<i class="fa-solid fa-circle-dollar-to-slot me-2"></i>{{ __("Top up") }}'
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        url:"/top-up",
                        type:"POST",
                        async:false,
                        success:function(){
                            location.reload();
                        }
                    });
                }
            });

            swalTopUp.getConfirmButton().blur();
        }        
    </script>
@endsection