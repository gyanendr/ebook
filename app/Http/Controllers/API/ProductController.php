<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    public function __construct()
        {
            $this->middleware('guest:customer');
            
        }
  
    public function index()

    {
        $user = Auth::user(); 
        echo "<pre>"; print_r($user); die();

        echo "test"; die();
       
            //return ProductCollection::collection(Product::all);
           $success= sub_product::all();
        return response()->json(['success' => $success]);
    }
}
