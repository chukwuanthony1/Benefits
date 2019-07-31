<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;

use Auth;

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
    	$request->user()->authorizeRoles('admin');
                
        $allMerchants = DB::table('merchant_details')->join('users', 'users.id', 'merchant_details.user_id')->count();
        
        $approvedMerchants = DB::table('merchant_details')->join('users', 'users.id', 'merchant_details.user_id')->where(['users.status'=> 1])->count();
        
        $rejectedMerchants = DB::table('merchant_details')->join('users', 'users.id', 'merchant_details.user_id')->where(['users.status'=> 2])->count();

        $allCompanies = DB::table('company_details')->join('users', 'users.id', 'company_details.user_id')->count();
        
        $approvedCompanies = DB::table('company_details')->join('users', 'users.id', 'company_details.user_id')->where(['users.status'=> 1])->count();
        
        $rejectedCompanies = DB::table('company_details')->join('users', 'users.id', 'company_details.user_id')->where(['users.status'=> 2])->count();

        return view('admin.dashboard')->with(compact('approvedMerchants', 'allMerchants', 'rejectedMerchants', 'allCompanies', 'approvedCompanies', 'rejectedCompanies'));
    }

    public function profile(Request $request){
        $request->user()->authorizeRoles('admin');
        
        $user = User::where('id', Auth::user()->id)->first();

        $userDetails = DB::table('users')
                        ->where('users.id', Auth::user()->id)->join('user_details', 'user_details.user_id', '=', 'users.id')
                        ->leftjoin('company_details', 'company_details.user_id', '=', 'user_details.company_id')
                        ->leftjoin('countries', 'countries.id', '=', 'user_details.country_id')
                        ->leftjoin('states', 'states.id', '=', 'user_details.state_id')
                        ->leftjoin('cities', 'cities.id', '=', 'user_details.city_id')
                        ->select('user_details.*', 'countries.name as country_name', 'states.name as state_name','cities.name as city_name','company_details.company_name as company_name')
                        ->first();
        
        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

        // echo '<pre>';
        // print_r($userDetails);
        // echo '</pre>';
        // exit;
        return view('admin.profile')->with(compact('userDetails','token'));
    }

}
