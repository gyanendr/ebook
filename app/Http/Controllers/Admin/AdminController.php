<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Order;
use App\Models\Books;
use DB;
use Auth;
use Session;
use Mail;
use App;
class AdminController extends Controller
{

    public function __construct(){
        $this->middleware(['auth']); 
    }

    public function index(){
        $bookCount = Books::count();
        $usersCount = User::where(['role' => 2])->count();
        $categoryCount = Category::count();
        $orderCount = Order::count();
        return view('admin.dashboard', compact('bookCount', 'usersCount', 'categoryCount', 'orderCount'));
    }    

    public function usersListing(){
        $users = User::where('role', '!=', 1)->get();
        return view('admin.user.list', compact('users'));
    } 
    
    public function categoryListing(){
        $categories = Category::all(); 
        return view('admin.category.list', compact('categories'));
    }   

    public function addCategory(){
        return view('admin.category.add');
    }

    public function saveCategoryDetails( Request $request){
        $insert = Category::Create([
            'category_name' => $request->category_name,
       ]);

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Category details added successfully !');
            return redirect('admin/add-category');
        }

    } 

    public function editCategory($id){
        $getdetails = Category::where(['id' => $id])->first();
        return view('admin.category.edit', compact('getdetails'));
    }

    public function updateCategory( Request $request){
        $id = $request->id;
        $categoryName = $request->category_name;
        $updateArr = ['category_name' => $categoryName];
        $update = Category::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Category details updated successfully !');
            return redirect('admin/edit-category/'.$id);
        }
    }

    public function deleteCategory($id){
       $delete = Category::where('id', $id)->delete();
       if($delete){
            return redirect('admin/category-listing/');
       }
    }

    public function bookListing(){
        $categories = Category::where(['status' => 1])->get();
        $books = Books::where('book_status', '=', 1)->get();
        return view('admin.book.list', compact('books', 'categories'));
    }

    public function addbook(){
        $categories = Category::where(['status' => 1])->get();
        return view('admin.book.add', compact('categories'));
    }

    public function savebookDetails(Request $request){
        $bookImage = '';
        
        if ($files = $request->file('book_image')) {
           $bookImage = $files->getClientOriginalName();
           $files->move(public_path().'/bookImage/', $bookImage);
        }

        $insert = Books::Create([
            'book_name' => $request->book_name,
            'book_image' => $bookImage,
            'book_price' => $request->book_price,
            'categories_id' => $request->category,
        ]);

        if($insert){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Books details added successfully !');
            return redirect('admin/add-book');
        }
        
    }

    public function editbook($id){
        $getdetails = Books::where(['id' => $id])->first();
        $categories = Category::where(['status' => 1])->get();
        return view('admin.book.edit', compact('categories', 'getdetails'));
    }

    public function updatebook( Request $request){
      
        $bookImage = !empty($request->input('hiddenBookImage')) ? $request->input('hiddenBookImage') : '';
        
        if ($files = $request->file('book_image')) {
           $bookImage = $files->getClientOriginalName();
           $files->move(public_path().'/bookImage/', $bookImage);
        }
        $id = $request->id;

        $updateArr = [
            'book_name' => $request->book_name,
            'book_image' => $bookImage,
            'book_price' => $request->book_price,
            'categories_id' => $request->category,
        ];

        $update = Books::find($id)->update($updateArr);
        
        if($update){
            $request->session()->flash('message.level', 'success');
            $request->session()->flash('message.content', 'Books details updated successfully !');
            return redirect('admin/edit-book/'.$id);
        }
    }

    public function deleteBook($id){
        $delete = Books::where('id', $id)->delete();
        if($delete){
            return redirect('admin/book-listing/');
       }
    }


    public function orderListing(){
        $orders = Order::all();
        $users = User::where(['role' => 2])->get();
        $books = Books::all();
        return view('admin.order.list', compact('orders', 'users', 'books'));
    }

    public function updateProfile( Request $request){
        $userId = $request->input('userId');

        $input = request()->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users,email,'.$userId,
            'password' => 'required|min:8',
        ]);

        $updateArr =  [
            'name' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ];

       $update = User::where(['id' => $userId])->update($updateArr);
       if($update){
        $data = ['status' => 'success', 'msg' =>'Profile updated successfully !'];
        echo json_encode($data);
        exit();
       }
    }
    
