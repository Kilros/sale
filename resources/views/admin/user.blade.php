@extends('layouts.admin')
@section('title','Quản Trị - Người dùng')
@section('user','active')
@section('content')
    <div class="container-fluid">
                        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Danh sách tài khoản</h1>
        {{-- @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif --}}
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-primary" onclick="Insertuser()">Thêm Tài Khoản</button>
            </div>      
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 5%">ID</th>
                                <th style="width: 15%">Họ và tên</th>
                                {{-- <th>Mật Khẩu</th> --}}
                                <th style="width: 30%">E-mail</th>
                                <th style="width: 8%">Vai trò</th>
                                <th style="width: 20%">Ngày tạo</th>
                                <th style="width: 20%">Ngày cập nhật</th>
                                <th style="width: 5%"></th>
                                <th style="width: 5%"></th>
                            </tr>
                        </thead>                                       
                        <tbody id="myTable">
                            @foreach ($Users as $user)
                                <tr>
                                    <td>{{$user["id"]}}</td>
                                    <td>{{$user["name"]}}</td>
                                    <td>{{$user["email"]}}</td>
                                    @if ($user["level"] == 1)
                                    <td>Quản lý</td>
                                    @elseif ($user["level"] == 2)
                                    <td>Nhân viên</td>
                                    @endif         
                                    <td>{{$user["created_at"]}}</td>
                                    <td>{{$user["updated_at"]}}</td>
                                    <td><button type="button" onclick="user_edit({{$user['id']}}, '{{route('user')}}')" class="btn btn-success" >Sửa</button></td>  
                                    <td><button type="button" onclick="user_del({{$user['id']}}, '{{route('user')}}')" class="btn btn-danger">Xóa</button></td>
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
                <h4 class="modal-title">Sửa/Thêm Tài khoản</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{route('user')}}">
                        @csrf
                        <div class="form-group" style="display: none">
                            <input type="text" class="form-control" id="idcheck" name="id">
                        </div>
                        <div class="form-group">
                            <label for="username">Họ và tên:</label>
                            <input type="usename" class="form-control" id="username" placeholder="Nhập tài khoản" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Nhập địa chỉ email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu:</label>
                            <input type="text" class="form-control" id="password" placeholder="Nhập mật khẩu" name="password">
                        </div>
                        <div class="form-group">
                            <label for="price">Danh mục 1:</label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="empty">-- Lựa Chọn vai trò --</option>    
                                    <option value="1">Quản lý</option>
                                    <option value="2">Nhân viên</option>
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