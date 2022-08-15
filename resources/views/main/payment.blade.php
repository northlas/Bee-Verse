@extends('template.master')

@section('content')
    <div class="row d-flex justify-content-center align-items-center">        
        <div style="width: 30%">
            <div class="d-flex justify-content-center my-3">
                <img src="../storage/Assets/Icon/logo-full.png" width="50%">
            </div>
            <div class="p-3 pb-1 bg-white rounded mb-3">
                <div>
                    <p>{{(__("Price"))}} : {{$price}}</p>
                </div>
                <form action="/payment" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="payment" class="text-muted form-label">{{__("Payment amount")}}</label>
                    <div class="mb-3">
                        <input type="number" class="form-control @error('payment') is-invalid @enderror" name="payment" id="payment" value="{{old('payment')}}" max="4000000000">
                        @error('payment')
                            <div class="text-danger ms-2">{{__($message)}}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center align-items-center mt-4 mb-3" style="height: 50px">
                        <button class="btn btn-primary rounded-5 w-100 h-100 fw-semibold fs-5" type="submit">{{__("Register")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if (session('alert'))        
        <script>
            var alert = {!! session('alert') !!};
            Swal.fire(alert).then((result) => {
                if(result.isConfirmed){
                    Swal.fire({!! "'".__('Saved!')."'" !!}, '', 'success').then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url:"/create-user",
                                type:"POST",
                                async:false,
                                success:function(response){
                                    window.location = response;
                                },
                                error: function(response){
                                    console.log(response);
                                }
                            })
                        }
                    })
                }
            });
        </script>
    @endif
@endsection