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
                <div class="d-flex justify-content-between w-75 ps-1">
                    <div class="d-flex align-items-center border-end border-start w-50 ps-3 me-3">
                        <div class="dropdown d-flex align-items-center me-2">
                            <a class="text-white-50 fs-5 text-decoration-none" id="genderDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                {{__("Filter by gender")}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-dark p-0 p-2" aria-labelledby="genderDropdown">
                                <div class="">
                                    <input class="form-check-input me-2" type="checkbox" value="Female" id="{{__("Female")}}" name="chk_gender[]" onchange="check_gender(this)">
                                    <label class="form-check-label" for="female">{{__("Female")}}</label>
                                </div>
                                <div class="">
                                    <input class="form-check-input me-2" type="checkbox" value="Male" id="{{__("Male")}}" name="chk_gender[]" onchange="check_gender(this)">
                                    <label class="form-check-label" for="male">{{__("Male")}}</label>
                                </div>
                            </div>
                            <div class="ms-3 fs-5 text-white" id="filter-gender">
                                
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center w-50">
                        <div class="dropdown d-flex align-items-center me-2">
                            <a class="text-white-50 fs-5 text-decoration-none" id="fieldrDropdown" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                {{__("Filter by profession")}}
                            </a>
                            <div class="dropdown-menu dropdown-menu-dark p-0 p-2 overflow-auto" aria-labelledby="fieldDropdown" style="max-height: 210px; min-width:14rem;">
                                @foreach ($fields as $field)
                                    <div class="my-1">
                                        <input class="form-check-input me-2" type="checkbox" value="{{$field->name}}" id="{{__($field->name)}}" name="chk_field[]" onchange="check_field(this)">
                                        <label class="form-check-label" for="field_{{$field->id}}">{{__($field->name)}}</label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="ms-3 fs-5 text-white" id="filter-field">
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex text-white align-items-center border-start">
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
                    {!! $users !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        var gender = document.getElementById("filter-gender");
        var field = document.getElementById("filter-field");
        var search_value;

        var gender_checked = [];
        var field_checked = [];

        var gender_checked_name = [];
        var field_checked_name = [];

        var chk_gender = document.querySelectorAll('[name="chk_gender[]"]');
        var chk_field = document.querySelectorAll('[name="chk_field[]"]');

        chk_gender.forEach(element => {
            if(gender_checked.includes(element.value)) element.checked = true;
        });

        chk_field.forEach(element => {
            if(field_checked.includes(element.value)) element.checked = true;
        });

        function ajax_call(){
            $.ajax({
                url:"/",
                type:"POST",
                data: {gender: gender_checked, field: field_checked, search: search_value},
                dataType: 'json',
                async:false,
                success:function(response){
                    document.getElementById('card').innerHTML = response;
                }
            })
        }

        function check_gender(e){
            if(e.checked){
                if(!gender_checked.includes(e.value)){
                    gender_checked.push(e.value);
                    gender_checked_name.push(e.id);
                }
            }
            else{
                gender_checked = gender_checked.filter(n => n != e.value);
                gender_checked_name = gender_checked_name.filter(n => n != e.id);
            }

            if(gender_checked_name.length) gender.innerHTML = ': ' + gender_checked_name.join(", ");
            else gender.innerHTML = '';

            search_value = document.getElementById("search").value;
            ajax_call();
        }

        function check_field(e){
            if(e.checked){
                if (!field_checked.includes(e.value)) {
                    field_checked.push(e.value);
                    field_checked_name.push(e.id)
                }
            }
            else{
                field_checked = field_checked.filter(n => n != e.value);
                field_checked_name = field_checked_name.filter(n => n != e.id);
            }

            if(field_checked_name.length == 1) field.innerHTML = ': ' + field_checked_name[0];
            else if(field_checked_name.length > 1) field.innerHTML = ': ' + field_checked_name[0] + ' +' + (field_checked_name.length-1) + ' more';
            else if(field_checked_name.length == 0) field.innerHTML = '';

            search_value = document.getElementById("search").value;
            ajax_call();
        } 
        
        function search(e){
            search_value = document.getElementById("search").value;
            ajax_call();
        }  
    </script>
@endsection