//---------USER-----------//
function user_del(id, url){
    var option=confirm('Bạn có chắc chắn muốn xóa tài khoản');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'del'
    }, function(data){ 
        if(data==1){
            window.location.assign(url);
        }                    
    });
};
function user_edit(id, url){
    $("#myModal").modal("show");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
       'id': id,
       'action' : 'get'
   }, function(data, status){  
        if(status){
            
            const dataselect = JSON.parse(data);
            console.log(dataselect);
            $("#idcheck").val(dataselect.id);
            $("#username").val(dataselect.name);
            $("#email").val(dataselect.email);
            $("#level").val(dataselect.level);
        }     
   });
};
function Insertuser(){
    $("#myModal").modal("show");
    $("#idcheck").val("emt");
    $("#username").val("")
    $("#password").val("")
    $("#email").val("")
    $("#level").val("empty")
};
//---------BANNER-----------//
function banner_del(id, url){
    var option=confirm('Bạn có chắc chắn muốn xóa banner');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id': id,
        'action' : 'del'
    }, function(data){   
        if(data==1){
            window.location.assign(url);
        }                    
    });
};
function banner_edit(id, url){
    $("#myModal").modal("show");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
       'id': id,
       'action' : 'get'
   }, function(data){  
        // console.log(data);
        const dataselect = JSON.parse(data);
        $("#idcheck").val(dataselect.id);
        $("#name").val(dataselect.name);
        // $("#thumbnail").val(dataselect.thumbnail);
        // $("#img_thumbnail").attr("src", dataselect.thumbnail);
   });
};
function Insertbanner(){
    $("#myModal").modal("show");
    $("#idcheck").val("emt");
    $("#name").val("")
    // $("#thumbnail").val("")
    // $("#img_thumbnail").attr("src", "");
};
//---------Category-----------//
function category_del(id, url){
    var option=confirm('Bạn có chắc chắn muốn xóa danh mục');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'del'
    }, function(data){   
        if(data==1){
            window.location.assign(url);
        }                    
    });
};
function category_edit(id, url){
    $("#myModal").modal("show");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
       'id': id,
       'action' : 'get'
   }, function(data){  
        const dataselect = JSON.parse(data);
        $("#idcheck").val(dataselect.id);
        $("#categoryname").val(dataselect.name);
   });
};
function Insertcategory(){
    $("#myModal").modal("show");
    $("#idcheck").val("emt");
    $("#categoryname").val("");
};
//---------Categor_2-----------//
function category2_del(id, url){
    var option=confirm('Bạn có chắc chắn muốn xóa danh mục');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'del'
    }, function(data){   
        if(data==1){
            window.location.assign(url);
        }                    
    });
};
function category2_edit(id, url){
    $("#myModal").modal("show");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
       'id': id,
       'action' : 'get'
   }, function(data){  
        const dataselect = JSON.parse(data);
        $("#idcheck").val(dataselect.id);
        $("#categoryname").val(dataselect.name);
        $("#category_id").val(dataselect.category_id);
   });
};
function category2_insert(){
    $("#myModal").modal("show");
    $("#idcheck").val("empty");
    $("#categoryname").val("");
    $("#category_id").val('empty');
};
//---------SIZE-----------//
function size_del(id, url){
    var option=confirm('Bạn có chắc chắn muốn xóa kích thước');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'del'
    }, function(data){   
        if(data==1){
            window.location.assign(url);
        }                    
    });
};
function size_edit(id, url){
    $("#myModal").modal("show");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
       'id': id,
       'action' : 'get'
   }, function(data){  
        const dataselect = JSON.parse(data);
        $("#idcheck").val(dataselect.id);
        $("#sizename").val(dataselect.name);
   });
};
function size_insert(){
    $("#myModal").modal("show");
    $("#idcheck").val("emt");
    $("#sizename").val("");
};
//---------Product-----------//
function product_del(id, url){
    var option=confirm('Bạn có chắc chắn muốn xóa sản phẩm');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'del'
    }, function(data){  
        if(data==1){
            window.location.assign(url)
        }                    
    });
};
function product_edit(id, url){
    $("#myModal").modal("show");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
       'id': id,
       'action' : 'get'
   }, function(data){  
        const dataselect = JSON.parse(data);
        $("#myModal").modal("show");
        $(".modal-title").html("Sửa Sản Phẩm")
        $("#idcheck").val(dataselect.id);
        $("#name").val(dataselect.name)
        $("#price").val(dataselect.price)
        $("#category_id").val(dataselect.category_id);

        $("#category2_id").empty();  
        $("#category2_id").append('<option value="empty">-- Lựa Chọn Danh Mục --</option>');
        dataselect.categories2.forEach(category2 => {
            $("#category2_id").append('<option value="'+category2.id+'">'+category2.name+'</option>');
        });   
        $("#category2_id").val(dataselect.category2_id);
        if (dataselect.trend) {
            $("#trend").prop('checked', true);
        } 
        else{
            $("#trend").prop('checked', false);
        }
        $(".size").val(0);
        if(dataselect.sizes.length > 0){
            dataselect.sizes.forEach(size => {
                $("#size-"+size.size_id).val(size.quantity);
            });
        }
        else{
            $(".size").val(0);
        }  
        tinymce.activeEditor.setContent(dataselect.content);
        // $("#product_content").val(dataselect.content);
   });
};
function product_insert(){
    $("#myModal").modal("show");
    $(".modal-title").html("Thêm Sản Phẩm")
    $("#idcheck").val("empty");
    $("#name").val("")
    $("#price").val("")
    $("#category_id").val('empty');
    $("#category2_id").val('empty');
    $("#trend").prop('checked', false);
    $(".size").val(0);
    tinymce.activeEditor.setContent("");
};

