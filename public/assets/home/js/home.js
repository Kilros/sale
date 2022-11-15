// san pham
function see_more_button(url, type){
    $( "#"+type+"_button" ).append('<div class="loader"></div>');
    $("#see_more_"+type).hide();
    $("#collapse_"+type).hide();
    setTimeout(() => {  
      var number = $("#see_more_"+type).attr("value");
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
      $.post(url, {
          'number': number,
          'type': type,
        }, function(data, status){
            if(status){
              const dataselect = JSON.parse(data)
              if(dataselect.length > 0){
                $(".loader").remove(); 
                // console.log(dataselect[0]);
                dataselect.forEach(product => {
                  $("#extensive_"+type+"_list").append('<div class="product"><div class="image"><a href="/'+product.tag+'"><img src="/assets/products/'+product.files[0]['filename']+'" class="product_img" style="width:100%" alt="Image"></a><div class="overlay_product"><button class="show_profile" value="'+product.id+'">Xem sơ</button><button type="button" onclick="add_cart('+product.id+')">Thêm vào<br>giỏ hàng</button></div></div><div class="sub"><a style="text-decoration: none" class="product_name" href="/'+product.tag+'" title="">'+product['name']+'</a><a style="text-decoration: none" class="product_price" href="/'+product.tag+'" title="">'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(product['price'])+'</a></div>');  
                });
                if(dataselect.length < 10){
                  // $("#see_more_button").hide();
                  $("#collapse_"+type).show();
                }
                else{
                  number++;
                  $("#see_more_"+type).attr("value", number);
                  $("#see_more_"+type).show();
                  $("#collapse_"+type).show();           
                }
              }
              else{
                // alert("Lỗi kết nối");
              }
            }
            else{
              // alert("Lỗi kết nối");
            }
        }); 
  }, 0); 
};
function collapse_button(type) {
    $("#see_more_"+type).attr("value", 1);
    $("#extensive_"+type+"_list").empty();
    $("#see_more_"+type).show();
    $("#collapse_"+type).hide();
}
//---------Cart-----------//
function show_cart() {
  $('#cartModal').show();
  $('.cartModal').css({
    overflow: 'auto',
  });
  $('body').css({
    overflow: 'hidden',
    height: '100%'
  });
  var url = window.location.protocol;
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.post(url+'/cart', {
      'action' : 'get'
  }, function(data){ 
      const dataselect = JSON.parse(data); 
      var total = 0, i = 0;
      var html;
      $("#cart_list").empty();
      dataselect.forEach(element => {
          total = total + element.subtotal;
          html = '<tr><td><img src="/assets/products/'+element.file[0]['filename']+'" class="img-fluid img-thumbnail" alt="Sheep"></td>';
          html += '<td>'+element.name+'</td><td><select onchange="cart_update_size('+element.id+','+element.size+','+i+')"  id="sizes-'+i+'">';
          element.sizes.forEach(item => {
            html += '<option value="'+item.size_id+'">'+item.name+'</option>'
          });
          html += '</select></td><td>'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.price)+'</td>';
          html += '<td class="qty"><input onchange="cart_update('+element.id+','+element.size+','+i+')" type="text" id="num_'+i+'" value="'+element.qty+'"></td>';
          html += '<td id="subtotal">'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.subtotal)+'</td>';
          html += '<td><button onclick="cart_del('+element.id+','+element.size+')" id="close_modal_cart" class="btn btn-danger">X</button></td></tr>';     
          $("#cart_list").append(html);  
          $('#sizes-'+i).val(element.size);
          i++;    
      });
      $('#cart_total').html('<h5 id="totalorder">Tổng tiền: '+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(total)+'<span class="price text-success"></span></h5>')
  });
}
function add_cart(product_id){
  // var url = window.location.host;
  var size = $('input[name=size]:checked').val();
  if(size == null){
    size = 'auto';
  }
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.post('/cart', {
      'product_id' : product_id,
      'size' : size,
      'action' : 'add'
  }, function(data){ 
      const dataselect = JSON.parse(data) 
      var total = 0;
      dataselect.forEach(element => {
          total = total + parseInt(element);
      });
      $("#numcart").html(total);
  });
};
function quick_purchase_cart(product_id) {
    add_cart(product_id);
    window.location.assign('/order');
  
}
function cart_del(product_id, size_id){
  // var url = window.location.protocol;
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.post('/cart', {
      'product_id': product_id,
      'size_id': size_id,
      'action':'del'
  }, function(data){
      const dataselect = JSON.parse(data); 
      var total = 0, qty_total = 0, i = 0;
      $("#cart_list").empty();
      dataselect.forEach(element => {
          total = total + element.subtotal;
          qty_total = qty_total + parseInt(element.qty);
          html = '<tr><td><img src="/assets/products/'+element.file[0]['filename']+'" class="img-fluid img-thumbnail" alt="Sheep"></td>';
          html += '<td>'+element.name+'</td><td><select onchange="cart_update_size('+element.id+','+element.size+','+i+')"  id="sizes-'+i+'">';
          element.sizes.forEach(item => {
            html += '<option value="'+item.size_id+'">'+item.name+'</option>'
          });
          html += '</select></td><td>'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.price)+'</td>';
          html += '<td class="qty"><input onchange="cart_update('+element.id+','+element.size+','+i+')" type="text" id="num_'+i+'" value="'+element.qty+'"></td>';
          html += '<td id="subtotal">'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.subtotal)+'</td>';
          html += '<td><button onclick="cart_del('+element.id+','+element.size+')" id="close_modal_cart" class="btn btn-danger">X</button></td></tr>';     
          $("#cart_list").append(html);  
          $('#sizes-'+i).val(element.size);
          i++; 
      });
      $("#numcart").html(qty_total);
      $('#cart_total').html('<h5 id="totalorder">Tổng tiền: '+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(total)+'<span class="price text-success"></span></h5>');
  });
};
function cart_update(product_id, size_id, pos){
  var qty=$("#num_"+pos).val();	
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $.post('/cart', {
  'product_id' : product_id,
  'size_id': size_id,
  'qty' : qty,
  'action' : 'update_qty'
  }, function(data){
      const dataselect = JSON.parse(data)
      var total = 0, qty_total = 0, i = 0;
      $("#cart_list").empty();
      dataselect.forEach(element => {
          total = total + element.subtotal;
          qty_total = qty_total + parseInt(element.qty);
          html = '<tr><td><img src="/assets/products/'+element.file[0]['filename']+'" class="img-fluid img-thumbnail" alt="Sheep"></td>';
          html += '<td>'+element.name+'</td><td><select onchange="cart_update_size('+element.id+','+element.size+','+i+')"  id="sizes-'+i+'">';
          element.sizes.forEach(item => {
            html += '<option value="'+item.size_id+'">'+item.name+'</option>'
          });
          html += '</select></td><td>'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.price)+'</td>';
          html += '<td class="qty"><input onchange="cart_update('+element.id+','+element.size+','+i+')" type="text" id="num_'+i+'" value="'+element.qty+'"></td>';
          html += '<td id="subtotal">'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.subtotal)+'</td>';
          html += '<td><button onclick="cart_del('+element.id+','+element.size+')" id="close_modal_cart" class="btn btn-danger">X</button></td></tr>';     
          $("#cart_list").append(html);  
          $('#sizes-'+i).val(element.size);
          i++; 
      });
      $("#numcart").html(qty_total);
      $('#cart_total').html('<h5 id="totalorder">Tổng tiền: '+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(total)+'<span class="price text-success"></span></h5>');
  });
};

