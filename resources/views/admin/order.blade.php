@extends('layouts.admin')
@section('title','Quản lí đơn hàng')
@section('order','active')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh Sách Dơn Hàng</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">   
            <form style="width: 50%;" action="./Admin/Orders" method="POST">
                <select class="form-control" id="order_status">
                    <option value="">-- Lựa Chọn Dơn Hàng --</option>    
                    <option value="Xác nhận">Chờ xác nhận</option>
                    <option value="Vận chuyển">Đang vận chuyển</option>
                    <option value="Hoàn thành">Đã hoàn thành</option>
                    <option value="Đã hủy">Đã hủy</option>
                </select>
            </form>
        </div>
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
                        @foreach ($Orders as $order)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$order['order_number']}}</td>
                                <td>{{$order['fullname']}}</td>
                                <td>{{$order['phone_number']}}</td>
                                <td>{{$order['created_at']}}</td>
                                @if ($order['status'] == 'pending')
                                <td>Xác nhận</td> 
                                @elseif($order['status'] == 'processing')
                                <td>Vận chuyển</td> 
                                @elseif($order['status'] == 'completed')
                                <td>Hoàn thành</td> 
                                @else      
                                <td>Đã hủy</td>   
                                @endif           
                                <td><a href="/admin/orderdetail/{{$order['id']}}" class="btn btn-success">Chi Tiết</a></td>
                                {{-- <td>
                                    @if ($order['status'] == 'completed')
                                    Hoàn thành
                                    @elseif($order['status'] == 'decline')
                                    Đã hủy
                                    @else
                                    <button  onclick="order_complete({{$order['id']}}, '{{route('order')}}')" class="btn btn-primary disable">Hoàn Thành</button>
                                    @endif
                                </td>                                                   --}}
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
<script>
    $(document).ready(function(){
        $("#order_status").change(function(){
            var input, filter, table, tr, td, i, txtValue;
            input = $(this).val();     
            filter = input.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[5];          
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
@endsection