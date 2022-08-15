<nav class="nav sidebar flex-column p-2 bg-dark-secondary">
    <a href="/" class="nav-link {{$page == 'home' ? 'bg-light' : ''}}  rounded-4" style="--bs-bg-opacity: .5;">
        <div class="d-flex flex-column align-items-center" style="">
            <div class="rounded-circle d-flex justify-content-center align-items-center text-white bg-info bg-gradient" style="height: 45px; width: 45px;">
                <i class="fa-solid fa-house fa-lg"></i>
            </div>
            <div class="text-white mt-1" style="font-size: 0.8em;">
                HOME
            </div>
        </div>
    </a>
    <a href="/market" class="nav-link {{$page == 'market' ? 'bg-light' : ''}} rounded-4" style="--bs-bg-opacity: .5;">
        <div class="d-flex flex-column align-items-center" style="">
            <div class="rounded-circle d-flex justify-content-center align-items-center text-white bg-warning bg-gradient" style="height: 45px; width: 45px;">
                <i class="fa-solid fa-store fa-lg"></i>
            </div>
            <div class="text-white mt-1" style="font-size: 0.8em;">
                {{__("MARKET")}}
            </div>
        </div>
    </a>
    @auth
        <a href="/open-chat" class="nav-link {{$page == 'chat' ? 'bg-light' : ''}} rounded-4" style="--bs-bg-opacity: .5;">
            <div class="d-flex flex-column align-items-center" style="">
                <div class="rounded-circle d-flex justify-content-center align-items-center text-white bg-primary bg-gradient" style="height: 45px; width: 45px;">
                    <i class="fa-solid fa-comment-dots fa-lg"></i>
                </div>
                <div class="text-white mt-1" style="font-size: 0.8em;">
                    {{__("CHAT")}}
                </div>
            </div>
        </a>
    @endauth
</nav>