<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\ContactMessage;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Validator;
use Mail;

class UserController extends Controller
{
    

    public $successStatus = 200;
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email|unique:user',
            'phone'=> ['required', 'numeric', 'min:10'],
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
        }
        $input = $request->all();
       
        $input['password'] = bcrypt($input['password']);
        $user = Customer::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['userInfo'] =  $user;
        Auth::login($user);
        return response()->json(['success'=>$success], $this->successStatus); 
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function login(Request $request){
        if(Auth::guard('customer')->attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::guard('customer')->user();
            $success['token'] =$user->createToken('MyApp')->accessToken; 
            $success['userInfo'] =  $user;
            return response()->json(['success' => $success], $this->successStatus);
        } 
        else{ 
            return response()->json(['error'=>'Wrong Credentials please try again'], 401); 
        } 
    }

    public function userdetails() { 
        $user = Auth::user(); 
        return response()->json(['userInfo' => $user], $this->successStatus); 
    } 

    public function logout()
    {

      if (Auth::user()) {
        $user = Auth::user()->token();
        $user->revoke();

        return response()->json([
          'success' => true,
          'message' => 'Logout successfully'
        ]);
      
      }else {
          return response()->json([
            'success' => false,
            'message' => 'Unable to Logout'
          ]);
        }
    }

    public function restPassword( Request $request){
      $userId = Auth::user()->id;

        $validator = Validator::make($request->all(), [
          'password' => 'required',
          'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
        }

      $password = bcrypt($request->password);
      $updateArr = ['password' => $password];
      $update = Customer::find($userId)->update($updateArr);
     
      if($update){
         return response()->json(['success' => 'Passowrd changed successfully !'], $this->successStatus);
      }
      else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function forgotPassword(Request $request){
      $email = $request->input('email');
      $user = Customer::where('email',$email)->first();
      $userId = $user->id;
      $data = [];
      if($user){
        $otp = random_int(100000, 999999);
        $data = array("name" => $user->username, 'email' => $user->email,"otp" => $otp);
        
        $mail = Mail::send('email.forgetPassword',['data' => $data] , function ($m) use ($data) {
            $m->from('info@webvectors.in', 'Admin');
            $m->to($data['email'], $data['name'])->subject('Forgot password !');
        });
        
        $update = Customer::find($userId)->update(['user_otp' => $otp]);
        if($update){
          return response()->json(['success' => 'OTP send into your registerd email address !'], $this->successStatus);
        }  

      }else{
            return response()->json(['error'=>'Email address not found'], $this->successStatus); 
      }
    }

    public function verifyOTP(Request $request){
      $email = $request->input('email');
      $otp = $request->input('otp');
      $user = Customer::where(['email' => $email, 'user_otp' => $otp])->first();
      if(!$user){
        return response()->json(['error'=>'Invalid OTP please try again'], $this->successStatus); 
      }else{
      	return response()->json(['success' => 'OTP verification successfully !'], $this->successStatus);
      }
    }

    public function updatePassword(Request $request){

      $email = $request->input('email');
      $user = Customer::where('email',$email)->first();
      $userId = $user->id;

      $validator = Validator::make($request->all(), [
          'password' => 'required',
          'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
        }

      $password = bcrypt($request->password);
      $updateArr = ['password' => $password, 'user_otp' => null];
      $update = Customer::find($userId)->update($updateArr);
     
      if($update){
         return response()->json(['success' => 'Passowrd changed successfully !'], $this->successStatus);
      }
      else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    } 

      public function edituser(){ 
           $user  = Auth::user();
            return response()->json(['success' => $user], $this-> successStatus); 
        } 



        public function updateProfile(Request $request) {  
          $userId = Auth::user()->id;
            $validator = Validator::make($request->all(), [
            'username' => 'required',
            'surname'  => 'required',
            'email'    => 'required|email',
            'address1' => ['required', 'string', 'max:255'],
            'phone'    => ['required', 'numeric', 'min:10'],
                       
            ]);
   
           if($validator->fails()){
              return response()->json(['error'=>$validator->errors()], 401);     
            }

            $userImage = '';
        
            if ($files = $request->file('user_image')) {
              $userImage = $files->getClientOriginalExtension();
              $userImage = 'user_'.$userId.'.'.$userImage; 
              $path = public_path('userProfile/'.$userImage); 
              
              if(file_exists($path)){
                 unlink($path);
              } 

               $files->move(public_path().'/userProfile/', $userImage);
            }

           
                $user = Customer::find($userId);
                $user->username  = $request->username;
                $user->surname   = $request->surname;
                $user->email     = $request->email;
                $user->phone     = $request->phone;
                $user->address1  = $request->address1;
                $user->address2  = $request->address2;
                $user->city      = $request->city;
                $user->zip       = $request->zip;
                $user->langlat   = $request->langlat;
                $user->profile_pic = $userImage;
                
                $user->skype          =  $request->slype;
                $user->facebook       =  $request->facebook;
               
                $user->user_type      =  $request->user_type;
                $user->user_type_till =  $request->user_type_till;
               
               
                $user->country =  $request->country;
                $user->state =  $request->state;
                
                if($user->save()){
                   return response()->json(['success'=>' Profile updated successfully '],$this->successStatus);
                }

                else{
                  return response()->json(['error'=>'Unauthorised'], 401); 
                }
        }
             
      public function updateAddress( Request $request){
        $userId = Auth::user()->id;
       
        $updateArr = [
         'address1' => !empty($request->address1) ? $request->address1 : '',
          'address2' => !empty($request->address2) ? $request->address2 : '',
          'city' => !empty($request->city) ? $request->city : '',
          'zip' => !empty($request->zip) ? $request->zip : '',
          'langlat' => !empty($request->langlat) ? $request->langlat : '',
        ];
       
        $update = Customer::find($userId)->update($updateArr);
        if($update){
          return response()->json(['success'=>' Address updated successfully '],$this->successStatus);
         }else{
          return response()->json(['error'=>'Unauthorised'], 401); 
         } 
      }   

      public function contactMessage( Request $request){
          $validator = Validator::make($request->all(), [
            'name' => 'required',
            'subject'  => 'required',
            'email'    => 'required|email',
            'message' => 'required',
          ]);
   
         if($validator->fails()){
            return response()->json(['error'=>$validator->errors()], 401);     
          }

        $insert = ContactMessage::Create([
          'name' => $request->name,
          'subject' => $request->subject,
          'email' => $request->email,
          'message' => $request->message,
          'timestamp' => time(),

        ]);
        
        if($insert){
          return response()->json(['success'=>'Message send successfully !'], $this->successStatus); 
        }


      }

}

