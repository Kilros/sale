@if (count($Banners) > 0) 
<div id="mySlider">  
    @for ($i = 0; $i < count($Banners); $i++)
    <div id="slide{{$i}}" class="singleSlide">
        <img style="width: 100%" src="{{ asset('assets/banners/'.$Banners[$i]['thumbnail']);}}" alt=""> 
        {{-- <div class='slideOverlay'>
            <h1>{{$Banners[$i]['name']}}</h1>
            <h4>aaaaaaaa</h4>
            <a href="" target="_blank">Open Link</a>
        </div> --}}
    </div>  
    @endfor  
    <div id="slide-dot">
    @for ($i = 0; $i < count($Banners); $i++)
        <button id="dot{{$i}}" class="singleDot" value="{{$i}}"></button>
    @endfor
    </div>
    <div id="sliderPrev"><img src="https://nguyenvanhieu.vn/wp-content/uploads/2020/09/left-arrow.png"></div>
    <div id="sliderNext"><img src="https://nguyenvanhieu.vn/wp-content/uploads/2020/09/right-arrow.png"></div>
</div>
<script>
    var currentSlideIndex = 0;
    $('#slide' + currentSlideIndex).attr('class', 'singleSlide-show');
    $('#dot'+ currentSlideIndex).css('opacity', '1')
    setInterval(function(){
        nextSlide();
    }, 5000);
    // document.getElementById("slide" + currentSlideIndex).cls.left = 0;
    $(document).ready(function(){
        $('.singleDot').click(function(){
            value = $(this).val();
            if(value > currentSlideIndex){
                nextSlide();
            }
            else{
                prevSlide();
            }
        });
        $('#sliderPrev').click(function(){
            prevSlide();
        })
        $('#sliderNext').click(function(){
            nextSlide();
        })
    });
    function prevSlide() {
        var nextSlideIndex;
        if (currentSlideIndex === 0) {
            nextSlideIndex = {{count($Banners)-1}}
        } else {
            nextSlideIndex = currentSlideIndex - 1;
        }
        $('#dot'+ nextSlideIndex).css('opacity', '1')
        $('#dot'+ currentSlideIndex).css('opacity', '0.5')
        $('#slide' + nextSlideIndex).css('left', '-100%');
        $('#slide' + currentSlideIndex).css('left', '0');
        $('#slide' + nextSlideIndex).attr("class", "singleSlide-show slideInLeft");
        $('#slide' + currentSlideIndex).attr("class", "singleSlide slideOutRight");
        currentSlideIndex = nextSlideIndex;
    }
    function nextSlide() {
        var nextSlideIndex;
        if (currentSlideIndex === {{count($Banners)-1}}) {
            nextSlideIndex = 0;
        } else {
            nextSlideIndex = currentSlideIndex + 1;
        }
        $('#dot'+ nextSlideIndex).css('opacity', '1')
        $('#dot'+ currentSlideIndex).css('opacity', '0.5')
        $('#slide' + nextSlideIndex).css('left', '100%');
        $('#slide' + currentSlideIndex).css('left', '0');
        $('#slide' + nextSlideIndex).attr("class", "singleSlide-show slideInRight");
        $('#slide' + currentSlideIndex).attr("class", "singleSlide slideOutLeft");
        currentSlideIndex = nextSlideIndex;         
    }
</script>
@endif