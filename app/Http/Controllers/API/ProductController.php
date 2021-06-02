<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\ProductImage;


class ProductController extends Controller
{
	public $successStatus = 200;
    
    public function __construct()
    {
    	$this->middleware('guest:customer');
    }
  
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

        $products = Products::select('product.id','product.title','brand.name as brand' ,'product.description', 'category.category_name', 'sub_category.sub_category_name', 'product.rating_num','product.sale_price','product.rating_total','product.current_stock','product.discount','product.purchase_price','product.shipping_cost')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where($where)->
        orderBy('product.id', $orderBy)->
        get();
        $categories = Category::select('id', 'category_name')->get();

        $success['products'] = $products; 
        $success['categories'] =  $categories;
        return response()->json(['success' => $success], $this->successStatus);
    }

    public function getProductDetails($id){
       $products = Products::select('product.id','product.title','brand.name as brand' ,'product.description', 'category.category_name', 'sub_category.sub_category_name', 'product.rating_num','product.sale_price','product.rating_total','product.current_stock','product.discount','product.purchase_price','product.shipping_cost')->
        leftJoin('category', 'product.category', '=', 'category.id')->
        leftJoin('brand', 'product.brand', '=', 'brand.id')->
        leftJoin('sub_category', 'product.sub_category', '=', 'sub_category.id')->
        where('product.id', '=', $id)->first();
        $success['products'] = $products; 
        return response()->json(['success' => $success], $this->successStatus);
    }
}
