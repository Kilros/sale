<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<div>
    <div class="items" >
        @for ($i = 0; $i < count($Trends); $i++)
            <div class="product">
                <div class="image">
                    <a href="{{route('home')}}/{{$Trends[$i]['tag']}}"><img class="trend_img" src="{{ asset('assets/products/'.$Trends[$i]['files']); }}"></a>
                    <div class="overlay_product">
                        <button>Mua ngay</button>
                        <button onclick="add_cart({{$Trends[$i]['id']}})">Thêm vào<br>giỏ hàng</button>
                    </div>
                </div>
                <div class="sub">
                    <a style="text-decoration: none" class="product_name" href="{{route('home')}}/{{$Trends[$i]['tag']}}" title="phim1">{{$Trends[$i]['name']}}</a>
                    <a style="text-decoration: none" class="product_price" href="{{route('home')}}/{{$Trends[$i]['tag']}}" title="phim1">{{number_format($Trends[$i]['price'],0,',','.')}} VND</a>
                </div>
            </div>
        @endfor       
    </div>
</div>
<script>   
    $(document).ready(function(){
        var window_width = $( window ).width();
        if(window_width < 720){
            $('.items').slick({
                infinite: true,
                slidesToShow: 2,
                slidesToScroll: 1
            });	
        }
        else if(window_width < 1280){
            $('.items').slick({
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1
            });	
        }
        else{
            $('.items').slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 2
            });	
        }
    });
</script>
