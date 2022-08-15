<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <title>@yield('title')</title>
    <script src="https://kit.fontawesome.com/717fd72538.js" crossorigin="anonymous"></script>
    <style>
        ::-webkit-scrollbar {
            width: 7px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            border-radius: 5px;
            background: #616161;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #878787;
        }

        body::-webkit-scrollbar{ 
            display: none;
        }

        .bg-dark-secondary{
            background-color: #14181d;
        }

        .bg-dark-third{
            background-color: #1b2025;
        }

        .bg-primary-secondary{
            background-color: #acd3fe;
        }

        .bg-chat-sender{
            background-color: #86d97b;
        }

        .bg-chat-receiver{
            background-color: #555555;
        }

        .bg-date{
            background-color: #262729;
        }
    </style>
    @yield('style')
    @yield('style2')
</head>
<body class="bg-dark">
    @yield('navbar')
    <div class="container-fluid p-0">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    @yield('script')
    @yield('script2')
    @yield('script3')
</body>
</html>