<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- <base href="http://localhost/live/"> --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>
        <!--font-->
        {{-- <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Spectral:wght@300&display=swap" rel="stylesheet"> --}}

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Creepster&family=Monoton&display=swap&family=Roboto:wght@100;300&display=swap" rel="stylesheet">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
        {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

        {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- slide -->
        
        <link rel="stylesheet" href="{{ asset('assets/home/css/home.css'); }}" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>
    <body>
        <div class="notify"><span id="notifyType"></span></div>
        <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
        {{-- <img src="./public/img/anh.jpg"width="100%" height="auto" style="position: fixed; height:1000px; z-index: -1"> --}}
        <div id="header">
            @include('block.header')
        </div>  
        @include('block.menu')
        @include('block.cart')
        <div id="content" class="container-fluid">
            {{-- @include($page.'.index') --}}
            @yield('content')
        </div> 
        <footer id="footer">Coppyright</footer>
        {{-- <div id="footer">Coppyright</div> --}}
        <script src="{{ asset('assets/home/js/home.js'); }}"></script>
        @if(session()->has('success'))
            <script>
                $("#notifyType").html('{{session()->get('success')}}');
                $(".notify").toggleClass("notify_active");
                setTimeout(function(){
                    $(".notify").removeClass("notify_active");
                    $("#notifyType").empty();
                },3000);
            </script>
        @endif
    </body>
</html>