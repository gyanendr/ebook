<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use App\Models\Permission;

class BlogController extends Controller
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
        $sectionPer = Permission::where('name', 'LIKE', 'blog')->select('id')->first();
        $id = $sectionPer->id;
        if(!in_array($id, $allpermisions)){  return false; }else{ return true; }
    }
    
    public function list()
    {
        $blogs = Blog::paginate(10);
        return view('admin.blog.list', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adsCategories = BlogCategory::select('id', 'name')->orderBy('name', 'asc')->get();
        return view('admin.blog.add', compact('adsCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userId = auth()->user()->id;
        $role = auth()->user()->role;
        $addedby = json_encode(['type' => 'admin', 'id' => $userId]);


        $validator = Validator::make($request->all(), [
            'title' =>        'required',
            'author'=>       'required',
            'summery' =>      'required',
            'description' =>  'required',
            'blog_category' => 'required'
        

        ]);
       
       if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                 ->withInput();
        }

        $insert = Blog::Create([
            'title' => $request->title,
            'author' => $request->author,
            'summery' => $request->summery,
            'description' => $request->description,
            'blog_category' => $request->blog_category,
            'addedBy'=> $addedby
        ]);

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Blog detail added successfully !');
            return redirect()->back();
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
        $blogcategories = BlogCategory::select('id', 'name')->orderBy('name', 'asc')->get(); 
        $getDetails = Blog::select('id','title','summery','description','blog_category','author')->orderBy('title', 'asc')->where('id', $id)->first();
       
        return view('admin.blog.edit', compact('getDetails','blogcategories'));
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
        $addedby = json_encode(['type' =>'admin', 'id' => $userId]);
        

          $validator = Validator::make($request->all(), [
            'title' =>        'required',
            'author'=>       'required',
            'summery' =>      'required',
            'description' =>  'required',
            'blog_category' => 'required'
        

        ]);
       
       if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                 ->withInput();
        }

        $updateArr = [
            'title' => $request->title,
            'author' => $request->author,
            'summery' => $request->summery,
            'description' => $request->description,
            'blog_category' => $request->blog_category,
            'addedBy' => $addedby,
            
        ];

        $update = Blog::find($id)->update($updateArr);

        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Blog details updated successfully !');
            return redirect()->route('blog.edit', $id);
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
        $ads = Blog::find($id);
        $ads->delete();
        return redirect('blog-list')->with('message', 'Blog Deleted successfully!');;
    }

    public function blogCategory(){
        $adsCategories = BlogCategory::paginate(10);
        return view('admin.blog.adslisting', compact('adsCategories'));
    } 

}
