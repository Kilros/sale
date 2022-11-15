@extends('layouts.admin')
@section('title','Quản Trị - Sản phẩm')
@section('product','active')
@section('content')
<div class="container-fluid">
                    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Sản Phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">   
            <form style="width: 50%; float: left;" action="./Admin/Product" method="POST">
                <select style="float: left;" class="form-control" id="category_main_id" name="category_id">
                    <option value="">-- Lựa Chọn Danh Mục --</option>   
                    @foreach ($Categories as $category)
                        <option value="{{$category['name']}}">{{$category['name']}}</option>
                    @endforeach 
                </select>
            </form>
            <button style="margin-left: 10px; width: 80px; display: block; float: left;" type="button" class="btn btn-primary" onclick="product_insert()">Thêm</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 4%">ID</th>
                            <th style="width: 30%">Ảnh</th>
                            <th style="width: 15%">Tên Sản Phẩm</th>
                            <th style="width: 10%">Giá Sản Phẩm</th>
                            <th style="width: 15%">Danh Mục 1</th> 
                            <th style="width: 15%">Danh Mục 2</th>        
                            <th style="width: 5%">Xu Hướng</th>                    
                            <th>Ngày Tạo</th>
                            <th>Ngày Cập Nhật</th>
                            <th style="width: 5%"></th>
                            <th style="width: 5%"></th> 
                        </tr>
                    </thead>                                       
                    <tbody id="myTable">
                        @foreach ($Products as $product)
                            <tr>
                                <td>{{$product['id']}}</td>
                                <td>
                                    @foreach ($product['files'] as $file)
                                        <img style="width: 33.3%; float:left" src="{{ asset('assets/products/'.$file['filename']); }}">
                                    @endforeach                               
                                </td>
                                <td>{{$product['name']}}</td>                                      
                                <td>{{number_format($product['price'],0,',','.')}} VND</td>
                                <td>{{$product['category']}}</td>
                                <td>{{$product['category2']}}</td>
                                @if ($product['trend'])
                                    <td>Có</td>
                                @else
                                    <td>Không</td>
                                @endif                             
                                <td>{{$product['created_at']}}</td>
                                <td>{{$product['updated_at']}}</td>   
                                <td><button onclick="product_edit({{$product['id']}}, '{{route('product')}}')" class="btn btn-success">Sửa</button></td>
                                <td><button onclick="product_del({{$product['id']}}, '{{route('product')}}')" class="btn btn-danger">Xóa</button></td>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">        
                <!-- Modal Header -->
                <div class="modal-header">
                <h4 class="modal-title">Sửa/Thêm Danh Mục Sản Phẩm</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
                </div>              
                <!-- Modal body -->
                <div class="modal-body">
                    <form method="post" action="{{route('product')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group" style="display: none">
                            <input type="text" class="form-control" id="idcheck" name="id" required>
                        </div>
                        <div class="form-group">
                            <label for="title">Tên Sản Phẩm:</label>
                            <input type="text" class="form-control" id="name" placeholder="Nhập tên sản phẩm" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Giá:</label>
                            <input type="text" class="form-control" id="price" placeholder="Nhập giá sản phẩm" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Danh mục 1:</label>
                            <select class="form-control" id="category_id" name="category_id" required>
                                <option value="empty">-- Lựa Chọn Danh Mục --</option>    
                                @foreach ($Categories as $category)
                                    <option value="{{$category['id']}}">{{$category['name']}}</option>
                                @endforeach  
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="price">Danh mục 2:</label>
                            <select class="form-control" id="category2_id" name="category2_id" required>
                                <option value="empty">-- Lựa Chọn Danh Mục --</option>  
                                @foreach ($Categories2 as $category2)
                                    <option value="{{$category2['id']}}">{{$category2['name']}}</option>
                                @endforeach   
                            </select>
                        </div>
                        <div class="form-group">                           
                            <input type="checkbox"  id="trend" name="trend" value="1">
                            <label for="trend" class="checkbox-inline">Trend</label>
                        </div>
                        @foreach ($Sizes as $size)
                        <div class="form-group">    
                            <label for="price">Kích thước - {{$size['name']}}:</label>
                            <input type="text" class="size form-control"  id="size-{{$size['id']}}" placeholder="Nhập giá kích thước" name="size-{{$size['id']}}" required>                       
                        </div>
                        @endforeach
                        {{-- <div class="form-group">
                            <label for="thumbnail">Thumbnail:</label>
                            <input type="text" onchange="Updatethumbnail()" class="form-control" id="thumbnail" placeholder="Nhập thumbnail" name="thumbnail" required>
                        </div> --}}
                        <div class="form-group">
                            <label for="thumbnail">Ảnh</label>
                            <input type="file" onchange="Updatethumbnail()" class="form-control" id="thumbnail" name="files[]" value="{{ isset($doc) ? $doc['file'] : '' }}" multiple>
                        </div>
                        {{-- <img src="" id="img_thumbnail" style="width: 50%"> --}}
                        <div class="form-group">
                            <label for="notes">Nội Dung:</label>
                            <textarea  class="form-control" id="product_content" placeholder="Nhập địa nội dung sản phẩm" name="content" cols="30" rows="10"></textarea>
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
<script>
    $(document).ready(function(){
        $("#category_main_id").change(function(){
            var input, filter, table, tr, td, i, txtValue;
            input = $(this).val();     
            filter = input.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];          
                if (td) {                 
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {   
                        tr[i].style.display = "";
                        // break;
                    } else {
                        tr[i].style.display = "none";
                    }
                }                 
            }
        });
    }); 
</script>
@if(session()->has('success'))
<script>
    alert('{{session()->get('success')}}');
</script>
@endif
@endsection