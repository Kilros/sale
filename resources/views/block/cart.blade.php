<style>
#cartModal{
	position: fixed;
	top: 0;
	z-index: 999;
	overflow-x: hidden;
	overflow-x: auto;
	width: 100%;
	height: 100%;
	background: rgba(0, 0, 0, 0.5)
}
#modal-cart-close{
	border: none;
	font-size: 40px;
	font-weight: 500;
	background: none;
}
.table-image thead td{
  border: 0;
  color: #666;
  font-size: 0.8rem;
}
.table-image th{
  font-size: 0.8vw;
}
.table-image td{
  vertical-align: middle;
  text-align: center;
  width: 50px;
  font-size: 0.8vw;
}
.table-image td input{
	font-size: 0.8vw;
	width: 2vw;
}
.table-image td option{
	font-size: 0.8vw;
}
.table-image td.qty{
  max-width: 2rem;
}
@media screen and (max-width:720px){
	.table-image th{
		font-size: 1.8vw;
	}
    .table-image td{
		font-size: 1.8vw;
	}
	.table-image td.qty{
		font-size: 1.8vw;
	}
	.table-image td input{
		font-size: 1.8vw;
		width: 3vw;
	}
	.table-image td option{
		font-size: 1.8vw;
	}
}

.price {
  margin-left: 1rem;
}
#totalorder{
	font-size: 2vh;
}

.modal-footer {
  padding-top: 0rem;
}
#btn_order{
	background: #E06F18;
	border:none;
}
#close_modal_cart{
	background: black;
	border: none;
	height: 30px;
	width: 30px;
	font-size: 10px;
}
</style>

<div style="display:none" id="cartModal">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header border-bottom-0" style="padding-top: 0;">
				<h5 class="modal-title">
					Đơn hàng
				</h5>
				<button type="button" id="modal-cart-close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<table class="table table-image">
				<thead>
				<tr>
					<th style="width: 15%" scope="col"></th>
					<th scope="col">Sản phẩm</th>
					<th scope="col">Kích thước</th>
					<th scope="col">Giá</th>
					<th scope="col">Số lượng</th>
					<th scope="col">Số tiền</th>
					<th style="width: 2%"></th>
				</tr>
				</thead>
				<tbody id = "cart_list">
				</tbody>
			</table> 
			<div id="cart_total" class="d-flex justify-content-end">			
			</div>
			</div>
			<div class="modal-footer border-top-0 d-flex justify-content-right">
			{{-- <button type="button" id="modal-cart-close">Đóng</button> --}}
			<a href="{{route('order_custom')}}"><button type="button" id="btn_order" class="btn btn-success">Đặt hàng</button></a>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#modal-cart-close").click(function(){
			$('#cartModal').hide();		
			$('body').css({
				overflow: 'auto',
				height: 'auto'
			});
		});
		
	});
</script>
