<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request; 
use App\Mail\SendMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'email_available','forgotPassword','demo','submit_password']]);
    } 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
   /* public function index()
    {
        $userRole = auth()->user()->role;
        if($userRole == 1){
             return redirect('super-admin/dashboard');
        }elseif ($userRole == 2) {
            return redirect('admin/dashboard');
        }else{
            echo "test"; die();
            view('welcome');
        }
    } */
    public function demo()
    {
        $data['token'] = 'c4ca4238a0b923820dcc509a6f75849b2451';
        return view('forgot_email',$data);
    }

    function email_available(Request $request){
        $email = $request->email;
        $sql = 'SELECT id,name,email FROM users WHERE email="'.$email.'" LIMIT 1';
        $res = DB::select($sql);
        if($res){
            $user_id = $res[0]->id;
            $token = md5($user_id).rand(10,9999);
            //$sql = 'UPDATE users SET remember_token = "'.$token.'" WHERE id="'.$user_id.'" ';
            $res = DB::table('users')
            ->where('id', $user_id)
            ->update(['remember_token' => $token]);
            $email_data['subject'] = 'Reset your password.';
            $email_data['title']='Click to lick to verify';
            $email_data['email'] = $email;
            $email_data['remember_token'] = $token;
            Mail::to($email)->send(new SendMail($email_data));
            $data = array('status'=>true,'msg'=>"An email has been sent on your email.<br>please check your inbox.");
             echo json_encode($data);

        }else{
            $data = array('status'=>false,'msg'=>"This email doesn't exist.");
            echo json_encode($data);
        }
    }

    function forgotPassword(Request $request,$token = ''){
        if($token !=''){         
               $sql = 'SELECT id,name,email FROM users WHERE remember_token="'.$token.'" LIMIT 1';
                $res = DB::select($sql);
                if($res){
                    $data['remember_token'] = $token; 
                    return view('auth.login', $data);    
                }else{
                return redirect('/');

                }
        }else
        {
            return redirect('/');
        }
    }

    function submit_password(Request $request)
    {
        $password = $request->password;
        $remember_token = $request->remember_token;
        $sql = 'SELECT id,name,email FROM users WHERE remember_token="'.$remember_token.'" LIMIT 1';
        $res = DB::select($sql);
        if($res){
            $new_password = Hash::make($password);
            $user_id = $res[0]->id;
            $sql = 'UPDATE users SET password = "'.$new_password.'" WHERE id="'.$user_id.'" ';
            $res = DB::select($sql);
            $sql = 'UPDATE company_profile SET company_pass = "'.$password.'" WHERE user_id="'.$user_id.'" ';
            $res = DB::select($sql);
            $data = array('status'=>true,'msg'=>"Password has been changed successfully.");
            echo json_encode($data);
        }else{
            $data = array('status'=>false,'msg'=>"Something went wrong.Please try again..");
            echo json_encode($data);
        }
    }

}




