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

    public function orderNewBook(){
        $books = Books::all();
        $categories = Category::all();
        return view('user.order.create', compact('books', 'categories'));
    }

    public function borrowBook($id){
        return view('user.order.borrow', compact('id'));
    }

    public function orderBook( Request $request){
        $userId = auth()->user()->id;
        $id = $request->bookId;
        $insert = Order::Create([
            'book_id' => $request->bookId,
            'user_id' => $userId,
            'return_date' => strtotime($request->return_date),

        ]);

        if($insert){
            $updateArr = ['book_status' => 0];
            $update = Books::find($id)->update($updateArr);

            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Books Borrow successfully !');
            return redirect('user/order-new-book');
        }


    }

    public function returnBook($id){
        $getDetails = Order::where('id', $id)->first();
        $t = time();
        if($getDetails->return_date > $t){
            $bookId = $getDetails->book_id;
            $updateArr = ['book_status' => 1];
            $update = Books::find($bookId)->update($updateArr);
            $updateArr2 = ['return_status' => 1];
            $update2 = Order::find($id)->update($updateArr2);

            return redirect('user/order-new-book')->with('message', 'Books return successfully !');
        }else{
            return view('user.order.penalty', compact('id', 'getDetails'));
        }
    }

    public function payPenalty( Request $request){
        $id = $request->orderId;
        $bookId = $request->bookId;
        
        $updateArr = ['penalty' => $request->pay_penalty, 'return_status' => 1];
        $update = Order::find($id)->update($updateArr);

        $updateArr2 = ['book_status' => 1];
        $update2 = Books::find($bookId)->update($updateArr2);

        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Books return successfully !');
            return redirect('user/order-new-book');
        }
    }   


}
