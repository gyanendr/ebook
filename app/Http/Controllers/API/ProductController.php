<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;
use App\Models\CartItem;
use App\Models\Offers;
use App\Models\Wishlist;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\Advertisement;
use App\Models\AdsCategory;
use DB;

class ProductController extends Controller
{
	public $successStatus = 200;
    
 
  
    public function index()
    {	
       
    	$orderBy = 'desc';

        $where = [];

        $where[] = ['product.category', '!=', ''];

        $categoryId = !empty($_GET['categoryId']) ? $_GET['categoryId'] : '' ;
        $brand = !empty($_GET['brand']) ? $_GET['brand'] : '' ;

        if(isset($categoryId) && !empty($categoryId)){
            $where[] = ['product.category', '=', $categoryId];            
        }

        if(isset($brand) && !empty($brand)){
            $where[] = ['product.brand', '=', $brand];            
        }

        $products = Products::select('product.id','product.title','brand.name as brand' ,'product.description', 'category.category_name', 'sub_category.sub_category_name', 'product.rating_num','product.sale_price','product.rating_total','product.current_stock','product.discount','product.purchase_price','product.shipping_cost',DB::raw('group_concat(product_Image.image) as thumbnail'))->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where($where)->
        groupBy('product.id')->
        orderBy('product.id', $orderBy)->
        get();
        $categories = Category::select('id', 'category_name', 'banner as thumbnail')->get();

        $success['products'] = $products; 
        $success['categories'] =  $categories;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function getProductDetails($id){
       $products = Products::select('product.id','product.title','brand.name as brand' ,'product.description', 'category.category_name', 'sub_category.sub_category_name', 'product.rating_num','product.sale_price','product.rating_total','product.current_stock','product.discount','product.purchase_price','product.shipping_cost',DB::raw('group_concat(product_Image.image) as thumbnail'))->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where('product.id', '=', $id)->first();
        $success['products'] = $products; 
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function categoryListing(){
        $categories = Category::select('id', 'category_name','banner as thumbnail')->get();

        $categoriesArr = [];
        foreach ($categories as $row) {
            $categoriesArr[] = $row;
            if(!empty($row->getSubCategory->get_sub_category)){
                $categoriesArr[] = $row->getSubCategory->get_sub_category ;
            }
           
        }
           
        $categories =  $categoriesArr;
        return response()->json(['categories' => $categories], $this->successStatus);
    }

    public function addToCart(Request $request){
        $userId = Auth::user()->id;
       
        $insert = CartItem::Create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'qty' => $request->qty,
            'price' => $request->price,
        ]);

        if($insert){
          return response()->json(['success'=>' Item added successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 

    }

    public function removeCartItem($id){
        
        $delete = CartItem::find($id)->delete();
        
        if($delete){
          return response()->json(['success'=>' Item removed successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
    }

    public function cartListing(){
        $userId = Auth::user()->id;
        $getCartItems['cartItems'] = CartItem::select('product.title','cart.qty','cart.price', DB::raw('group_concat(product_Image.image) as thumbnail'))->
        leftJoin('product_Image', 'cart.product_id', '=', 'product_Image.product_id')->
        leftJoin('product', 'cart.product_id', '=', 'product.id')->
        where('cart.user_id', $userId)->
        groupBy('cart.product_id')->get();
        return response()->json(['success' => $getCartItems], $this->successStatus);
       
    }

    public function wishListing(){
        $userId = Auth::user()->id;
        $getCartItems['wishListItems'] = Wishlist::select('product.title','product.sale_price', DB::raw('group_concat(product_Image.image) as thumbnail'))->
        leftJoin('product_Image', 'wishlist.product_id', '=', 'product_Image.product_id')->
        leftJoin('product', 'wishlist.product_id', '=', 'product.id')->
        where('wishlist.user_id', $userId)->
        groupBy('wishlist.product_id')->get();
        return response()->json(['success' => $getCartItems], $this->successStatus);
    }

    public function addToWishlist(Request $request){
        $userId = Auth::user()->id;
       
        $insert = Wishlist::Create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
        ]);

        if($insert){
          return response()->json(['success'=>' Item added in wishlist successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
    }

    public function removeWishItem($id){
        
        $delete = Wishlist::find($id)->delete();
        
        if($delete){
          return response()->json(['success'=>' Item removed successfully !.'],$this->successStatus);
        }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
    }  

    public function advertisementListing(){
        $advtListing['advtListing'] = Advertisement::select('blog.id','blog.title', 'blog.summery','blog_category.name as category','blog.author','blog.date','blog.description','blog.number_of_view','blog.addedBy','blog.status')
        ->leftJoin('blog_category', 'blog.blog_category', '=', 'blog_category.id')->
        orderBy('blog.id', 'desc')->get();
        return response()->json(['success' => $advtListing], $this->successStatus);
    }
    public function offerslisting(){
        $date = date('d-m-Y');
        $offers['offers'] = Offers::where('till', '>=', $date)->orderBy('id', 'desc')->get();
        return response()->json(['success' => $offers], $this->successStatus);
    }

    public function popularProducts(){
        $products['popularProducts'] = Products::select('product.id','product.title','brand.name as brand' ,'product.description', 'category.category_name', 'sub_category.sub_category_name', 'product.rating_num','product.sale_price','product.rating_total','product.current_stock','product.discount','product.purchase_price','product.shipping_cost',DB::raw('group_concat(product_Image.image) as thumbnail'), 'product.number_of_view')->
        leftJoin('product_Image', 'product.id', '=', 'product_Image.product_id')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where('product.number_of_view', '>', 20)->
        groupBy('product.id')->
        orderBy('product.number_of_view', 'desc')->
        get();
        return response()->json(['success' => $products], $this->successStatus);
    } 

    public function brandsListing(){
        $brands['brands'] = Brand::all();
        return response()->json(['success' => $brands], $this->successStatus);
    }  

}
