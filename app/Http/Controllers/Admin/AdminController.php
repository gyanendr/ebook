<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Products;
use App\Models\Brand;
use App\Models\SubCategory;
use DB;
use Auth;
use Session;
use Mail;
use App;
use Validator;
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
       return view('admin.user.add');
    }

    public function saveUserDetails(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:user',
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => 'required',
        ]);
    }
    

    

}