<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Category2;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CategorySize;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use function GuzzleHttp\Promise\all;

class AdminController extends Controller
{   
    public function index()
    {
        return $this->user();
        // $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        // return view('admin.index',[
        //     'User' => Auth::user(),
        //     'Notifies' => $notifies
        // ]);
    }
    public function user()
    {   
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $users = User::all();
        return view('admin.user',[
            'Users' => $users,
            'Notifies' => $notifies
        ]);
    }
    public function user_actions(Request $request)
    {   
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $id = $request->get('id');
        $action = $request->get('action');
        if($action == 'del'){
            User::find($id)->delete();
            return True;
        }
        elseif($action == 'get'){
            $user = User::find($id);
            return json_encode($user);
        }
        elseif($action == 'register'){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'level' => 'required',
                'password' => [
                    'required',
                    'string',
                    'min:6',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&.]/', // must contain a special character
                ],
            ]);
            if( User::find($id) !=  null){
                $check = User::where('id', $id)->update([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'level' => $request->get('level'),
                ]);
                if($check){
                    return redirect("admin/user")->withSuccess('Cập nhật thành công');
                } 
            }
            else{
                $check = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'level' => $request->get('level'),
                ]);
                if($check){
                    return redirect("admin/user")->withSuccess('Thêm thành công');
                } 
            }
            return redirect("admin/user")->withSuccess('Lỗi');
        }
        else{
            return redirect("admin/user")->withSuccess('Lỗi');
        }
    }
    public function banner()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $banners = Banner::all();
        return view('admin.banner',[
            'Banners' => $banners,
            'Notifies' => $notifies
        ]);
    }
    public function banner_actions(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $id = $request->get('id');
        $action = $request->get('action');
        if($action == 'del'){   
            $itemDel = Banner::where('id', $id)->first();
            $image_path = public_path("/assets/banners/") .$itemDel['thumbnail'];
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            return Banner::find($id)->delete();
        }
        elseif($action == 'get'){
            $banner = Banner::find($id);
            return json_encode($banner);
        }
        elseif($action == 'register'){
            $request->validate([
                'name' => 'required',
                // 'file' => 'required',
            ]);
            $allowedfileExtension=['jpg','png'];   
            $path = public_path('assets/banners');
            $nameImg = "";
            if(Banner::find($id) !=  null){
                if($request->has('photo') && $request->file('photo') != null){
                    $file = $request->file('photo'); 
                    $extension = $file->extension();
                    $nameImg = time().rand(1,100).'.'.$extension;  
                    $checkExtension=in_array($extension,$allowedfileExtension);
                    if($checkExtension){
                        $file->move($path, $nameImg); 
                        $itemDel = Banner::where('id', $id)->first();
                        $image_path = public_path("/assets/banners/") .$itemDel['thumbnail'];
                        if(File::exists($image_path)) {
                            File::delete($image_path);
                        }
                    }
                    else{
                        return redirect("admin/banner")->withSuccess('Lỗi định dạng hình');
                    }      
                    $check = Banner::where('id', $id)->update([
                        'name' => $request->get('name'),
                        'thumbnail' => $nameImg,
                    ]);
                    if($check){
                        return redirect("admin/banner")->withSuccess('Cập nhật thành công');
                    } 
                }
                else{
                    $check = Banner::where('id', $id)->update([
                        'name' => $request->get('name'),
                    ]);
                    if($check){
                        return redirect("admin/banner")->withSuccess('Cập nhật thành công');
                    }
                }        
            }
            else{
                if($request->has('photo') && $request->file('photo') != null){
                    $file = $request->file('photo'); 
                    $extension = $file->extension();
                    $nameImg = time().rand(1,100).'.'.$extension;  
                    $checkExtension=in_array($extension,$allowedfileExtension);
                    if($checkExtension){
                        $file->move($path, $nameImg); 
                    }
                    else{
                        return redirect("admin/banner")->withSuccess('Lỗi định dạng hình');
                    }      
                }
                else{
                    return redirect("admin/banner")->withSuccess('Bạn chưa chọn ảnh');
                } 
                $check = Banner::create([
                    'name' => $request->get('name'),
                    'thumbnail' => $nameImg,
                ]);
                if($check){
                    return redirect("admin/banner")->withSuccess('Thêm thành công');
                }  
            }
            return redirect("admin/banner")->withSuccess('Lỗi');
        }
        else{
            return redirect("admin/banner")->withSuccess('Lỗi');
        }
    }
    public function vn_to_en($str=null)
    {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);
        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);
        $str = str_replace(" ", "-", $str);
        return strtolower($str);
    }
    public function category()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $categories = Category::all();
        return view('admin.category',[
            'Categories' => $categories,
            'Notifies' => $notifies
        ]);
    }
    public function category_actions(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $id = $request->get('id');
        $action = $request->get('action');
        if($action == 'del'){   
            return Category::find($id)->delete();
        }
        elseif($action == 'get'){
            $category = Category::find($id);
            return json_encode($category);
        }
        elseif($action == 'register'){
            $request->validate([
                'name' => 'required',
            ]);
            if( Category::find($id) !=  null){
                $check = Category::where('id', $id)->update([
                    'name' => $request->get('name'),
                    'tag' => $this->vn_to_en($request->get('name')).'-'.uniqid(),
                ]);
                if($check){
                    return redirect("admin/category")->withSuccess('Cập nhật thành công');
                }        
            }
            else{
                $check = Category::create([
                    'name' => $request->get('name'),
                    'tag' => $this->vn_to_en($request->get('name')).'-'.uniqid(),
                ]);
                if($check){
                    return redirect("admin/category")->withSuccess('Thêm thành công');
                }  
            }
            return redirect("admin/category")->withSuccess('Lỗi');
        }
        else{
            return redirect("admin/category")->withSuccess('Lỗi');
        }
    }
    public function category2()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $categories2 = Category2::all();
        for ($i=0; $i < count($categories2); $i++) { 
            $category = Category::find($categories2[$i]['category_id']);
            $categories2[$i]->category = $category;
        }
        $categories = Category::all();
        return view('admin.category2',[
            'Categories' => $categories,
            'Categories2' => $categories2,
            'Notifies' => $notifies
        ]);
    }
    public function category2_actions(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $id = $request->get('id');
        $action = $request->get('action');
        if($action == 'del'){   
            return Category2::find($id)->delete();
        }
        elseif($action == 'get'){
            $category = Category2::find($id);
            return json_encode($category);
        }
        elseif($action == 'register'){
            $request->validate([
                'name' => 'required',
                'category_id' => 'required',
            ]);
            if($request->get('category_id') == 'empty'){
                return redirect("admin/category2")->withSuccess('Lỗi');
            }
            if( Category2::find($id) !=  null){
                $check = Category2::where('id', $id)->update([
                    'name' => $request->get('name'),
                    'tag' => $this->vn_to_en($request->get('name')).'-'.uniqid(),
                    'category_id' => $request->get('category_id'),
                ]);
                if($check){
                    return redirect("admin/category2")->withSuccess('Cập nhật thành công');
                }        
            }
            else{
                $check = Category2::create([
                    'name' => $request->get('name'),
                    'tag' => $this->vn_to_en($request->get('name')).'-'.uniqid(),
                    'category_id' => $request->get('category_id'),
                ]);
                if($check){
                    return redirect("admin/category2")->withSuccess('Thêm thành công');
                }  
            }
            return redirect("admin/category2")->withSuccess('Lỗi');
        }
        else{
            return redirect("admin/category2")->withSuccess('Lỗi');
        }
    }
    public function size()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $sizes = CategorySize::all();
        return view('admin.size',[
            'Sizes' => $sizes,
            'Notifies' => $notifies
        ]);
    }
    public function size_actions(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $id = $request->get('id');
        $action = $request->get('action');
        if($action == 'del'){   
            return CategorySize::find($id)->delete();
        }
        elseif($action == 'get'){
            $category = CategorySize::find($id);
            return json_encode($category);
        }
        elseif($action == 'register'){
            $request->validate([
                'name' => 'required',
            ]);
            if( CategorySize::find($id) !=  null){
                $check = CategorySize::where('id', $id)->update([
                    'name' => $request->get('name'),
                ]);
                if($check){
                    return redirect("admin/size")->withSuccess('Cập nhật thành công');
                }        
            }
            else{
                $check = CategorySize::create([
                    'name' => $request->get('name'),
                ]);
                if($check){
                    return redirect("admin/size")->withSuccess('Thêm thành công');
                }  
            }
            return redirect("admin/size")->withSuccess('Lỗi');
        }
        else{
            return redirect("admin/size")->withSuccess('Lỗi');
        }
    }
    public function product()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $products = Product::all();
        for($i = 0; $i < sizeof($products); $i++) {
            $category = Category::find($products[$i]->category_id);
            $category2 = Category2::find($products[$i]->category2_id);
            $files = ProductDetail::where('product_id', $products[$i]->id)->get();
            $products[$i]->category = $category->name;
            $products[$i]->category2 = $category2->name;
            $products[$i]->files = $files;
        }
        $categories = Category::all();
        $categories2 = Category2::all();
        $sizes = CategorySize::all();
        return view('admin.product',[
            'Products' => $products,
            'Categories' => $categories,
            'Categories2' => $categories2,
            'Sizes' => $sizes,  
            'Notifies' => $notifies
        ]);
    }
    public function update_product(Request $request)
    {
        $allowedfileExtension=['jpg','png'];   
        $path = public_path('assets/products');
        $file_list = [];
        if($request->has('files')){
            foreach ($request->file('files') as $file) {         
                $extension = $file->getClientOriginalExtension();
                $name = time().rand(1,100).'.'.$extension;  
                $check=in_array($extension,$allowedfileExtension);
                if($check){
                    $file->move($path, $name); 
                    $file_list[] = $name; 
                }               
            }
        }       
        return $file_list;
    }
    public function product_actions(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $id = $request->get('id');
        $action = $request->get('action');
        if($action == 'del'){ 
            $product_detail_del = ProductDetail::where('product_id', $id)->get();
            foreach ($product_detail_del as $item) {
                $image_path = public_path("/assets/products/").$item['filename'];
                if(File::exists($image_path)) {
                    File::delete($image_path);
                }
            }  
            ProductDetail::where('product_id', $id)->delete();
            return Product::find($id)->delete();
        }
        elseif($action == 'get'){
            $product = Product::find($id);
            $categories2 = Category2::where('category_id',$product['category_id'])->get();
            $sizes = ProductSize::where('product_id', $id)->get();
            $product->categories2 = $categories2; 
            $product->sizes = $sizes;
            return json_encode($product);
        }
        elseif($action == 'get_by_category'){
            if($id == 'empty'){
                $products = Product::all();
            }
            else{
                $products = Product::where('category_id', $id)->get();
                
            }   
            for($i = 0; $i < sizeof($products); $i++) {
                $category = Category::find($products[$i]->category_id);
                $category2 = Category2::find($products[$i]->category2_id);
                $files = ProductDetail::where('product_id', $products[$i]->id)->get();
                $products[$i]->category = $category->name;
                $products[$i]->category2 = $category2->name;
                $products[$i]->files = $files;
            }        
            return json_encode($products);
        }
        elseif($action == 'get_category2'){
            if($id == 'empty'){
                $Categories2 = Category2::all();
            }
            else{
                $Categories2 = Category2::where('category_id', $id)->get();
                
            }          
            return json_encode($Categories2);
        }
        elseif($action == 'register'){
            $sizes_id = CategorySize::get('id');
            foreach ($sizes_id as $size_id) {
                $request->validate([
                    'size-'.$size_id['id'] => 'required',
                ]);
            }
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                'category_id' => 'required',
                'category2_id' => 'required',
                // 'thumbnail' => 'required',
                'content' => 'required',
            ]);
            if($request->get('category_id') == 'empty' || $request->get('category2_id') == 'empty'){
                return redirect("admin/product")->withSuccess('Lỗi');
            }
            $trend = ($request->has('trend')) ? 1 : 0;
            $file_list = $this->update_product($request);         
            if( Product::find($id) !=  null){
                $product = Product::where('id', $id)->update([
                    'name' => $request->get('name'),
                    'tag' => $this->vn_to_en($request->get('name')).'-'.uniqid(),
                    'price' => $request->get('price'),
                    'category_id' => $request->get('category_id'),
                    'category2_id' => $request->get('category2_id'),
                    'content' =>  $request->get('content'),
                    'trend' => $trend,
                ]);
                ProductSize::where('product_id', $id)->delete();
                foreach ($sizes_id as $size_id) {
                    $size = ProductSize::create([
                        'size_id' => $size_id['id'],
                        'product_id' => $id,
                        'quantity' => $request->get('size-'.$size_id['id']),
                    ]);
                }
                if($product){
                    if(count($file_list) > 0){
                        $product_detail_del = ProductDetail::where('product_id', $id)->get();
                        foreach ($product_detail_del as $item) {
                            $image_path = public_path("/assets/products/") .$item['filename'];
                            if(File::exists($image_path)) {
                                File::delete($image_path);
                                ProductDetail::where('product_id', $item['product_id'])->delete();
                            }
                        }
                        foreach ($file_list as $file){
                            $product_detail = ProductDetail::create([
                                'product_id'=>  $id,
                                'filename'  =>  $file,
                            ]);      
                        }
                    }                                   
                    return redirect("admin/product")->withSuccess('Cập nhật thành công');
                }        
            }
            else{
                if(count($file_list) <= 0){
                    return redirect("admin/product")->withSuccess('Bạn chưa chọn ảnh cho sản phẩm');
                } 
                $product = Product::create([
                    'name' => $request->get('name'),
                    'tag' => $this->vn_to_en($request->get('name')).'-'.uniqid(),
                    'price' => $request->get('price'),
                    'category_id' => $request->get('category_id'),
                    'category2_id' => $request->get('category2_id'),
                    'content' => $request->get('content'),
                    'trend' => $trend,
                ]);
                foreach ($sizes_id as $size_id) {
                    $size = ProductSize::create([
                        'size_id' => $size_id['id'],
                        'product_id' => $product['id'],
                        'quantity' => $request->get('size-'.$size_id['id']),
                    ]);
                }
                if($product){
                    foreach ($file_list as $file)
                    {       
                        $product_detail = ProductDetail::create([
                            'product_id'=>  $product['id'],
                            'filename'  =>  $file,
                        ]);      
                    }
                    return redirect("admin/product")->withSuccess('Thêm thành công');
                }  
            }
            return redirect("admin/product")->withSuccess('Lỗi');
        }
        else{
            return redirect("admin/product")->withSuccess('Lỗi');
        }
    }
    public function order()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $orders = Order::all();
        return view('admin.order',[
            'Orders' => $orders,
            'Notifies' => $notifies
        ]);
    }
    public function order_detail($id)
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        $order = Order::find($id); 
        if($order == null){
            return redirect("admin/order");
        }
        $products_list = OrderItem::where('order_id', $order->id)->get();
        
        for ($i=0; $i <count($products_list) ; $i++) { 
            $product = Product::where('id', $products_list[$i]->product_id)->get()->first();
            $files = ProductDetail::where('product_id', $products_list[$i]->product_id)->get();
            $size_name = CategorySize::find($products_list[$i]->size_id)->pluck('name')->first();
            $product->files = $files;
            $products_list[$i]->product = $product;
            $products_list[$i]->size_name = $size_name;
        }
        $order->products_list = $products_list;
        return view('admin.orderdetail',[
            'Order' => $order,
            'Notifies' => $notifies
        ]);
    }
    public function order_actions(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'action' => 'required',
        ]);
        $action = $request->get('action');
        $id = $request->get('id');
        if($action == 'processing'){
            $complete = Order::where('id', $id)->update([
                'status' => 'processing',
            ]);
            if($complete){
                return true;
            }
        }
        if($action == 'complete'){
            $complete = Order::where('id', $id)->update([
                'status' => 'completed',
                'notify' => 1,
            ]);
            if($complete){
                return true;
            }
        }
        if($action == 'cancel'){
            $complete = Order::where('id', $id)->update([
                'status' => 'decline',
                'notify' => 1,
            ]);     
            if($complete){
                $orders_item = OrderItem::where('order_id', $id)->get();
                foreach ($orders_item as $order_item) {
                    ProductSize::where('product_id', $order_item->product_id)->where('size_id', $order_item->size_id)->increment('quantity', $order_item->quantity); 
                }
                return true;
            }
        }
        return false;
    }
    public function notify()
    {
        $notifies = Order::where('notify', 0)->orderBy('id','DESC')->get();
        return view('admin.notify',[
            'Notifies' => $notifies
        ]);
    }
}
