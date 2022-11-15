@extends('layouts.admin')
@section('title','Quản Trị - Danh mục sản phẩm 1')
@section('category','active')
@section('content')
    <div class="container-fluid">
                        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Danh Mục 1</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" onclick="Insertcategory()">Thêm Danh Mục</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 4%">ID</th>
                                <th>Tên Danh Mục Sản Phẩm</th>
                                <th>Ngày Tạo</th>
                                <th>Ngày Cập Nhật</th>
                                <th style="width: 5%"></th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>                                       
                        <tbody id="myTable">
                            @foreach ($Categories as $category)
                            <tr>
                                <td>{{$category['id']}}</td>
                                <td>{{$category['name']}}</td>
                                <td>{{$category['created_at']}}</td>
                                <td>{{$category['updated_at']}}</td>  
                                <td><button onclick="category_edit({{$category['id']}}, '{{route('category')}}')" class="btn btn-success">Sửa</button></td>
                                <td><button onclick="category_del({{$category['id']}}, '{{route('category')}}')" class="btn btn-danger">Xóa</button></td>
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
                    <h4 class="modal-title">Sửa/Thêm Danh Mục Sản Phẩm</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>              
                    <!-- Modal body -->
                    <div class="modal-body">
                        <form method="post" action="{{route('category')}}">
                            @csrf
                            <div class="form-group" style="display: none">
                            <input type="text" class="form-control" id="idcheck" name="id">
                            </div>
                            <div class="form-group">
                            <label for="name">Tên Danh Mục Sản Phẩm:</label>
                            <input type="text" class="form-control" id="categoryname" placeholder="Nhập tên danh mục" name="name">
                            </div>
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
    @if(session()->has('success'))
        <script>
            alert('{{session()->get('success')}}');
        </script>
    @endif
@endsection