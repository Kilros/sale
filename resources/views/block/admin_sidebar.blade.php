<style>
    table{
        font-size: 0.85rem;
    }
    #myTable button{
        font-size: 0.85rem;
    }
    #myTable a{
        font-size: 0.85rem;
    }
    @media screen and (max-width: 720px){
        table{
        font-size: 0.65rem;
    }
    #myTable button{
        font-size: 0.65rem;
    }
    #myTable a{
        font-size: 0.65rem;
    }
    }
    .sidebar .nav-item .nav-link[data-toggle=collapse]::after{
        display: none;
    }
    .sidebar-dark #sidebarToggle{
        line-height: 2.5rem;
    }
    .sidebar-dark #sidebarToggle::after{
        display: none;
    }
    .btn-primary{
        background: rgba(0, 0, 0, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: white;
    }
    .btn-primary:hover{
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: rgba(0, 0, 0, 0.85);
    }
    .btn-primary:focus{
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: rgba(0, 0, 0, 0.85);
    }
    .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show>.btn-primary.dropdown-toggle:focus {
        box-shadow: none;
    }
    .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle{
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: rgba(0, 0, 0, 0.85);
    }
    .btn-success{
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: rgba(0, 0, 0, 0.85);
    }
    .btn-success:hover{
        background: rgba(0, 0, 0, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: white;
    }
    .btn-success:focus{
        background: rgba(0, 0, 0, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: white;
    }
    .btn-success:not(:disabled):not(.disabled).active:focus, .btn-success:not(:disabled):not(.disabled):active:focus, .show>.btn-success.dropdown-toggle:focus {
        box-shadow: none
    }
    .btn-success:not(:disabled):not(.disabled).active, .btn-success:not(:disabled):not(.disabled):active, .show>.btn-success.dropdown-toggle{
        background: rgba(0, 0, 0, 0.85);
        border: 1px solid rgba(0, 0, 0, 0.85);
        color: white;
    }
</style>
<ul style="background: rgba(0, 0, 0, 0.85)" class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
        <div class="sidebar-brand-icon">
            <i class="fa fa-pie-chart" aria-hidden="true"></i>
            {{-- <span><img style="height: 250px" src="{{ asset('assets/logo.png')}}" alt="logo"></span> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Qu???n Tr???</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @if (Auth::user()->level == 1)
    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('user')">    
        <a class="nav-link" href="{{Route('user')}}">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>Danh S??ch T??i Kho???n</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Danh M???c
    </div>
    <li class="nav-item @yield('banner')">    
        <a class="nav-link" href="{{Route('banner')}}">
            <i class="fa fa-slideshare" aria-hidden="true"></i>
            <span>Banner</span>
        </a>
    </li>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @yield('category')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa fa-list" aria-hidden="true"></i>
            <span>Danh m???c s???n ph???m</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Qu???n Tr???:</h6>          
                <a class="collapse-item" href="{{route('category')}}">Danh m???c c???p 1</a>
                <a class="collapse-item" href="{{route('category2')}}">Danh m???c c???p 2</a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item @yield('product')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fa fa-product-hunt" aria-hidden="true"></i>
            <span>Qu???n l?? s???n ph???m</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Qu???n l??:</h6>
                {{-- <a class="collapse-item" href="{{route('category')}}">Danh m???c s???n ph???m</a> --}}
                <a class="collapse-item" href="{{route('size')}}">Danh m???c k??ch th?????c</a>   
                <a class="collapse-item" href="{{route('product')}}">S???n Ph???m</a>        
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        T??i Kho???n
    </div>
    @endif
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item @yield('order')">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
            <span>Kh??ch H??ng</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Qu???n L??:</h6>
                <a class="collapse-item" href="{{route('order')}}">Danh s??ch ????n H??ng</a>
                {{-- <a class="collapse-item" href="utilities-animation.html">X???p H???ng B??n Ch???y</a>
                <a class="collapse-item" href="utilities-other.html">Thu Nh???p Th??ng</a> --}}
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </button>
    </div>
</ul>