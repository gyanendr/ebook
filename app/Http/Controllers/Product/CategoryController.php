<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Role;
use App\Models\Permission;
use App\Models\SubCategory;
use DB;
use Illuminate\Support\Facades\Auth;
class CategoryController extends Controller
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
        $sectionPer = Permission::where('name', 'LIKE', 'category')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list()
    {  
        $categories = Category::paginate(10);
        return view('admin.category.list', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $subcategories = SubCategory::select('id', 'sub_category_name', 'brand')->get();
        return view('admin.category.add', compact('subcategories', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data_brands = !empty($request->data_brands) ? implode(';;;;;;', $request->data_brands) : '' ;
        $tempData = array();
        $data_subdets = !empty($request->data_subdets) ? implode(',', $request->data_subdets) : '';
        $getSubCateData = SubCategory::whereIn('id', $request->data_subdets)->get();

        foreach ($getSubCateData as $row) {
            $brandsArr = json_decode($row->brand);
            $brandsIdsArr = implode(',', $brandsArr);
            if(!empty($brandsIdsArr)){
            $sql = "SELECT GROUP_CONCAT(CONCAT(id,':::',name)) as brands FROM `brand` WHERE id IN ($brandsIdsArr)";
            $brands = DB::SELECT($sql);
            $brands = !empty($brands) ? $brands[0]->brands : '' ;
            }
            $sql2 = "SELECT min(`sale_price`) as min_price , max(`sale_price`) as max_price FROM `product` WHERE`sub_category` = $row->id GROUP by `sub_category`";
            $getMinMax = DB::select($sql2);
            $min = !empty($getMinMax) ? $getMinMax[0]->min_price : '0';
            $max = !empty($getMinMax) ? $getMinMax[0]->max_price : '0';
            
            $dataArr = ['sub_id' => $row->id, 'sub_category_name' => $row->sub_category_name, 'min' => $min, 'max' => $max, 'brands' => $brands];
            $tempData[] = $dataArr;

        }
       
        $tempData = json_encode($tempData);
        $latestData = Category::latest('id', 'desc')->select('id')->first();
        $lastId = ($latestData->id + 1);    
        
        $categoryImage = '';
        
        if ($files = $request->file('category_image')) {
           $categoryImage = $files->getClientOriginalExtension();
           $categoryImage = 'category_'.$lastId.'.'.$categoryImage; 
           $files->move(public_path().'/category/', $categoryImage);
        }

        $insert = Category::Create([
            'category_name' => $request->category_name,
            'description' => !empty($request->description) ? $request->description : '' ,
            'digital' => $request->digital,
            'banner' => $categoryImage,
            'data_brands' => $data_brands,
            'data_subdets' => $tempData,
        ]);

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Category details added successfully !');
            return redirect('category-list');
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
        //
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
        $subcategories = SubCategory::select('id', 'sub_category_name')->orderBy('sub_category_name', 'asc')->get(); 
      

        $getDetails = Category::select('id', 'category_name','digital','data_vendors','description','banner','data_brands','data_subdets')->orderBy('category_name', 'asc')
        ->where('id', $id)
        ->first();

        $result=json_decode($getDetails->data_subdets);
        $sub_cat=[];
         foreach ($result as $key=>$value) 
         {        
            $sub_cat[] = $value->sub_id;
         }         

         $brand_str=explode(";;;;;;", $getDetails->data_brands);
         $brand_id=[];
        foreach ($brand_str as $value) {        
            $brand_id[] = strstr($value,":",true);
         
        }      
        return view('admin.category.edit', compact('brands', 'subcategories', 'getDetails','sub_cat','brand_id'));
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
        $data_brands = !empty($request->data_brands) ? implode(';;;;;;', $request->data_brands) : '' ;
        $tempData = array();
        $data_subdets = !empty($request->data_subdets) ? implode(',', $request->data_subdets) : '';
        $getSubCateData = SubCategory::whereIn('id', $request->data_subdets)->get();
     
        foreach ($getSubCateData as $row) {
            $brandsArr = json_decode($row->brand);
            $brandsIdsArr = implode(',', $brandsArr);
            $sql = "SELECT GROUP_CONCAT(CONCAT(id,':::',name)) as brands FROM `brand` WHERE id IN ($brandsIdsArr)";
            $brands = DB::SELECT($sql);
            $brands = !empty($brands) ? $brands[0]->brands : '' ;
            $sql2 = "SELECT min(`sale_price`) as min_price , max(`sale_price`) as max_price FROM `product` WHERE`sub_category` = $row->id GROUP by `sub_category`";
            $getMinMax = DB::select($sql2);
            $min = !empty($getMinMax) ? $getMinMax[0]->min_price : '0';
            $max = !empty($getMinMax) ? $getMinMax[0]->max_price : '0';
            
            $dataArr = ['sub_id' => $row->id, 'sub_category_name' => $row->sub_category_name, 'min' => $min, 'max' => $max, 'brands' => $brands];
            $tempData[] = $dataArr;

        }
        
        $tempData = json_encode($tempData);
              
        $categoryImage = '';
        
        if ($files = $request->file('category_image')) {
           $categoryImage = $files->getClientOriginalExtension();
           $categoryImage = 'category_'.$id.'.'.$categoryImage; 
           $files->move(public_path().'/category/', $categoryImage);
        }

        $updateArr = [
            'category_name' => $request->category_name,
            'description' => !empty($request->description) ? $request->description : '' ,
            'digital' => $request->digital,
            'banner' => $categoryImage,
            'data_brands' => $data_brands,
            'data_subdets' => $tempData,
        ];

        $update = Category::find($id)->update($updateArr);

        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Category details added successfully !');
            return redirect()->route('category.edit', $id);
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
        //
    }
}
