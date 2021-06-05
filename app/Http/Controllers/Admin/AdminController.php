<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Role;
use App\Models\Products;
use App\Models\Brand;
use App\Models\SubCategory;
use DB;
use Auth;
use Session;
use Mail;
use App;
use Illuminate\Support\Facades\Validator;
class AdminController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']); 
    }

    public function index(){
        $productCount = Products::count();
        $usersCount = User::where(['role' => 2])->count();
        $categoryCount = Category::count();
        $orderCount = Order::count();
        return view('admin.dashboard', compact('productCount', 'usersCount', 'categoryCount', 'orderCount'));
    }    

    public function usersListing(){
        $users = User::where('role', '!=', 1)->get();
        return view('admin.user.list', compact('users'));
    } 

    public function addUserForm(){
       $roles = Role::orderBy('name', 'asc')->get();
       return view('admin.user.add', compact('roles'));
    }

    public function saveUserDetails(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => ['required', 'string', 'min:8'],
            'user_role' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = User::Create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_num' => $request->phone,
            'address' => $request->address,
            'user_pass' => $request->password,
            'role' => 2,
            'status' => $request->status,
            'user_role' => $request->user_role,
        ]);

        if($insert){
            return redirect('admin/user-listing')->with('message', 'User Registered Successfully!');
        }

    }

    public function editUser($id){
        $roles = Role::all();
        $getDetails = User::find($id);
        return view('admin.user.edit', compact('getDetails', 'roles'));
    }

    public function updateUserDetails(Request $request){
        $id = $request->userId;
        $user = User::find($id);
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255','unique:users,email,'.$user->id.',id'],
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => ['required', 'string', 'min:8'],
            'user_role' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $updateArr = [
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_num' => $request->phone,
            'address' => $request->address,
            'user_pass' => $request->password,
            'role' => 2,
            'status' => $request->status,
            'user_role' => $request->user_role,
        ];
        $update = User::find($id)->update($updateArr); 

        if($update){
            return redirect('admin/edit-user/'.$id)->with('message', 'User Details Updated Successfully!');
        }
    }
   
    

    

}