@extends('layouts.admin')
@section('title','Quản lí chi tiết đơn hàng')
@section('content')
@if ($Order !=null )
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Dơn Hàng</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 25%">Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Kích thước</th>
                            <th style="width: 12%">Số Lượng</th>
                            <th style="width: 12%">Giá/sp</th>
                            <th style="width: 12%">Giá</th>
                        </tr>
                    </thead>                                       
                    <tbody  id="myTable">
                        @foreach ($Order['products_list'] as $product)
                        <tr>
                            <td><img style="width: 100%" src="/assets/products/{{$product['product']['files'][0]['filename']}}"></td>                                    
                            <td>{{$product['product']['name']}}</td>
                            <td>{{$product['size_name']}}</td>
                            <td>{{$product['quantity']}}</td>
                            <td>{{number_format($product['product']['price'],0,',','.')}} VND</td>     
                            <td>{{number_format($product['price'],0,',','.')}} VND</td>                                                                        
                        </tr>
                        @endforeach    
                    </tbody>
                </table>
                <div class="">
                    <div>Mã đơn hàng: <span>{{$Order['order_number']}}</span></div>
                    <div>Họ và tên: <span>{{$Order['fullname']}}</span></div>
                    <div>Email: <span></span>{{$Order['email']}}</div>
                    <div>Số điện thoại: <span>{{$Order['phone_number']}}</span></div>
                    <div>Địa chỉ: <span>{{$Order['address']}}</span></div>
                    <div>Ghi chú: <span>{{$Order['notes']}}</span></div>
                    @if ($Order['status'] == 'pending')
                    <div>Trạng thái: <span>Xác nhận</span></div>
                    @elseif($Order['status'] == 'processing')
                    <div>Trạng thái: <span>Vận chuyển</span></div>
                    @elseif($Order['status'] == 'completed')
                    <div>Trạng thái: <span>Hoàn thành</span></div>
                    @else    
                    <div>Trạng thái: <span>Đã hủy</span></div>  
                    @endif                
                    <h5 id="totalorder">Tổng tiền: {{number_format($Order['total'],0,',','.')}} VND<span class="price text-success"></span></h5> 
                    @if ($Order['status'] == 'pending')
                        <button onclick="order_delivery({{$Order['id']}}, '{{route('order')}}')" class="btn btn-primary">Vận chuyển</button> 
                    @elseif ($Order['status'] == 'processing')
                        <button onclick="order_complete({{$Order['id']}}, '{{route('order')}}')" class="btn btn-primary">Hoàn Thành</button>
                    @endif
                    @if ($Order['status'] != 'decline' && $Order['status'] != 'completed')             
                        <button style="float: right;" onclick="order_cancel({{$Order['id']}}, '{{route('order')}}')" class="btn btn-danger">Hủy</button>  
                    @endif
                </div>               
            </div>
        </div>
    </div>
</div> 
@endif
@endsection