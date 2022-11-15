<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <base href="http://localhost/live/"> --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quên mật khẩu</title>

    <!-- Custom fonts for this template-->
    <link href="./public/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/admin/css/sb-admin-2.min.css'); }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg" style="margin-top: 12rem; margin-bottom:12rem">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block" style="background:url(https://cdn.wallpapersafari.com/35/88/aZRnb0.jpg)"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Quên mật khẩu</h1>
                                    </div>
                                    <form action="{{ route('forget') }}" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="email" name="email"
                                                placeholder="Nhập E-mail..." required>
                                        </div>
                                        <button type="submit" name="login" class="btn btn-primary btn-user btn-block">
                                            Gửi
                                        </button>
                                    </form>
                                    @if(session()->has('success'))
                                        <div style="color: blue; margin-top:10px">{{session()->get('success')}}</div>
                                    @endif
                                    @if(session('error'))
                                        <div style="color: red; margin-top:10px">{{session('error')}}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <!-- JQuery-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets/admin/js/bootstrap.bundle.min.js'); }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/admin/js/jquery.easing.min.js'); }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/admin/js/sb-admin-2.min.js'); }}"></script>
</body>

</html>