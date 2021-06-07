<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\Role;
use App\Models\Permission;

class ProductsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']); 
        $this->middleware(function ($request, $next){
            if(auth()->user()->role != 1){
                if ($this->checkPermisstion() == false){
                  return redirect('user/dashboard');
                  exit();
                }else{ return $next($request); }
            }else{ return $next($request); }
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private function checkPermisstion(){
        $userRole = auth()->user()->user_role;
        $getRoles = Role::find($userRole);
        $allpermisions =  json_decode($getRoles->permission);
        $sectionPer = Permission::where('name', 'LIKE', 'product')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list()
    {   
        $products = Products::select('id', 'title', 'category', 'sub_category', 'brand', 'current_stock', 'sale_price', 'purchase_price')->orderBy('id', 'desc')->paginate(10);
        return view('admin.products.list', compact('products'));
    } 

   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get(); 
        $categories = Category::select('id', 'category_name')->orderBy('category_name', 'asc')->get(); 
        $subcategories = SubCategory::select('id', 'sub_category_name')->orderBy('sub_category_name', 'asc')->get(); 
        return view('admin.products.add', compact('brands', 'categories', 'subcategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {  
        $latestData = Products::latest('id', 'desc')->select('id')->first();
        $lastId = ($latestData->id + 1);  
        
        $userId = auth()->user()->id;
        $role = auth()->user()->role;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);
        $imageArr = [];
        

        $input = request()->validate([
            'title' => 'required|unique:product|max:255',
            'description' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'brand' => 'required',
            'sale_price' => 'required',
            'purchase_price' => 'required',
            'current_stock' => 'required',
            'discount' => 'required',
            'seo_title' => 'required',
            'seo_descr' => 'required',
            'image' =>'required',
            'image.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
          $image = $request->file('image');
          $i = 0;
          foreach ($image as $files) {
              $i++;  
              $destinationPath = 'products/';
              $file_name = $lastId.'_'.$i.'.'.$files->getClientOriginalExtension();
              $files->move($destinationPath, $file_name);
              $imageArr[] = $file_name;
          }
        }

        $totalImage = !empty($imageArr) ? count($imageArr) : 0 ; 
        
        $insert = Products::Create([

            'title' => $request->title ,
            'description' => $request->description,
            'category' => $request->category,
            'sub_category' => $request->subcategory,
            'num_of_imgs' => $totalImage,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'shipping_cost' => $request->shipping_cost,
            'tag' => !empty($request->tags) ? implode(', ', $request->tags) : '',
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_descr,
            'brand' => $request->brand,
            'current_stock' => $request->current_stock,
            'discount' => $request->discount,
            'added_by' => $addedby

        ]);

        $insertId = $insert->id;
       
        
        if(isset($imageArr) && !empty($imageArr)){
            foreach ($imageArr as $row) {
                $insert = ProductImage::Create([
                    'product_id' => $insertId,
                    'image' => $row
                ]);
            }
        }

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Product details added successfully !');
            return redirect('products-list');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getDetails = Products::select('id', 'title', 'category','description','sub_category','sale_price','num_of_imgs','purchase_price','shipping_cost','tag','seo_title','seo_description','brand','current_stock','discount')->where('id', $id)->first();
        return view('admin.products.show', compact('getDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get(); 
        $categories = Category::select('id', 'category_name')->orderBy('category_name', 'asc')->get(); 
        $subcategories = SubCategory::select('id', 'sub_category_name')->orderBy('sub_category_name', 'asc')->get(); 
        $getDetails = Products::select('id', 'title', 'category','description','sub_category','sale_price','num_of_imgs','purchase_price','shipping_cost','tag','seo_title','seo_description','brand','current_stock','discount')->where('id', $id)->first();
        return view('admin.products.edit', compact('brands', 'categories', 'subcategories', 'getDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $userId = auth()->user()->id;
        $role = auth()->user()->role;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);
        $imageArr = [];
        $totalImage = $request->totalImage;

        $input = request()->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'brand' => 'required',
            'sale_price' => 'required',
            'purchase_price' => 'required',
            'current_stock' => 'required',
            'discount' => 'required',
            'seo_title' => 'required',
            'seo_descr' => 'required',
        ]);

        if ($request->hasFile('image')) {
          $image = $request->file('image');
          $i = $totalImage;
          foreach ($image as $files) {
              $i++;  
              $destinationPath = 'products/';
              $file_name = $id.'_'.$i.'.'.$files->getClientOriginalExtension();
              $files->move($destinationPath, $file_name);
              $imageArr[] = $file_name;
          }
        }

        $totalImage = !empty($imageArr) ? count($imageArr)+$totalImage : 0 ; 
        
        $updateArr = [

            'title' => $request->title ,
            'description' => $request->description,
            'category' => $request->category,
            'sub_category' => $request->subcategory,
            'num_of_imgs' => $totalImage,
            'sale_price' => $request->sale_price,
            'purchase_price' => $request->purchase_price,
            'shipping_cost' => $request->shipping_cost,
            'tag' => !empty($request->tags) ? implode(', ', $request->tags) : '',
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_descr,
            'brand' => $request->brand,
            'current_stock' => $request->current_stock,
            'discount' => $request->discount,
            'added_by' => $addedby

        ];

        $update = Products::find($id)->update($updateArr);
        
        if(isset($imageArr) && !empty($imageArr)){
            foreach ($imageArr as $row) {
                $insert = ProductImage::Create([
                    'product_id' => $id,
                    'image' => $row
                ]);
            }
        }

        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Product details added successfully !');
            return redirect()->route('products.edit', $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Products::findOrFail($id);
        $product->delete();
        $deleteImage = ProductImage::where('product_id', $id)->get();
        if(!empty($deleteImage)){
            foreach ($deleteImage as $image) {
            $path = public_path('products/'.$image);
              if(file_exists($path)){
                unlink($path);   
              }
            }
        }

        $deleteImageData = ProductImage::where('product_id', $id)->delete();
        return redirect('products-list');
    }

    public function getSubCategory(Request $request){
    	$categoryId = $request->categoryId;
    	$subcategories = Category::find($categoryId)->getSubCategory;
    	return json_encode($subcategories);
    }
}
