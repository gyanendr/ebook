<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Role;
use App\Models\Permission;

class BrandController extends Controller
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
        $sectionPer = Permission::where('name', 'LIKE', 'brand')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }

    public function list(){
        $brands = Brand::paginate(10);
        return view('admin.brand.list',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = Brand::latest('id', 'desc')->select('id')->first();
        $lastId = ($latestData->id + 1);    
        
        $brandImage = '';
        
        if ($files = $request->file('brand_image')) {
           $brandImage = $files->getClientOriginalExtension();
           $brandImage = 'brand_'.$lastId.'.'.$brandImage; 
           $files->move(public_path().'/brand/', $brandImage);
        }

        $insert = Brand::Create([
            'name' => $request->brand_name,
            'description' => !empty($request->brand_desc) ? $request->brand_desc : '' ,
            'logo' => $brandImage,
        ]);

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Brand details added successfully !');
            return redirect('admin/brands');
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
        $getDetails = Brand::find($id);
        return view('admin.brand.show', compact('getDetails')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $getDetails = Brand::select('id', 'name', 'logo', 'description')->where('id',$id)->first();
        return view('admin.brand.edit', compact('getDetails'));
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
        $brandLogo = !empty($request->input('hiddenLogo')) ? $request->input('hiddenLogo') : '';
        
        if ($files = $request->file('brand_image')) {
           $brandImage = $files->getClientOriginalExtension();
           $brandLogo = 'brand_'.$id.'.'.$brandImage; 
           $path = public_path('brand/'.$brandLogo); 
           if(file_exists($path)){
             unlink($path);
           } 
           $files->move(public_path().'/brand/', $brandLogo);
        }
       
        $updateArr = [
            'name' => $request->brand_name,
            'description' => !empty($request->brand_desc) ? $request->brand_desc : '' ,
            'logo' => $brandLogo,
        ];

        $update = Brand::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Brand details updated successfully !');
            return redirect()->route('brands.edit', $id);
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
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('brands.index');
    }
}
