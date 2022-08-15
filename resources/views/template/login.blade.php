@section('style')
    <style>
        .overlay{
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 1000;
            background-color: rgb(0, 0, 0,  0.9);
        }

        .close{
            position: fixed;
            top: 18px;
            right: 30px;
            left: unset;
            bottom: unset;
            z-index: 100;
            /* color: #bdc0c2; */
        }

        .error{
            z-index: 100;
        }
    </style>
@endsection

@section('script2')
    <script>
        // var signin = {!! json_encode(__('Sign in')) !!};
        // var test = 
        // console.log(signin);

        const Form = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary rounded-4',
            },
            buttonsStyling: false
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
        });
        
        function open_login(){
            (async() => {
                const { value: formValues } = await Form.fire({
                    title: {!! json_encode(__('Sign in')) !!},
                    html:
                        '<div class="form-floating mb-3 mt-1 text-start w-75">' +
                            '<input id="swal-input1" class="form-control m-0" type="email" placeholder="Email">' +
                            '<label for="swal-input1">Email</label>' +
                        '</div>' +
                        '<div class="form-floating mb-3 text-start w-75">' +
                            '<input id="swal-input2" class="form-control m-0" type="password" placeholder="Password">' +
                            '<label for="swal-input2"> {!! __('Password') !!}</label>' +
                        '</div>' +
                        '<div class="mb-3 d-flex justify-content-start w-75">' +
                            '<input type="checkbox" name="remember_me" id="remember_me" class="me-2">' +
                            '<label for="remember_me">{!! __('Remember me') !!}</label>' +
                        '</div>'
                        ,
                    confirmButtonText: {!! json_encode(__('Sign in')) !!},
                    showCloseButton: true,
                    allowOutsideClick: false,
                    preConfirm: () => {
                        var email = document.getElementById('swal-input1').value;
                        var password = document.getElementById('swal-input2').value;
                        var remember = document.getElementById('remember_me').checked;

                        

                        return $.ajax({
                            url:"/login",
                            type:"POST",
                            data: {email: email, password: password, remember_me: remember},
                            dataType: 'json',
                            async:false,
                            success:function(response){
                                if(!response){
                                    Swal.showValidationMessage({!! "'".__('Invalid Credentials!')."'" !!})
                                    password.value = '';
                                }
                                console.log(response);
                            }
                        });
                    },
                })

                if(formValues){
                    $.ajax({
                        url:"/just-login",
                        type:"POST",
                        async:false,
                        success:function(){
                            location.reload();
                        }
                    })
                }
            })()

            var container = Form.getHtmlContainer();
            var action = Form.getActions();
            var confirm = Form.getConfirmButton();
            var username = document.getElementById('swal-input1');

            container.setAttribute('class', 'swal2-html-container d-flex flex-column align-items-center justify-content-center');
            action.setAttribute('class', 'swal2-actions w-50');
            confirm.setAttribute('class', 'swal2-confirm btn btn-primary rounded-4 w-100');
            confirm.setAttribute('style', 'height:3em');
            confirm.blur();
            username.focus();
        }

        var login_status = "{{session()->get('message')}}"
        // console.log(login_status)

        if(login_status == "just-login"){
            $.ajax({
                url:"/done-login",
                type:"POST",
                async:false,
                success:function(response){
                    console.log(response);
                }
            })

            Toast.fire({
                icon: 'success',
                title: {!! "'".__('Signed in successfully')."'" !!},
            })
        }
        else if(login_status == 'want-login'){
            open_login();
        }
    </script>
@endsection
