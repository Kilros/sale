<style>
	#logo{
		position: absolute;
		top: -40px;
		left: 0;
	}
	#button-cart{
		height: 40px;
		width: 60px;
		position: absolute;
		border-radius: 10px;
		background: white;
		color:black;
		border: hidden; 
		top: 10px;
		right: 20px;
	}
	#numcart{
		font-size:15px;
	}
	#button-search{
		height: 40px; 
		width: 60px;
		position: absolute;
		border-radius: 10px;
		background: white; 
		color:black;
		border: hidden; 
		top: 10px;
		right: 90px;
	}
	
	#search{
		position: absolute;
		z-index: 11;
		height: 40px; 
		width: 400%;
		border-radius: 10px;
		border: 2px solid black; 
		top: 45px;
		right: 0; 
		display: none;
		outline: none;
	}
	#modal-profile{
		overflow-x:hidden;
		overflow-y: auto;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		z-index: 100;
		display: none;
		justify-content: center;
		align-items: center;
	}
	#modal-profile-bg{
		position: absolute;
		z-index: -1;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		background: rgba(0, 0, 0, 0.7);
	}
	#modal-profile-body{
		height: 500px;
		width: 50%;
		border-radius: 10px;
		background: white;
	}
	@media screen and (max-width: 720px){
		#modal-profile-body{
			width: 99%;
		}
	}
</style>
<div id="modal-profile">
	<div id="modal-profile-bg"></div>
	<div id="modal-profile-body">
            <div style="width: 50%; float: left; position: relative;">   
                <img id="profile-image" src="/assets/products/166257531326.jpg" alt="image" style="width: 100%; height: 480px; object-fit: cover; margin: 10px 0 0 10px">                 
            </div>
            <div style="width: 50%; float: left; padding: 30px;">
                <div id="name-detail">Name</div> 
                <div id="desc-detail">Des</div> 
                <div id="price-detail">100 VND</div>
                <div style="width: 100%; margin-bottom: 50px;">
                    <div style="float:left; width: 50%; text-align: left; font-size: 2vh;">Kích thước</div> 
                </div>
                <div style="display: block" id="prifile-size" class="wrapper">                                        
                </div>     
            </div>
	</div>									
</div>
<script>
    $(document).ready(function(){
		$('.show_profile').click(function(){
            var id = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('/get_products', {
                'type' : 'get_single',
                'id' : id,
            }, function(data){ 
                const dataselect = JSON.parse(data);  
                var i = 1;
                $('#prifile-size').empty();
                $('#profile-image').attr('src', '/assets/products/'+dataselect.files[0].filename); 
                $('#name-detail').html(dataselect.name);    
                $('#price-detail').html(new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(dataselect.price));  
                if(dataselect.sizes.length > 0){
                    dataselect.sizes.forEach(size => {
                        $('#prifile-size').append('<input type="radio" name="size" id="size-'+i+'" checked value="'+size.size_id+'"><label for="size-'+i+'" class="option option-'+i+'"><span>'+size.size_name.name+'</span></label>')
                        i++;
                    });  
                }   
                else
                {
                    $('#prifile-size').html("Hết hàng");
                }            
                $('#modal-profile').css('position', 'fixed');
                $('#modal-profile').css('display', 'flex');
                $('body').css({
                    overflow: 'hidden',
                    height: '100%'
                });	  
            });		
		});
		$('#modal-profile-bg').click(function(){
			$('#modal-navbar').css('position', 'static');
			$('#modal-profile').hide();
			$('body').css({
				overflow: 'auto',
				height: 'auto'
			});
		});
    });
