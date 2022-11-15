@extends('layouts.home')
@section('title', 'Đặt hàng')
@section('content')
<div class="modal-content">
    <div class="notify_err" style="text-align: center;"><span id="notifyType_err"></span></div>
    <div class="modal-header border-bottom-0">
        <h2 style="text-align: center" class="modal-title" id="exampleModalLabel">
            Thông Tin Đơn Hàng
        </h2>
    </div>
    <div class="row">
        <div class="col-sm-6">  
            <h3 style="text-align: center; margin: 10px" class="modal-title">Danh sách sản phẩm</h3>
            <table class="table table-image">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Sản phẩm</th>
                        <th scope="col">Kích thước</th>
                        <th scope="col">Giá</th>
                        <th scope="col">Số lượng</th>
                        <th scope="col">Số tiền</th>
                    </tr>
                </thead>
                <tbody>
                @php
                    $total = 0;
                    $item_count = 0
                @endphp
                @foreach ($Products as $product)
                    <tr>
                        @php
                            $total += $product['subtotal'];
                            $item_count += $product['qty']
                        @endphp
                        <td class="w-25"><img src="/assets/products/{{$product['file'][0]['filename']}}" class="img-fluid img-thumbnail" alt="Sheep"></td>
                        <td>{{$product['name']}}</td>
                        <td>{{$product['size']}}</td>
                        <td>{{$product['price']}}</td>          
                        <td class="qty">{{$product['qty']}}</td>
                        <td>{{number_format($product['subtotal'],0,',','.')}} VND</td>                           
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="modal-footer border-top-0 d-flex justify-content-between">
                @if ($total != 0)
                    <h5>Tổng số sản phẩm: {{$item_count}} sản phẩm</h5>
                    <h5>Tổng tiền: {{number_format($total,0,',','.')}} VND<span class="price text-success"></span></h5>
                @else
                    <h5>Giỏ Hàng Trống<span class="price text-success"></span></h5>
                @endif			
            </div>
        </div>
        <div class="col-sm-6" style="padding: 30px">
            <form method="post" action="{{route('cart')}}">
                @csrf
                <input type="text" style="display: none" class="form-control" name="total" value="{{$total}}">
                <input type="text" style="display: none" class="form-control" name="item_count" value="{{$item_count}}">
                <div class="form-group">
                    <label for="fullname">Họ và tên:</label>
                    <input type="text" class="form-control" id="fullname" placeholder="Nhập họ và tên" name="fullname" required>
                </div>
                <div class="form-group">
                    <label for="phone_number">Số điện thoại:</label>
                    <input type="text" class="form-control" id="phone_number" placeholder="Nhập số điện thoại" name="phone_number" required>
                </div>
				<div class="form-group">
				    <label for="email">Email:</label>
					<input type="email" class="form-control" id="email" placeholder="Nhập địa chỉ email" name="email" required>
				</div>
                <div class="form-group">
                    <label for="address">Địa chỉ:</label>
                    <input type="text" class="form-control" id="address" placeholder="Nhập dịa chỉ" name="address" required>
                </div>
                <div class="form-group">
                    <label for="note">Chú thích:</label>
                    <textarea  class="form-control" id="notes" placeholder="Nhập chú thích nếu có" name="notes" cols="30" rows="5"></textarea>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-between">
                    <button type="submit" name="action" value="register" class="btn btn-success">Đặt hàng</button>
                </div>               
            </form>
        </div> 
    </div>
</div>
@if(session()->has('error'))
<script>
    $("#notifyType_err").html('{{session()->get('error')}}');
    setTimeout(function(){
        $("#notifyType_err").empty();
    },20000);
</script>
@endif
@endsection