function cart_update_size(product_id, size_id, pos){
  var size=$("#sizes-"+pos).val();
  $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  $.post('/cart', {
  'product_id' : product_id,
  'size_id': size_id,
  'size' : size,
  'action' : 'update_size'
  }, function(data){
      const dataselect = JSON.parse(data)
      var total = 0, qty_total = 0, i = 0;
      $("#cart_list").empty();
      dataselect.forEach(element => {
          total = total + element.subtotal;
          qty_total = qty_total + parseInt(element.qty);
          html = '<tr><td><img src="/assets/products/'+element.file[0]['filename']+'" class="img-fluid img-thumbnail" alt="Sheep"></td>';
          html += '<td>'+element.name+'</td><td><select onchange="cart_update_size('+element.id+','+element.size+','+i+')"  id="sizes-'+i+'">';
          element.sizes.forEach(item => {
            html += '<option value="'+item.size_id+'">'+item.name+'</option>'
          });
          html += '</select></td><td>'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.price)+'</td>';
          html += '<td class="qty"><input onchange="cart_update('+element.id+','+element.size+','+i+')" type="text" id="num_'+i+'" value="'+element.qty+'"></td>';
          html += '<td id="subtotal">'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(element.subtotal)+'</td>';
          html += '<td><button onclick="cart_del('+element.id+','+element.size+')" id="close_modal_cart" class="btn btn-danger">X</button></td></tr>';     
          $("#cart_list").append(html);  
          $('#sizes-'+i).val(element.size);
          i++; 
      });
      $("#numcart").html(qty_total);
      $('#cart_total').html('<h5 id="totalorder">Tổng tiền: '+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(total)+'<span class="price text-success"></span></h5>');
  });
}

// back home
var mybutton = document.getElementById("myBtn");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}


