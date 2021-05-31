<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Brand;

class SubCategoryController extends Controller
{
    public function __construct(){
        $this->middleware(['auth']); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcategories = SubCategory::orderBy('id', 'desc')->paginate(10);
        return view('admin.subcategory.list', compact('subcategories'));
        
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
        return view('admin.subcategory.add', compact('brands', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $latestData = SubCategory::latest('id', 'desc')->select('id')->first();
        $lastId = ($latestData->id + 1);  
        $subcatImage = '';

         $input = request()->validate([
            'subcategory_name' => 'required|max:255',
            'category' => 'required',
            'brand' => 'required',
            'subcatImage' =>'required',
            'subcatImage.*' => 'mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        
        if ($files = $request->file('subcatImage')) {
           $subcatImage = $files->getClientOriginalExtension();
           $subcatImage = 'sub_category_'.$lastId.'.'.$subcatImage; 
           $files->move(public_path().'/subcategory/', $subcatImage);
        }

        $insert = SubCategory::Create([
            'sub_category_name' => $request->subcategory_name,
            'category' => !empty($request->category) ? $request->category : '' ,
            'brand' => json_encode($request->brand),
            'digital' => $request->digital,
            'banner' => $subcatImage,
        ]);

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Subcategory details added successfully !');
            return redirect('admin/subcategory');
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
        $getDetails = Subcategory::find($id);
        return view('admin.subcategory.show', compact('getDetails'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $getDetails = Subcategory::find($id);
        $brands = Brand::select('id', 'name')->orderBy('name', 'asc')->get();
        $categories = Category::select('id', 'category_name')->orderBy('category_name', 'asc')->get();
        return view('admin.subcategory.edit', compact('getDetails', 'brands', 'categories'));
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
        $subcatImage = !empty($request->input('hiddenImage')) ? $request->input('hiddenImage') : '';
        
        if ($files = $request->file('subcatImage')) {
           $subcatImage = $files->getClientOriginalExtension();
           $subcatImage = 'sub_category__'.$id.'.'.$subcatImage; 
           $path = public_path('subcategory/'.$subcatImage); 
           if(file_exists($path)){
             unlink($path);
           } 
           $files->move(public_path().'/subcategory/', $subcatImage);
        }
       
        $updateArr = [
            'sub_category_name' => $request->subcategory_name,
            'category' => !empty($request->category) ? $request->category : '' ,
            'brand' => json_encode($request->brand),
            'digital' => $request->digital,
            'banner' => $subcatImage,
        ];

        $update = Subcategory::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Subcategory details updated successfully !');
            return redirect()->route('subcategory.edit', $id);
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
