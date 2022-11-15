@extends('layouts.admin')
@section('title','Quản Trị - Danh mục size')
@section('product','active')
@section('content')
    <div class="container-fluid">
                        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Kích Thước</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" onclick="size_insert()">Thêm Kích Thước</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">  
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 4%">ID</th>
                                <th>Tên Kích Thước</th>
                                <th>Ngày Tạo</th>
                                <th>Ngày Cập Nhật</th>
                                <th style="width: 5%"></th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>                                       
                        <tbody id="myTable">
                            @foreach ($Sizes as $size)
                            <tr>
                                <td>{{$size['id']}}</td>
                                <td>{{$size['name']}}</td>
                                <td>{{$size['created_at']}}</td>
                                <td>{{$size['updated_at']}}</td>  
                                <td><button onclick="size_edit({{$size['id']}}, '{{route('size')}}')" class="btn btn-success">Sửa</button></td>
                                <td><button onclick="size_del({{$size['id']}}, '{{route('size')}}')" class="btn btn-danger">Xóa</button></td>
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
                    <div class="modal-header">
                    <h4 class="modal-title">Sửa/Thêm Kích Thước</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    </div>              
                    <div class="modal-body">
                        <form method="post" action="{{route('size')}}">
                            @csrf
                            <div class="form-group" style="display: none">
                                <input type="text" class="form-control" id="idcheck" name="id">
                            </div>
                            <div class="form-group">
                                <label for="name">Tên Kích Thước:</label>
                                <input type="text" class="form-control" id="sizename" placeholder="Nhập tên kích thước" name="name">
                            </div>
                            <button type="submit" name="action" value="register" class="btn btn-primary">Lưu</button>
                        </form>
                    </div>             
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