$(document).ready(function(){
    // $("#category_main_id").change(function(){
    //     var url = window.location;
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     });
    //     $.post(url, {
    //         'id' : $(this).val(),
    //         'action' : 'get_by_category'
    //     }, function(data){     
    //         const dataselect = JSON.parse(data);
    //         $("#myTable").empty();            
    //         dataselect.forEach(product => {
    //             var html = '<tr><td>'+product.id+'</td><td>';
    //             url_image = $('base[name="base-url"]').attr('href');
    //             product.files.forEach(file => {
    //                 html += '<img style="width: 33.3%" src="'+url_image+'/assets/products/'+file.filename+'">';
    //             });            
    //             html += '</td><td>'+product.name+'</td>';
    //             html += '<td>'+new Intl.NumberFormat('it-IT', { style: 'currency', currency: 'VND' }).format(product.price)+'</td>';
    //             html += '<td>'+product.category+'</td>';
    //             html += '<td>'+product.category2+'</td>'
    //             if(product.trend){
    //                 html += '<td>Có</td>'
    //             }
    //             else{
    //                 html += '<td>Không</td>'
    //             }       
    //             html += '<td>'+product.created_at+'</td>';
    //             html += '<td>'+product.updated_at+'</td>';
    //             html += '<td><button onclick="product_edit('+product.id+', '+"'"+url+"'"+')" class="btn btn-success">Sửa</button></td>';
    //             html += '<td><button onclick="product_del('+product.id+', '+"'"+url+"'"+')" class="btn btn-danger">Xóa</button></td></tr>';
    //             $("#myTable").append(html);
    //         });                         
    //     });
    // });
    $("#category_id").change(function(){
        var url = window.location;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post(url, {
            'id' : $(this).val(),
            'action' : 'get_category2'
        }, function(data){ 
            const dataselect = JSON.parse(data);
            $("#category2_id").empty();  
            $("#category2_id").append('<option value="empty">-- Lựa Chọn Danh Mục --</option>');
            dataselect.forEach(element => {
                $("#category2_id").append('<option value="'+element.id+'">'+element.name+'</option>');
            });           
        });
    });
  });
//---------Orders-----------//
function order_complete(id, url){
    var option=confirm('Bạn có chắc chắn muốn hoàn thành');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'complete'
    }, function(data){ 
        if(data==1){
            window.location.assign(window.location);
        } 
    });
};
function order_delivery(id, url){
    var option=confirm('Bạn có chắc chắn muốn vận chuyển');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'processing'
    }, function(data){ 
        if(data==1){
            window.location.assign(window.location);
        } 
    });
};
function order_cancel(id, url) {
    var option=confirm('Bạn có chắc chắn muốn hủy');
    if(!option){
        return;
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.post(url, {
        'id' : id,
        'action' : 'cancel'
    }, function(data){ 
        if(data==1){
            window.location.assign(window.location);
        } 
    });
}



