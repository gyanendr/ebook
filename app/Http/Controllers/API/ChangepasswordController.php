<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ChangepasswordController extends Controller
{
    //
    public function __construct()
    {
      $this->middleware('auth:api'); //If user is not logged in then he can't access this page
    }
 
    public function edit(Request $request,$id)
    {
        $users = User::find(Auth::user()->id);
        $users->name= $request->name;
        $users->email = $request->email;
        $users->mobile_num = $request->mobile_num;
        $users->address =  $request->address;
        if($users->save())
        {
          return response()->json(['status'=>' updated ']);
        }
        else{
            return response()->json(['status'=>' not  updated ']);
        }
     //   return view('backend.settings.updatepassword',compact('users'));
    }
 
 
    public function changepassword(Request $request, $id)
    {
        //$user_id= $id;
        //print_r($user_id);
        //die();

 
         $this->validate($request, [
 
        'oldpassword' => 'required',
        'newpassword' => 'required',
        ]);
 
 
 
       $hashedPassword = Auth::user()->password;
       echo $hashedPassword;
       die();
 
       if (\Hash::check($request->oldpassword , $hashedPassword )) {
 
         if (!\Hash::check($request->newpassword , $hashedPassword)) {
 
              $users =User::find(Auth::user()->id);
              $users->password = bcrypt($request->newpassword);
              User::where( 'id' , Auth::user()->id)->update( array( 'password' =>  $users->password));

              
             return response()->json(['status'=>'password updated successfuly']);
            }
 
            else{

                return response()->json(['status'=>'new password can not be the old password!']);
                  
                }
 
           }
 
          else{

            return response()->json(['status'=>'old password doesnt matched']);
               //session()->flash('message','old password doesnt matched ');
               //return redirect()->back();
             }
 
       }
}
