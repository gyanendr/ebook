<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Books;
use Illuminate\Support\Facades\Validator;
use DB;
use Auth;
use Session;
use Mail;

class UserController extends Controller
{
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $userId = auth()->user()->id;
        $userName = auth()->user()->name;
        $books = Books::all();
        $usersOrder = Order::where(['user_id' => $userId, 'return_status' => 0])->get();
        return view('user.dashboard', compact('books', 'usersOrder', 'userName'));
    }


}
