@extends('template.master')

@section('content')
    <div class="row d-flex justify-content-center align-items-center">        
        <div style="width: 30%">
            <a class="d-flex justify-content-center my-3" href="/">
                <img src="../storage/Assets/Icon/logo-full.png" width="50%">
            </a>
            <div class="p-3 pb-1 bg-white rounded mb-3">
                <form action="/register" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label for="name" class="text-muted form-label">{{__("Name")}}</label>
                    <div class="mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{old('name')}}">
                        @error('name')
                            <div class="text-danger ms-2">{{__($message)}}</div>
                        @enderror
                    </div>

                    <label for="username" class="text-muted form-label">{{__("LinkedIn Username")}}</label>
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text @error('username') border-danger @enderror">https://www.linkedin.com/in/</span>
                            <input type="text" class="form-control @error('username') is-invalid border-start-0 rounded-end @enderror" name="username" id="username" value="{{old('username')}}">
                        </div>
                        @error('username')
                            <div class="text-danger ms-2">{{__($message)}}</div>
                        @enderror
                    </div>

                    <label for="email" class="text-muted form-label">{{__("Email")}}</label>
                    <div class="mb-3" id="email_place">    
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{old('email')}}">
                        <div class="text-danger ms-2" id="email-error">@error('email'){{__($message)}}@enderror</div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="text-muted form-label">{{__("Password")}}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                        @error('password')
                            <div class="text-danger ms-2">{{__($message)}}</div>
                        @enderror
                    </div>

                    <label class="text-muted form-label">{{__("Gender")}}</label>
                    <div class="mb-3">
                        <div class="input-group border rounded @error('gender')border-danger @enderror">
                            <div class="bg-transparent form-control d-flex justify-content-between border-0 border-end">
                                <label for="radRecommended" class="form-check-label">{{__("Female")}}</label>
                                <input type="radio" id="radRecommended" name="gender" class="form-check-input" value="Female">
                            </div>
                            <div class="bg-transparent form-control d-flex justify-content-between border-0 border-start">
                                <label for="radNotRecommended" class="form-check-label">{{__("Male")}}</label>
                                <input type="radio" id="radNotRecommended" name="gender" class="form-check-input" value="Male">
                            </div>
                        </div>
                        @error('gender')
                            <div class="text-danger ms-1">{{__($message)}}</div>
                        @enderror
                    </div>

                    <label for="mobile" class="text-muted form-label">{{__("Mobile Number")}}</label>
                    <div class="mb-3">
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" id="mobile" value="{{old('mobile')}}">
                        @error('mobile')
                            <div class="text-danger ms-2">{{__($message)}}</div>
                        @enderror
                    </div>

                    <label class="text-muted form-label">{{__("Job Fields")}}</label>
                    <div class="accordion mb-3" id="accordionFlushExample">
                        <div class="accordion-item @error('chk_job')border-danger rounded @enderror">
                            <h2 class="accordion-header" id="flush-headingOne">
                                <button class="accordion-button collapsed text-dark" type="button" id="btnJob" style="background: none;" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne"></button>
                            </h2>
                            <div id="flush-collapseOne" class="accordion-collapse collapse overflow-auto p-2 ps-3" style="max-height: 95px;" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                @foreach ($fields as $field)
                                    <div class="chk_body my-1">
                                        <input class="form-check-input me-2" type="checkbox" value="{{$field->id}}" id="{{$field->name}}" name="chk_job[]" onchange="check(this)">
                                        <label class="form-check-label" for="{{$field->name}}">{{ucwords(__($field->name))}}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @error('chk_job')
                            <div class="text-danger ms-2">{{__($message)}}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center align-items-center mt-4 mb-3" style="height: 50px">
                        <button class="btn btn-primary rounded-5 w-100 h-100 fw-semibold fs-5" type="submit">{{__("Continue to payment")}}</button>
                    </div>
            
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div>{{__("Already on Bee Verse?")}}<a href="/login" class="text-primary ms-2 text-decoration-none fw-semibold">{{__("Sign in")}}</a></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function (w, d, ns) {
            w['EmailableObject'] = ns;
            w[ns] = w[ns] || function () { (w[ns].q = w[ns].q || []).push(arguments) },
            s = d.createElement('script'), fs = d.getElementsByTagName('script')[0];
            s.async = 1; s.src = 'https://js.emailable.com/v2/';
            fs.parentNode.insertBefore(s, fs)
        })(window, document, 'emailable');

        var email_error = document.getElementById('email-error');

        emailable('apiKey', 'live_7f5550bea6a55e3ff539');
        emailable('verifyAfterDelay', 1000);
        emailable('formValidation', true);
        emailable('inputSelector', '#email');
        emailable('ignoredForms', []);
        emailable('ignoredInputs', []);
        emailable('blockOnRateLimit', false);
        emailable('statusAppendTo', email_error);
        emailable('style', {
            loadingIconColor: 'rgba(0, 0, 0, 0.3)'
        });

        emailable('messages', {
            verifying: "Please wait a moment while we verify your email address.",
            invalid: "It looks like you've entered an invalid email address.",
            role: "It looks like you've entered a role or group email address.",
            free: "It looks like you've entered a free email address.",
            disposable: "It looks like you've entered a disposable email.",
            didYouMean: "It looks like you've entered an invalid email address. Did you mean [EMAIL]?",
            rateLimited: "It looks like you've attempted to enter too many emails."
        });

        $('#email').on('verified', function(event) {
            console.log(event.detail);
            if(event.detail['message']) email_error.innerHTML = event.detail['message'];
        });

        $('#email').on('error', function(event) {
            console.log(event.detail);
        });

        var checked = [];
        var button = document.getElementById("btnJob");

        function check(e){
            if(e.checked){
                checked.push(e.id);
            }
            else{
                checked = checked.filter(n => n != e.id);
            }

            button.innerHTML = checked.join(", ");
        }

        $(document).click(function(e) {
            if (!$(e.target).is('.chk_body') && !$(e.target).is('.form-check-input') && !$(e.target).is('.form-check-label')) {
                $('.collapse').collapse('hide');	    
            }
        });
        
    </script>
@endsection

@section('style')
    <style>
        .accordion-button{
            background: none !important;
        }
    </style>
@endsection

