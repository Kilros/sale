<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\category2;
use App\Models\CategorySize;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductSize;
use Gloudemans\Shoppingcart\Facades\Cart;
use Eastwest\Json\Facades\Json;
use Illuminate\Support\Arr;
use Nette\Utils\Json as UtilsJson;
use PHPUnit\Util\Json as UtilJson;
use Psy\Util\Json as PsyUtilJson;

use function PHPSTORM_META\elementType;

class HomeController extends Controller
{
    public function index()
    {
        // if(Auth::check()){
        //     return view('dashboard',[
        //         'user' => Auth::user(),
        //     ]);
        // }
        $trends = Product::where('trend', 1)->orderBy('id','DESC')->get();
        $shirts = Product::where('category_id', 1)->skip(0)->take(10)->orderBy('id','DESC')->get();
        $pants = Product::where('category_id', 2)->skip(0)->take(10)->orderBy('id','DESC')->get();
        for($i = 0; $i < sizeof($trends); $i++) {
            $file_trends = ProductDetail::where('product_id', $trends[$i]->id)->get();
            $trends[$i]->files = $file_trends[0]->filename;
        }
        for($i = 0; $i < sizeof($shirts); $i++) {
            $file_shirts = ProductDetail::where('product_id', $shirts[$i]->id)->get();
            $shirts[$i]->files = $file_shirts;
        }
        for($i = 0; $i < sizeof($pants); $i++) {
            $file_pants = ProductDetail::where('product_id', $pants[$i]->id)->get();
            $pants[$i]->files = $file_pants;
        }
        
        $categories = category::all();
        for ($i=0; $i <count($categories) ; $i++) { 
            $category2= category2::where('category_id', $categories[$i]['id'])->get();
            $categories[$i]->category2 = $category2;
        }

        $banners = Banner::all();
        $cart = Cart::content();
        $cart_qty = 0;
        foreach ($cart as $item) {
            $cart_qty = $cart_qty + $item->qty; 
        }
        // dd($products);
        return view('home.index',[
            'Categories' => $categories,
            'Trends' => $trends,
            'Shirts' => $shirts,
            'Pants' => $pants,
            'Banners' => $banners,
            'Cart_qty' => $cart_qty,
        ]);
    }
    public function get_products(Request $request)
    {   
        $type = $request->get('type');
        if($type == 'shirt'){
            $number = $request->get('number');
            $products = Product::where('category_id', 1)->skip($number*10)->take(10)->get();
            for($i = 0; $i < sizeof($products); $i++) {
                $category = Category::find($products[$i]->category_id);
                $file_products = ProductDetail::where('product_id', $products[$i]->id)->get();
                $products[$i]->files = $file_products;
                $products[$i]->category = $category->name;
            }
            return json_encode($products);
        }
        else if($type == 'pants'){
            $number = $request->get('number');
            $products = Product::where('category_id', 2)->skip($number*10)->take(10)->get();
            for($i = 0; $i < sizeof($products); $i++) {
                $category = Category::find($products[$i]->category_id);
                $file_products = ProductDetail::where('product_id', $products[$i]->id)->get();
                $products[$i]->files = $file_products;
                $products[$i]->category = $category->name;
            }
            return json_encode($products);
        }
        else if($type == 'get_single'){
            $id = $request->get('id');
            $product = Product::where('id', $id)->get()->first();    
            if($product != null){
                $category = Category::find($product->category_id);
                $files = ProductDetail::where('product_id', $product->id)->get();
                $product->category = $category->name;
                $product->files = $files;
                $sizes = ProductSize::where('product_id', $product->id)->where('quantity', '>', 0)->get();
                for ($i=0; $i < count($sizes) ; $i++) { 
                    $size_name = CategorySize::find($sizes[$i]->size_id);
                    $sizes[$i]->size_name = $size_name;
                }
                $product->sizes = $sizes;
            }
            return json_encode($product);
        }
        else{
            return '{}';
        }

    }
    public function detail(Request $request, $tag)
    {
        $product = Product::where('tag', $tag)->get()->first();
        $category = Category::where('tag', $tag)->get()->first(); 
        if($product != null){
            $category = Category::find($product->category_id);
            $files = ProductDetail::where('product_id', $product->id)->get();
            $product->category = $category->name;
            $product->categoryTag = $category->tag;
            $product->files = $files;
            $cart = Cart::content();
            $cart_qty = 0;
            foreach ($cart as $item) {
                $cart_qty = $cart_qty + $item->qty; 
            }

            $categories = category::all();
            for ($i=0; $i <count($categories) ; $i++) { 
                $category2= category2::where('category_id', $categories[$i]['id'])->get();
                $categories[$i]->category2 = $category2;
            }
            $sizes = ProductSize::where('product_id', $product->id)->where('quantity', '>', 0)->get();
            for ($i=0; $i < count($sizes) ; $i++) { 
                $size_name = CategorySize::find($sizes[$i]->size_id);
                $sizes[$i]->size_name = $size_name;
            }
            return view('home.detail',[
                'Categories' => $categories,
                'Product' => $product,
                'Cart_qty' => $cart_qty,
                'Sizes' => $sizes,
            ]);
        }
        else if($category != null){
            return $this->category($request, $category);
        }
        else{
            return redirect('/');
        }
    }
    public function order()
    {
        $products = array();
        $cart = Cart::content();
        $cart_qty = 0;
        foreach ($cart as $item) {
            $product =  Product::where('id', $item->id)->get(['id', 'name', 'price'])->first();
            $file = ProductDetail::where('product_id', $product->id)->get();
            $product->file = $file;
            $product->qty = $item->qty;
            $product->subtotal = $item->subtotal;
            $size_name = CategorySize::where('id', $item->options->size)->pluck('name')->first();
            $product->size = $size_name;
            array_push($products, $product); 
            $cart_qty = $cart_qty + $item->qty;
        }
        $categories = category::all();
        for ($i=0; $i <count($categories) ; $i++) { 
            $category2= category2::where('category_id', $categories[$i]['id'])->get();
            $categories[$i]->category2 = $category2;
        }

        return view('home.order_custom',[
            'Categories' => $categories,
            'Cart_qty' => $cart_qty,
            'Products'=> $products,
        ]);
    } 
    public function category(Request $request, $category)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $sort = $request->has('sort') ? $request->get('sort') : 'new';
        // $category = Category::where('name', urldecode($category))->first();
        if($sort == 'hightolow'){
            $products = Product::where('category_id', $category->id)->skip(($page-1)*5)->take(5)->orderBy('price','DESC')->get(); 
            $count_page = ceil((Product::where('category_id', $category->id)->orderBy('price','DESC')->count())/5);
        }
        else if($sort == 'lowtohigh'){
            $products = Product::where('category_id', $category->id)->skip(($page-1)*5)->take(5)->orderBy('price')->get();
            $count_page = ceil((Product::where('category_id', $category->id)->orderBy('price')->count())/5);
        }
        else{
            $products = Product::where('category_id', $category->id)->skip(($page-1)*5)->take(5)->orderBy('id','DESC')->get(); 
            $count_page = ceil((Product::where('category_id', $category->id)->orderBy('id','DESC')->count())/5);
        }        
        for ($i=0; $i < count($products); $i++) { 
            $files = ProductDetail::where('product_id', $products[$i]->id)->get();
            $products[$i]->files = $files;
        } 
        $products->category = $category;  
        $cart = Cart::content();
        $cart_qty = 0;
        foreach ($cart as $item) {
            $cart_qty = $cart_qty + $item->qty; 
        }
        $categories = category::all();
        for ($i=0; $i <count($categories) ; $i++) { 
            $category2= category2::where('category_id', $categories[$i]['id'])->get();
            $categories[$i]->category2 = $category2;
        }     
        return view('home.category',[
            'Categories' => $categories,
            'Categories2' => null,
            'Cart_qty' => $cart_qty,
            'Products' => $products,
            'Page' => $page,
            'Count_page' => $count_page,
            'Sort' => $sort,
        ]);
        
    }
    public function category2(Request $request, $category, $category2)
    {
        $page = $request->has('page') ? $request->get('page') : 1;
        $sort = $request->has('sort') ? $request->get('sort') : 'new';
        $category = Category::where('tag', urldecode($category))->first();
        $category2 = Category2::where('tag', urldecode($category2))->first();
        if($category != null && $category2 != null){
            if($sort == 'hightolow'){
                $products = Product::where('category_id', $category->id)->where('category2_id', $category2->id)
                ->skip(($page-1)*5)->take(5)->orderBy('price','DESC')->get(); 
                $count_page = ceil((Product::where('category_id', $category->id)->where('category2_id', $category2->id)
                ->orderBy('price','DESC')->count())/5);
            }
            else if($sort == 'lowtohigh'){
                $products = Product::where('category_id', $category->id)->where('category2_id', $category2->id)
                ->skip(($page-1)*5)->take(5)->orderBy('price')->get();
                $count_page = ceil((Product::where('category_id', $category->id)->where('category2_id', $category2->id)
                ->orderBy('price')->count())/5);
            }
            else{
                $products = Product::where('category_id', $category->id)->where('category2_id', $category2->id)
                ->skip(($page-1)*5)->take(5)->orderBy('id','DESC')->get(); 
                $count_page = ceil((Product::where('category_id', $category->id)->where('category2_id', $category2->id)
                ->orderBy('id','DESC')->count())/5);
            }        
            for ($i=0; $i < count($products); $i++) { 
                $files = ProductDetail::where('product_id', $products[$i]->id)->get();
                $products[$i]->files = $files;
            } 
            $products->category = $category; 
            $products->category2 = $category2;  
            $cart = Cart::content();
            $cart_qty = 0;
            foreach ($cart as $item) {
                $cart_qty = $cart_qty + $item->qty; 
            }
            $categories = category::all();
            $categories2 = category2::all();
            for ($i=0; $i <count($categories) ; $i++) { 
                $category2= category2::where('category_id', $categories[$i]['id'])->get();
                $categories[$i]->category2 = $category2;
            }     
            
            return view('home.category',[
                'Categories' => $categories,
                'Categories2' => $categories2,
                'Cart_qty' => $cart_qty,
                'Products' => $products,
                'Page' => $page,
                'Count_page' => $count_page,
                'Sort' => $sort,
            ]);
        }
        else{
            return redirect('/');
        }
        
    }
    public function search(Request $request)
    {
        if($request->has('q')){
            $query = $request->get('q');
            $page = $request->has('page') ? $request->get('page') : 1;
            $sort = $request->has('sort') ? $request->get('sort') : 'new';
            if($sort == 'hightolow'){
                $products= Product::select("id", "name", 'tag', "price", "content", "created_at", "updated_at" , "trend", "category_id")
                    ->whereRaw("concat(name, ' ', content) like '%" .$query. "%' ")
                    ->skip(($page-1)*5)->take(5)->orderBy('price','DESC')->get();
                $count_page = ceil((Product::select("id", "name", 'tag', "price", "content", "created_at", "updated_at" , "trend", "category_id")
                    ->whereRaw("concat(name, ' ', content) like '%" .$query. "%' ")->orderBy('price','DESC')->count())/5);
            }
            else if($sort == 'lowtohigh'){
                $products= Product::select("id", "name", 'tag', "price", "content", "created_at", "updated_at" , "trend", "category_id")
                    ->whereRaw("concat(name, ' ', content) like '%" .$query. "%' ")
                    ->skip(($page-1)*5)->take(5)->orderBy('price')->get();
                $count_page = ceil((Product::select("id", "name", 'tag', "price", "content", "created_at", "updated_at" , "trend", "category_id")
                    ->whereRaw("concat(name, ' ', content) like '%" .$query. "%' ")->orderBy('price')->count())/5);
            }
            else{
                $products= Product::select("id", "name", 'tag', "price", "content", "created_at", "updated_at" , "trend", "category_id")
                    ->whereRaw("concat(name, ' ', content) like '%" .$query. "%' ")
                    ->skip(($page-1)*5)->take(5)->orderBy('id','DESC')->get();
                $count_page = ceil((Product::select("id", "name", 'tag', "price", "content", "created_at", "updated_at" , "trend", "category_id")
                    ->whereRaw("concat(name, ' ', content) like '%" .$query. "%' ")->orderBy('id','DESC')->count())/5);
            }       
            for($i = 0; $i < sizeof($products); $i++) {
                $file_products = ProductDetail::where('product_id', $products[$i]->id)->get();
                $products[$i]->files = $file_products;
            }
            $cart = Cart::content();
            $cart_qty = 0;
            foreach ($cart as $item) {
                $cart_qty = $cart_qty + $item->qty; 
            }
            $categories = category::all();
            for ($i=0; $i <count($categories) ; $i++) { 
                $category2= category2::where('category_id', $categories[$i]['id'])->get();
                $categories[$i]->category2 = $category2;
            }
            return view('home.search',[
                'Categories' => $categories,
                'Cart_qty' => $cart_qty,
                'Products' => $products,
                'Page' => $page,
                'Count_page' => $count_page,
                'Sort' => $sort,
                'Search' => $query,
            ]);
        }
        else{
            return redirect('/');
        }
    }
}