//  divisions section start

    public function divisionsList(){
    	$userid = auth()->user()->id;
    	$data['getdetails'] = Divisions::where(['user_id' => $userid,'status' =>1])->get();
		return view('admin.divisions_list',$data);
    }

    public function adddivision(){
		return view('admin.add_division');
    }
    
      public function storeDivisionData(Request $request){
    	$input = request()->validate([
            'name' => 'required|max:255',
        ]);

		$userid = auth()->user()->id;
        $insert =  Divisions::create([
            'user_id' => $userid,
            'name' => $request->input('name'),
        ]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Division added successfully !');
        return redirect('admin/add-division');
    }

	public function editDivision($id){
    	$userid = auth()->user()->id;
        $result = Divisions::where(['id' => $id,'user_id' => $userid])->first();
        return view('admin.edit_division',compact('result'));
    }

 	public function updateDivisionData(Request $request){

        $id = $request->id;    	
		$input = request()->validate([
		            'name' => 'required|max:255',
		        ]);
		$updateArr =  [
	            'name' => $request->input('name'),
        	];

        $update = Divisions::where(['id' => $id])->update($updateArr);
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Division updated successfully !');
        return redirect('admin/edit-division/'.$id);
    }

    public function deleteDivisionData( Request $request){
        $id = $request->input('id');
        $udpateArr = ['status' => 0];
        $update = Divisions::where(['id'=>$id])->update($udpateArr);
        if($update){
            $data = ['status' => 'success', 'msg' => 'Division deleted successfully !'];
            echo json_encode($data);
            exit();
        }
    }

    //  divisions section end


    public function techniciansList(){
    	$userid = auth()->user()->id;
    	$data['getdetails'] = Technicians::where(['user_id' => $userid,'status' => 1])->get();
		return view('admin.technicians_list', $data);
    }

    public function addtechnician(){
		return view('admin.add_technician');
    }
    
      public function storeTechnicianData(Request $request){

        $technician_pic = '';
        
        if ($files = $request->file('technician_pic')) {
           $technician_pic = $files->getClientOriginalName();
           $files->move(public_path().'/technician_pic/', $technician_pic);
        }

    	$input = request()->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|unique:company_technicians',
            'phone_number' => 'required|max:255',

        ]);

		$userid = auth()->user()->id;
        $insert = Technicians::create([
           
            'user_id' => $userid,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'technician_pic' => $technician_pic,
        ]);

        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Technician added successfully !');
        return redirect('admin/add-technician');
    }

	public function editTechnician($id){
    	$userid = auth()->user()->id;
        $result = Technicians::where(['id' => $id,'user_id' => $userid])->first();
        return view('admin.edit_technician',compact('result'));
    }

 	public function updateTechnicianData(Request $request){
        $primary_id = $request->primary_id;

         $technician_pic = !empty($request->input('hiddenPic')) ? $request->input('hiddenPic') : '';
        
        if ($files = $request->file('technician_pic')) {
           $technician_pic = $files->getClientOriginalName();
           $files->move(public_path().'/technician_pic/', $technician_pic);
        }


        $input = request()->validate([
          
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|max:255|unique:company_technicians,email,'.$primary_id,
            'phone_number' => 'required|max:255',

        ]);
		$updateArr =  [
			
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'technician_pic' => $technician_pic
        ];

        $update = Technicians::where(['id' => $primary_id])->update($updateArr);
        $request->session()->flash('message.level', 'success');
        $request->session()->flash('message.content', 'Technician updated successfully !');
        return redirect('admin/edit-technician/'.$primary_id);
    }

    public function deleteTechnicianData( Request $request){
        $id = $request->input('id');
        $udpateArr = ['status' => 0];
        $update = Technicians::where(['id'=>$id])->update($udpateArr);
        if($update){
            $data = ['status' => 'success', 'msg' => 'Technician deleted successfully !'];
            echo json_encode($data);
            exit();
        }
    }

    

}