@extends('layouts.home')
@section('title', 'Tìm kiếm')
@section('content')
<div id="container-detail">
    <div class="row">
        <div class="col-sm-12">
            <nav aria-label="breadcrumb" style="text-align:left; background:black; border-radius: 10px 10px 0 0;padding-left:10px">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a style="text-decoration: none; color:white" href="">Tìm kiếm</a></li>
                </ol>
            </nav>	
            <div>
                <select id="filter" name="filter">
                    <option value="new" {{$Sort=='new'? 'selected' : ''}}>Xếp theo: mới nhất</option>
                    <option value="hightolow" {{$Sort=='hightolow'? 'selected' : ''}}>Xếp theo: giá cao đến thấp</option>
                    <option value="lowtohigh" {{$Sort=='lowtohigh'? 'selected' : ''}}>Xếp theo: giá thấp đến cao</option>
                </select>
            </div>
            <div id="product_list" style="width: 100%; height: auto; position:relative">
                @for ($i = 0; $i < count($Products); $i++)
                    <div class="product">
                        <div class="image">
                            <a href="{{route('home')}}/{{$Products[$i]['tag']}}"><img src="{{ asset('assets/products/'.$Products[$i]['files'][0]['filename']); }}" class="product_img" style="width:100%" alt="Image"></a> 
                            @if (count($Products[$i]['files']) > 1 )
                            <a href="{{route('home')}}/{{$Products[$i]['tag']}}"><img src="{{ asset('assets/products/'.$Products[$i]['files'][1]['filename']); }}" class="product_img_top" alt="Image"></a> 
                            @endif
                            <div class="overlay_product">
                                <button class="show_profile" value="{{$Products[$i]['id']}}">Xem sơ</button>
                                <button onclick="add_cart({{$Products[$i]['id']}})">Thêm vào<br>giỏ hàng</button>
                            </div>
                        </div>
                        <div class="sub">
                            <a style="text-decoration: none" class="product_name" href="{{route('home')}}/{{$Products[$i]['tag']}}" title="">{{$Products[$i]['name']}}</a>
                            <a style="text-decoration: none" class="product_price" href="{{route('home')}}/{{$Products[$i]['tag']}}" title="">{{number_format($Products[$i]['price'],0,',','.')}} VND</a>
                        </div>  
                    </div>
                @endfor
            </div>
            @if ($Count_page > 1)
            <ul class="pagination justify-content-center" id="pagination">
                @if ($Page > 1)
                    <li class="page-item"><a class="page-link" style="color: black;" href="?q={{$Search}}&page=1&sort={{$Sort}}">Trang đầu</a></li>
                @endif
                @for ($i = 1; $i <= $Count_page; $i++)
                    <li class="page-item {{$Page==$i ? 'disabled' : ''}}"><a class="page-link" style="{{$Page==$i ? 'color: #E06F18' : 'color: black'}}" href="?q={{$Search}}&page={{$i}}&sort={{$Sort}}">{{$i}}</a></li>
                @endfor
                @if ($Page < $Count_page)
                    <li class="page-item"><a class="page-link" style="color: black;" href="?q={{$Search}}&page={{$Count_page}}&sort={{$Sort}}">Trang cuối</a></li>
                @endif 
            </ul>
            @endif 
        </div> 
    </div> 
</div>
<script>
    $(document).ready(function(){
        $('#filter').change(function(){       
            url = window.location.pathname;
            window.location.assign(url+'?q={{$Search}}&page=1&sort='+$(this).val());
        })
    })
</script>
@endsection