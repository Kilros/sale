@extends('layouts.admin')
@section('title','Quản Trị - Thông báo')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh sách đơn hàng đang chờ xử lý</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 3%">STT</th>
                            <th style="width: 15%">Mã ĐH</th>
                            <th>Tên Khách Hàng</th>
                            <th>SĐT</th>
                            <th>Ngày Đặt</th>
                            <th style="width: 10%">Trạng Thái</th>
                            <th style="width: 8%"></th>
                            {{-- <th style="width: 9%"></th>  --}}
                        </tr>
                    </thead>                                       
                    <tbody  id="myTable">
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($Notifies as $notify)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$notify['order_number']}}</td>
                                <td>{{$notify['fullname']}}</td>
                                <td>{{$notify['phone_number']}}</td>
                                <td>{{$notify['created_at']}}</td>
                                @if ($notify['status'] == 'pending')
                                <td>Xác thực</td> 
                                @elseif($notify['status'] == 'processing')
                                <td>Vận chuyển</td> 
                                @elseif($notify['status'] == 'completed')
                                <td>Hoàn thành</td> 
                                @else      
                                <td>Đã hủy</td>   
                                @endif           
                                <td><a href="/admin/orderdetail/{{$notify['id']}}" class="btn btn-success">Chi Tiết</a></td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection