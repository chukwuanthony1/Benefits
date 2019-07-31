<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            
        }else{
            return redirect('/login');
        }
        parent::__construct();
    }

    public function index(Request $request){
    	$request->user()->authorizeRoles('merchant');
        
        $allProducts = DB::table('products')->where(['user_id'=> Auth::user()->id])->count();
        
        $approvedProducts = DB::table('products')->where(['user_id'=> Auth::user()->id, 'status'=> 1])->count();

        $rejectedProducts = DB::table('products')->where(['user_id'=> Auth::user()->id, 'status'=> 2])->count();

        $pendingProducts = DB::table('products')->where(['user_id'=> Auth::user()->id, 'status'=> 0])->count();
        
        return view('merchant.dashboard')->with(compact('allProducts', 'approvedProducts', 'rejectedProducts', 'pendingProducts'));
    }

    public function profile(Request $request){
        $request->user()->authorizeRoles('merchant');
        
        $user = User::where('id', Auth::user()->id)->first();

        $userDetails = DB::table('users')
                        ->where('users.id', Auth::user()->id)
                        ->join('merchant_details', 'merchant_details.user_id', '=', 'users.id')
                        ->leftjoin('countries', 'countries.id', '=', 'merchant_details.country_id')
                        ->leftjoin('states', 'states.id', '=', 'merchant_details.state_id')
                        ->leftjoin('cities', 'cities.id', '=', 'merchant_details.city_id')
                        ->select('merchant_details.*', 'countries.name as country_name', 'states.name as state_name','cities.name as city_name','merchant_details.company_name as company_name','users.email as email')
                        ->first();
        
        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

        // echo '<pre>';
        // print_r($userDetails);
        // echo '</pre>';
        // exit;
        return view('merchant.profile')->with(compact('userDetails','token'));
    }
}
