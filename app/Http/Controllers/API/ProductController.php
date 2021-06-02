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
use App\Models\SubCategory;
use App\Models\ProductImage;
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
        $categories = Category::select('id', 'category_name', 'banner as thumbnail')->get();
        $success['categories'] =  $categories;
        return response()->json(['success' => $success], $this->successStatus);
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
        $getCartItems['cartItems'] = CartItem::select('product.title','cart.qty','cart.price', DB::raw('group_concat(product_Image.image) as thumbnail'))->
        leftJoin('product_Image', 'cart.product_id', '=', 'product_Image.product_id')->
        leftJoin('product', 'cart.product_id', '=', 'product.id')->
        groupBy('cart.product_id')->get();
        return response()->json(['success' => $getCartItems], $this->successStatus);
       
    }

}
