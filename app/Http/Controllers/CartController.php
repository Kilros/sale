<?php

namespace App\Http\Controllers;

use App\Models\CategorySize;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\OrderItem;
use App\Models\ProductSize;
use Gloudemans\Shoppingcart\Facades\Cart;

// use Cart;

class CartController extends Controller
{  
    public function index(Request $request)
    {
       if ($request->isMethod('post')) {
         
            $data = array();   
            $request->validate([
                'action' => 'required',
            ]);
            $action = $request->get('action');   
            if($action == 'add'){
                $request->validate([
                    'product_id' => 'required',
                    'size' => 'required',
                ]);
                $product_id = $request->get('product_id');  
                $size = $request->get('size');  
                if($size == 'auto'){
                    $size = ProductSize::where('product_id', $product_id)->where('quantity', '>', 0)->pluck('size_id')->first();
                    if($size == null){
                        return false;
                    }  
                }               
                $product = Product::find($product_id);
                if($product != null){
                    Cart::add([
                        'id' => $product_id, 
                        'name' => $product->name, 
                        'qty' => 1, 
                        'price' => $product->price, 
                        'weight' => 550,
                        'options' => ['size' => $size],
                    ]);
                    $cart = Cart::content();
                    foreach ($cart as $item) {
                        array_push($data, $item->qty); 
                    }
                }
            } 
            if($action == 'get'){
                $cart = Cart::content();
                foreach ($cart as $item) {
                    $product =  Product::where('id', $item->id)->get(['id', 'name', 'price'])->first();
                    $file = ProductDetail::where('product_id', $product->id)->get();
                    $product->file = $file;
                    $product->qty = $item->qty;
                    $product->subtotal = $item->subtotal;
                    $product->size = $item->options->size;
                    $sizes = ProductSize::where('product_id', $item->id)->where('quantity', '>', 0)->get();            
                    for ($i=0; $i < count($sizes) ; $i++) { 
                        $name = CategorySize::where('id', $sizes[$i]['size_id'])->pluck('name')->first();
                        $sizes[$i]->name = $name;
                    }
                    $product->sizes = $sizes;
                    array_push($data, $product); 
                }
            } 
            if($action == 'del'){
                $product_id = $request->get('product_id'); 
                $size_id = $request->get('size_id'); 
                // $product = Product::find($product_id);
                // if($product != null){
                $rowId = Cart::content()->where('id', $product_id)->where('options.size', $size_id)->first()->rowId;
                Cart::remove($rowId);
                $cart = Cart::content();
                foreach ($cart as $item) {
                    $product =  Product::where('id', $item->id)->get(['id', 'name', 'price'])->first();
                    $file = ProductDetail::where('product_id', $product->id)->get();
                    $product->file = $file;
                    $product->qty = $item->qty;
                    $product->subtotal = $item->subtotal;
                    $product->size = $item->options->size;
                    $sizes = ProductSize::where('product_id', $item->id)->where('quantity', '>', 0)->get();
                    for ($i=0; $i < count($sizes) ; $i++) { 
                        $name = CategorySize::where('id', $sizes[$i]['size_id'])->pluck('name')->first();
                        $sizes[$i]->name = $name;
                    }
                    $product->sizes = $sizes;
                    array_push($data, $product); 
                }
                // }
            }
            if($action == 'update_qty'){
                $product_id = $request->get('product_id'); 
                $size_id = $request->get('size_id');
                $qty = $request->get('qty'); 
                $rowId = Cart::content()->where('id', $product_id)->where('options.size', $size_id)->first()->rowId;
                Cart::update($rowId, $qty);
                $cart = Cart::content();
                foreach ($cart as $item) {
                    $product =  Product::where('id', $item->id)->get(['id', 'name', 'price'])->first();
                    $file = ProductDetail::where('product_id', $product->id)->get();
                    $product->file = $file;
                    $product->qty = $item->qty;
                    $product->subtotal = $item->subtotal;
                    $product->size = $item->options->size;
                    $sizes = ProductSize::where('product_id', $item->id)->where('quantity', '>', 0)->get();
                    for ($i=0; $i < count($sizes) ; $i++) { 
                        $name = CategorySize::where('id', $sizes[$i]['size_id'])->pluck('name')->first();
                        $sizes[$i]->name = $name;
                    }
                    $product->sizes = $sizes;
                    array_push($data, $product); 
                }
            }
            if($action == 'update_size'){
                $product_id = $request->get('product_id'); 
                $size_id = $request->get('size_id');
                $size = $request->get('size'); 
                $rowId = Cart::content()->where('id', $product_id)->where('options.size', $size_id)->first()->rowId;
                Cart::update($rowId, [
                    'options' => ['size' => $size],
                ]);
                $cart = Cart::content();
                foreach ($cart as $item) {
                    $product =  Product::where('id', $item->id)->get(['id', 'name', 'price'])->first();
                    $file = ProductDetail::where('product_id', $product->id)->get();
                    $product->file = $file;
                    $product->qty = $item->qty;
                    $product->subtotal = $item->subtotal;
                    $product->size = $item->options->size;
                    $sizes = ProductSize::where('product_id', $item->id)->where('quantity', '>', 0)->get();
                    for ($i=0; $i < count($sizes) ; $i++) { 
                        $name = CategorySize::where('id', $sizes[$i]['size_id'])->pluck('name')->first();
                        $sizes[$i]->name = $name;
                    }
                    $product->sizes = $sizes;
                    array_push($data, $product); 
                }
            }
            if($action == 'register'){
                $request->validate([
                    'fullname' => 'required',
                    'phone_number' => 'required',
                    'email' => 'required|email',
                    'address' => 'required',
                    'item_count' => 'required',
                    'total' => 'required',
                ]);
                $carts = Cart::content();
                foreach ($carts as $cart) {
                    $size_num = ProductSize::where('product_id', $cart->id)->where('size_id', $cart->options->size)->pluck('quantity')->first();
                    if($size_num < $cart->qty){
                        return redirect()->back()->withError("Sản phẩm ".$cart->name." chỉ còn lại ".$size_num.". Bạn không thể mua ".$cart->qty." sản phẩm");
                    }
                }
                $order = Order::create([
                    'order_number'      =>  'ORD-'.strtoupper(uniqid()),                             
                    'fullname'          =>  $request->get('fullname'),
                    'phone_number'      =>  $request->get('phone_number'),
                    'email'             =>  $request->get('email'),
                    'address'           =>  $request->get('address'),                  
                    'notes'             =>  $request->get('notes'),
                    'item_count'        =>  $request->get('item_count'),
                    'total'             =>  $request->get('total'),
                    'status'            =>  'pending',
                ]); 
                if($order){
                    $items = Cart::content();
                    foreach ($items as $item)
                    {      
                        ProductSize::where('product_id', $item->id)->where('size_id', $item->options->size)->decrement('quantity', $item->qty); 
                        $orderItem = new OrderItem([
                            'product_id'    =>  $item->id,
                            'quantity'      =>  $item->qty,
                            'size_id'       =>  $item->options->size,
                            'price'         =>  $item->subtotal
                        ]);      
                        $order->items()->save($orderItem);
                    }
                    Cart::destroy();
                    return redirect('/')->withSuccess("Đặt hàng thành công");
                }

            }         
        }     
        return json_encode($data);     
    }
}
