<style>
    #mySlider {
        overflow: hidden;
        position: relative;
        width: 100%;
        height: auto;
        /* margin:  0 0 20px 20px;  */
    }
    .singleSlide_show{
        position: relative;
        width: 100%;
        border-radius: 10px;
    }
    .singleSlide {
        position: absolute;
        left: 100%;
        width: 100%;
        top: 0px;
        border-radius: 10px;
    }
    #image-2, #image-3{
        /* display: none; */
    }
    #previous, #next{
        cursor: pointer;
        display: block;
        background: black;
        position: absolute;
        z-index: 1;
        height: 100%;
        width: 60px;
        opacity: 0;
        border: none;
        top: 0;
        transition: all 0.5s ease;
    }
    #previous{
        /* border-radius: 0 20px 20px 0; */
        left: 0px;
    }
    #next{
        /* border-radius: 20px 0 0 20px; */
        right: 0px;
    }
    #previous:hover, #next:hover{
        opacity: 0.15;
    }
    .img-detail-mini{
        width: 10%;
        margin: 5px;
        margin-top: 0px;
        border: 1px solid black;
        border-radius: 5px;
        transition: all 0.5s ease;
    }
    .img-detail-mini:hover{
        opacity: 0.5;
    }
    #modal-previous, #modal-next{
        outline: none;
        cursor: pointer;
        display: none;
        background: black;
        position: absolute;
        z-index: 102;
        height: 20%;
        width: 50px;
        opacity: 0.5;
        border: none;
        top: 40%;
        transition: all 0.5s ease;
    }
    #modal-previous{
        border-radius: 0 20px 20px 0;
        left: 0;
    }
    #modal-next{
        border-radius: 20px 0 0 20px;
        right: 0;
    }
    #modal-previous:hover, #modal-next:hover{
        opacity: 0.3;
    }

    @-webkit-keyframes slideIn {
    100% {
        left: 0;
    }
    }

    @keyframes slideIn {
    100% {
        left: 0;
    }
    }
    .slideInRight {
    left: -100%;
    -webkit-animation: slideIn 1s forwards;
    animation: slideIn 1s forwards;
    /* position: relative; */
    }

    .slideInLeft {
    left: 100%;
    -webkit-animation: slideIn 1s forwards;
    animation: slideIn 1s forwards;
    /* position: relative; */
    }

    @-webkit-keyframes slideOutLeft {
        100% {
            left: -100%;
        }
    }
    .slideOutLeft {
    -webkit-animation: slideOutLeft 1s forwards;
    animation: slideOutLeft 1s forwards;
    }
    @keyframes slideOutRight {
        100% {
            left: 100%;
        }
    }
    .slideOutRight {
    -webkit-animation: slideOutRight 1s forwards;
    animation: slideOutRight 1s forwards;
    }

</style>
<div id="mySlider">
    <button id="previous"><</button>   
    <button id="next">></button>
    @for ($i = 0; $i < count($Product['files']); $i++)
        <img id="image-{{$i}}" src="{{ asset('assets/products/'.$Product['files'][$i]['filename']); }}" class="singleSlide" alt="Image">
    @endfor
</div>
<div style="margin-top: 20px">
    @for ($i = 0; $i < count($Product['files']); $i++)
    <img src="{{ asset('assets/products/'.$Product['files'][$i]['filename']); }}" class="img-detail-mini" alt="{{$i}}">
@endfor
</div>
<script>
    function previous($i) {
        if ( {{count($Product['files'])}} > 1) {
            var nextSlideIndex;
            if ($i == 0) {
                nextSlideIndex = {{count($Product['files'])-1}}
            } else {
                nextSlideIndex = $i - 1;
            }
            $('#image-'+nextSlideIndex).css('left', '-100%');
            $('#image-'+$i).css('left', 0);
            $('#image-'+nextSlideIndex).attr('class', 'singleSlide_show slideInLeft')
            $('#image-'+$i).attr('class', 'singleSlide slideOutRight')
            return nextSlideIndex;
        }
    }
    function next($i) {
        if ( {{count($Product['files'])}} > 1) {
            var nextSlideIndex;
            if ($i == {{count($Product['files'])-1}}) {
                nextSlideIndex = 0;
            } else {
                nextSlideIndex = $i + 1;
            }
            $('#image-'+nextSlideIndex).css('left', '100%');
            $('#image-'+$i).css('left', 0);
            $('#image-'+nextSlideIndex).attr('class', 'singleSlide_show slideInRight')
            $('#image-'+$i).attr('class', 'singleSlide slideOutLeft')
            return nextSlideIndex;
        }
    }
    $(document).ready(function(){
        var $i = 0, $j = 1;
        $('#image-'+$i).attr('class', 'singleSlide_show');
        $('#previous').click(function () {        
            $i = previous($i);      
        });
        $('#next').click(function () {
            $i = next($i);
        });
        $('.img-detail-mini').click(function(){
            var nextSlideIndex = $(this).attr("alt");
            if($i > nextSlideIndex){
                $i = previous($i);
            }
            else{
                $i = next($i);
            }
        });
        $('.singleSlide, .singleSlide_show').click(function(){
            var $value = $(this).attr("src");
            $j = $i;
            $('#modal-show').css('position', 'fixed');
            $('#modal-image').attr("src", $value);
            $('#modal-image').show();
            $('#modal-previous').show();
            $('#modal-next').show();
            $('#modal-close').show();
            $('html, body').css('overflow', 'hidden');
        });
        $('#modal-close').click(function(){
            $i = $j;
            $('#modal-show').css('position', 'static');
            $('#modal-image').hide();
            $('#modal-previous').hide();
            $('#modal-next').hide();
            $('#modal-close').hide();
            $('html, body').css('overflow', 'visible');
        });
        $('#modal-previous').click(function () {
            $i--;
            if($i < 0){
                $i = {{count($Product['files'])-1}}
            }
            $('#modal-image').attr('src', $('#image-'+$i).attr('src')); 
        });
        $('#modal-next').click(function () {
            $i ++;
            if($i > {{count($Product['files'])-1}}){
                $i = 0;
            }
            $('#modal-image').attr('src', $('#image-'+$i).attr('src')); 
        });       
    });

</script>