</script>
<div id="container-menu">
	<div id="navbar-header">	
		<span id="navbar-show-modal">	
			<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 64 64" width="40px" height="40px">
				<g id="surface165213892">
					<path style=" stroke:none;fill-rule:nonzero;fill: white;fill-opacity:1;" d="M 49.777344 42.667969 C 51.742188 42.667969 53.332031 44.257812 53.332031 46.222656 C 53.332031 48.1875 51.742188 49.777344 49.777344 49.777344 C 48.710938 49.777344 15.289062 49.777344 14.222656 49.777344 C 12.257812 49.777344 10.667969 48.1875 10.667969 46.222656 C 10.667969 44.257812 12.257812 42.667969 14.222656 42.667969 C 15.289062 42.667969 48.710938 42.667969 49.777344 42.667969 Z M 49.777344 28.445312 C 51.742188 28.445312 53.332031 30.035156 53.332031 32 C 53.332031 33.964844 51.742188 35.554688 49.777344 35.554688 C 48.710938 35.554688 15.289062 35.554688 14.222656 35.554688 C 12.257812 35.554688 10.667969 33.964844 10.667969 32 C 10.667969 30.035156 12.257812 28.445312 14.222656 28.445312 C 15.289062 28.445312 48.710938 28.445312 49.777344 28.445312 Z M 49.777344 14.222656 C 51.742188 14.222656 53.332031 15.8125 53.332031 17.777344 C 53.332031 19.742188 51.742188 21.332031 49.777344 21.332031 C 48.710938 21.332031 15.289062 21.332031 14.222656 21.332031 C 12.257812 21.332031 10.667969 19.742188 10.667969 17.777344 C 10.667969 15.8125 12.257812 14.222656 14.222656 14.222656 C 15.289062 14.222656 48.710938 14.222656 49.777344 14.222656 Z M 49.777344 14.222656 "/>
				</g>
			</svg>
		</span>			
	</div>
	{{-- <div> --}}
		<div id="navbar-body">
			<div id="logo">
				<a href="{{route('home')}}"><img style="height: 140px" src="{{ asset('assets/logo.png')}}" alt=""></a>
			</div>
			<ul>
				<li class="menu-a"><a style="text-decoration: none" href="{{route('home')}}">TRANG CHỦ</a></li>
				@for ($i = 0; $i < count($Categories); $i++)
					<li class="menu-a"><a style= "text-decoration: none; text-transform: uppercase;" href="/{{$Categories[$i]['tag']}}">{{$Categories[$i]['name']}}</a>
					@if ($Categories[$i]['category2'] != null)
						<ul>
						@for ($j = 0; $j < count($Categories[$i]['category2']); $j++)
							<li style="{{$j==0 ? 'border-top: 2px solid #E06F18;' : ''}} text-transform: uppercase;" class="menu-b"><a style="text-decoration: none" href="/{{$Categories[$i]['tag']}}/{{$Categories[$i]['category2'][$j]['tag']}}">{{$Categories[$i]['category2'][$j]['name']}}</a></li>
						@endfor
						</ul>
					@endif
				@endfor
				<li class="menu-a"><a style="text-decoration: none" href="#">THÔNG TIN</a></li> 
			</ul>
		</div>
		<div>
			<button id="button-search">
				<svg  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 50 50" width="20px" height="20px">
					<g id="surface165750954">
						<path style=" stroke:none;fill-rule:nonzero;fill: black ;fill-opacity:1;" d="M 21 3 C 11.601562 3 4 10.601562 4 20 C 4 29.398438 11.601562 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601562 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z M 21 7 "/>
					</g>
				</svg>
				<form action="/search" method="get">
					<input id="search" type="text" class="form-control" placeholder="Tìm Kiếm" name="q">
				</form>
			</button>
			<button id="button-cart" type="button" onclick="show_cart()">
				<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-bag-dash" viewBox="0 0 16 16" width="20px" height="20px">
					<path fill-rule="evenodd" d="M5.5 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
					<path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
				</svg>
				<span class="number" id="numcart">{{isset($Cart_qty) ? $Cart_qty: 0;}}</span>
			</button>	
		</div>
	{{-- </div> --}}
</div>
<div id="modal-navbar">
	<div id="modal-bg"></div>
	<div id="modal-navbar-body">
		<ul>		
			<li class="modal-menu-a"><a style="text-decoration: none" href="{{route('home')}}">TRANG CHỦ</a></li>
			@for ($i = 0; $i < count($Categories); $i++)
				<li class="modal-menu-a"><a style="text-decoration: none; text-transform: uppercase;" href="/{{$Categories[$i]['tag']}}">{{$Categories[$i]['name']}}</a>
				@if ($Categories[$i]['category2'] != null)
					@for ($j = 0; $j < count($Categories[$i]['category2']); $j++)
						<div style="{{$j==0?'border-top: 1px solid white;' : ''}}" class="modal-menu-b"><a style="text-decoration: none; text-transform: uppercase;" href="/{{$Categories[$i]['tag']}}/{{$Categories[$i]['category2'][$j]['tag']}}">{{$Categories[$i]['category2'][$j]['name']}}</a></div>
					@endfor
				@endif
				</li>
			@endfor
			<li class="modal-menu-a"><a style="text-decoration: none" href="#">THÔNG TIN</a></li>
		</ul>
	</div>									
</div>
<script>
	$(document).ready(function(){
		$('#navbar-show-modal').click(function(){
			$('#modal-navbar').css('position', 'fixed');
			$('#modal-navbar-body').css('left', '-60%');
			$('#modal-navbar-body').attr('class', 'modal-navbar-body-show');
			$('body').css({
				overflow: 'hidden',
				height: '100%'
			});	
		});
		$('#modal-bg').click(function(){
			$('#modal-navbar').css('position', 'static');
			$('#modal-navbar-body').css('left', '0');
			$('#modal-navbar-body').attr('class', 'modal-navbar-body-hide');
			$('body').css({
				overflow: 'auto',
				height: 'auto'
			});
		});
		$(document).click(function (e){
			var container = $("#button-search");
			if (!container.is(e.target) && container.has(e.target).length === 0){
				$("#search").hide();		
			}
			else{
				$("#search").show();
			}
		});
	});
</script>