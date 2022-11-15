@extends('layouts.home')
@section('title', 'KILROS')
@section('content')
@include('home.slide')
<div style="position:relative; text-align: center">
    <div class="jumbotron" style="margin: 5px 0 5px 0; padding: 20px; background: rgba(0, 0, 0, 0.6); color: white">
        {{-- <div class="container text-center"> --}}
            <h2>Sản phẩm bán chạy</h2> 
            <p>Sản phẩm bán chạy trong tháng</p>     
        {{-- </div> --}}
    </div>
    @include('home.trend')
    <h2 class="category_name">ÁO</h2>	
    <div id="product_list" style="width: 100%; height: auto; position:relative">
        @for ($i = 0; $i < count($Shirts); $i++)
            <div class="product">
                <div class="image">
                    <a href="{{route('home')}}/{{$Shirts[$i]['tag']}}"><img src="{{ asset('assets/products/'.$Shirts[$i]['files'][0]['filename']); }}" class="product_img" style="width:100%" alt="Image"></a> 
                    @if (count($Shirts[$i]['files']) > 1 )
                    <a href="{{route('home')}}/{{$Shirts[$i]['tag']}}"><img src="{{ asset('assets/products/'.$Shirts[$i]['files'][1]['filename']); }}" class="product_img_top" alt="Image"></a> 
                    @endif
                    <div class="overlay_product">
                        <button class="show_profile" value="{{$Shirts[$i]['id']}}">Xem sơ</button>
                        <button type="button" onclick="add_cart({{$Shirts[$i]['id']}})">Thêm vào<br>giỏ hàng</button>
                    </div>
                </div>
                <div class="sub">
                    <a style="text-decoration: none" class="product_name" href="{{route('home')}}/{{$Shirts[$i]['tag']}}" title="">{{$Shirts[$i]['name']}}</a>
                    <a style="text-decoration: none" class="product_price" href="{{route('home')}}/{{$Shirts[$i]['tag']}}" title="">{{number_format($Shirts[$i]['price'],0,',','.')}} VND</a>
                </div>          
            </div>
        @endfor
    </div>
    <div id="extensive_shirt_list" style="width: 100%; height: auto; position:relative;"></div>
    <div id="shirt_button" style="clear:left; display: flex; justify-content: center;">
        @if (count($Shirts) >= 10)
            <button id="see_more_shirt" type="button" onClick="see_more_button('{{route('get_products')}}', 'shirt')" value="1">Xem thêm</button>
            <button id="collapse_shirt" type="button" onClick="collapse_button('shirt')">Thu gọn</button>
        @endif          
    </div>     
    <h2 class="category_name">QUẦN</h2>	
    <div id="product_list" style="width: 100%; height: auto; position:relative">
        @for ($i = 0; $i < count($Pants); $i++)
            <div class="product">
                <div class="image">
                    <a href="{{route('home')}}/{{$Pants[$i]['tag']}}"><img src="{{ asset('assets/products/'.$Pants[$i]['files'][0]['filename']); }}" class="product_img" style="width:100%" alt="Image"></a>         
                    @if (count($Pants[$i]['files']) > 1 )
                    <a href="{{route('home')}}/{{$Pants[$i]['tag']}}"><img src="{{ asset('assets/products/'.$Pants[$i]['files'][1]['filename']); }}" class="product_img_top" alt="Image"></a> 
                    @endif
                    <div class="overlay_product">
                        <button class="show_profile" value="{{$Pants[$i]['id']}}">Xem sơ</button>
                        <button onclick="add_cart({{$Pants[$i]['id']}})">Thêm vào<br>giỏ hàng</button>
                    </div>
                </div>
                <div class="sub">
                    <a style="text-decoration: none" class="product_name" href="{{route('home')}}/{{$Pants[$i]['tag']}}" title="">{{$Pants[$i]['name']}}</a>
                    <a style="text-decoration: none" class="product_price" href="{{route('home')}}/{{$Pants[$i]['tag']}}" title="">{{number_format($Pants[$i]['price'],0,',','.')}} VND</a>
                </div>
            </div>
        @endfor
    </div>
    <div id="extensive_pants_list" style="width: 100%; height: auto; position:relative;"></div>
    <div id="pants_button" style="clear:left; display: flex; justify-content: center;">
        @if (count($Pants) >= 10)
            <button id="see_more_pants" type="button" onClick="see_more_button('{{route('get_products')}}', 'pants')" value="1">Xem thêm</button>
            <button id="collapse_pants" type="button" onClick="collapse_button('pants')">Thu gọn</button>
        @endif    
    </div>
</div>
@endsection