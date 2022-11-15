@extends('layouts.admin')
@section('title','Quản Trị - Danh mục sản phẩm 2')
@section('category','active')
@section('content')
    <div class="container-fluid">
                        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh Sách Danh Mục 2</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" onclick="category2_insert()">Thêm Danh Mục</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 4%">ID</th>
                                <th>Tên Danh Mục 2</th>
                                <th>Tên Danh Mục 1</th>
                                <th>Ngày Tạo</th>
                                <th>Ngày Cập Nhật</th>
                                <th style="width: 5%"></th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>                                       
                        <tbody id="myTable">
                            @foreach ($Categories2 as $category2)
                            <tr>
                                <td>{{$category2['id']}}</td>
                                <td>{{$category2['name']}}</td>
                                <td>{{$category2['category']['name']}}</td>
                                <td>{{$category2['created_at']}}</td>
                                <td>{{$category2['updated_at']}}</td>  
                                <td><button onclick="category2_edit({{$category2['id']}}, '{{route('category2')}}')" class="btn btn-success">Sửa</button></td>
                                <td><button onclick="category2_del({{$category2['id']}}, '{{route('category2')}}')" class="btn btn-danger">Xóa</button></td>
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
                        <form method="post" action="{{route('category2')}}">
                            @csrf
                            <div class="form-group" style="display: none">
                                <input type="text" class="form-control" id="idcheck" name="id">
                            </div>
                            <div class="form-group">
                                <label for="name">Tên Danh Mục 2:</label>
                                <input type="text" class="form-control" id="categoryname" placeholder="Nhập tên danh mục" name="name">
                            </div>
                            <div class="form-group">
                                <label for="price">Danh mục 1:</label>
                                <select class="form-control" id="category_id" name="category_id" required>
                                    <option value="empty">-- Lựa Chọn Danh Mục 1--</option>    
                                    @foreach ($Categories as $category)
                                        <option value="{{$category['id']}}">{{$category['name']}}</option>
                                    @endforeach  
                                </select>
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