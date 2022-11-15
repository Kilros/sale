@extends('layouts.home')
@section('title', $Product['name'])
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div id="container-detail">    
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb" style="text-align:left; background:black; border-radius: 10px 10px 0 0;padding-left:10px">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a style="text-decoration: none; color:white" href="/">Home</a></li>
                    <li class="breadcrumb-item"><a style="text-decoration: none; color:white" href="{{route('home').'/'.$Product['categoryTag']}}">{{$Product['category']}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a  style="text-decoration: none; color: #E06F18;" href="">{{$Product['name']}}</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-sm-6">   
            @include('home.detail_image')                   
        </div>
        <div class="col-sm-6" style="padding-left: 30px; padding-right: 30px">
            <div id="name-detail">{{$Product['name']}}</div> 
            <div id="desc-detail">Mô tả chi tiết sản phẩm</div> 
            <div id="price-detail">{{number_format($Product['price'],0,',','.')}} VND</div>
            <div style="width: 100%; margin-bottom: 50px;">
                <div style="float:left; width: 50%; text-align: left; font-size: 2vh;">Kích thước</div> 
                <div style="float: right; width:50%; text-align: right; padding-right: 20px; font-size: 2vh; cursor:pointer; font-weight: 400;color: #909090;text-decoration: underline;">BẢNG SIZE</div>               
            </div>
            @if (count($Sizes) > 0) 
            <div class="wrapper">                              
                @for ($i = 0; $i < count($Sizes); $i++)
                    <input type="radio" name="size" id="size-{{$i+1}}" {{ $i==0 ? 'checked' : ''}} value={{$Sizes[$i]['size_name']['id']}}>
                    <label for="size-{{$i+1}}" class="option option-{{$i+1}}">
                        <span>{{$Sizes[$i]['size_name']['name']}}</span>
                    </label>
                @endfor              
            </div>
            <div id="detail_btn">
                <button id="btn-addtocart" type="button" onclick="add_cart({{$Product['id']}})">Thêm Vào Giỏ Hàng</button>
                <button id="btn-qpcart" type="button" onclick="quick_purchase_cart({{$Product['id']}})">Mua ngay</button>  
            </div> 
            @else
                <span style="color:#ee4266; font-size: 30px">Hết hàng</span>
             @endif       
        </div>
        <div class="col-sm-12" style="text-align: left; padding:50px">
            @php
               print_r($Product['content']);
            @endphp
        </div>
    </div>
</div>
<div id="modal-show">
    <button id="modal-close"><i class="fa fa-close" ></i></button>
    <button id="modal-previous"><</button>
    <button id="modal-next">></button>
    <img id="modal-image" src="" alt="">
</div>
@endsection