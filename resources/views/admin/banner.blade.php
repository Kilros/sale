@extends('layouts.admin')
@section('title','Quản Trị - Banner')
@section('banner','active')
@section('content')
<div class="container-fluid" >
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Banner</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" onclick="Insertbanner()">Thêm Banner</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 3%">ID</th>
                            <th style="width: 20%">Tên</th>
                            <th style="width: 30%">Ảnh</th>
                            {{-- <th>Thumbnail</th> --}}
                            <th>Ngày Tạo</th>
                            <th>Ngày Cập Nhật</th>
                            <th style="width: 5%"></th>
                            <th style="width: 5%"></th> 
                        </tr>
                    </thead>                                       
                    <tbody  id="myTable">
                        @foreach ($Banners as $banner)
                            <tr>
                                <td>{{$banner['id']}}</td>
                                <td>{{$banner['name']}}</td>
                                <td><img style="width: 100%" src="{{ asset('assets/banners/'.$banner['thumbnail']);}}"></td>
                                {{-- <td>{{$banner['thumbnail']}}</td> --}}
                                <td>{{$banner['created_at']}}</td>
                                <td>{{$banner['updated_at']}}</td>   
                                <td><button onclick="banner_edit({{$banner['id']}}, '{{route('banner')}}')" class="btn btn-success">Sửa</button></td>
                                <td><button onclick="banner_del({{$banner['id']}}, '{{route('banner')}}')" class="btn btn-danger">Xóa</button></td> 
                            </tr>
                        @endforeach                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <!-- The Modal -->
    <div class="modal fade" id="myModal" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">   
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Sửa/Thêm banner</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>          
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{route('banner')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="display: none">
                        <input type="text" class="form-control" id="idcheck" name="id">
                        </div>
                        <div class="form-group">
                            <label for="name">Tên banner:</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập tên banner" name="name">
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Ảnh</label>
                            <input type="file" onchange="Updatethumbnail()" class="form-control" id="thumbnail" name="photo" value="">
                        </div>
                        {{-- <div class="form-group">
                            <label for="thumbnail">Thumbnail:</label>
                            <input type="text" onchange="Updatethumbnail()" class="form-control" id="thumbnail" placeholder="Nhập thumbnail" name="thumbnail">
                        </div> --}}
                        <img src="" id="img_thumbnail" style="width: 100%; margin-bottom: 10px">
                        <button type="submit" name="action" value="register" class="btn btn-primary">Lưu</button>
                    </form>
                </div>
                
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>        
            </div>
        </div>
    </div>    
</div>
{{-- <script>
    function Updatethumbnail(){
        $("#img_thumbnail").attr("src", $("#thumbnail").val());
    }
</script>   --}}
@if(session()->has('success'))
    <script>
        alert('{{session()->get('success')}}');
    </script>
@endif
@endsection