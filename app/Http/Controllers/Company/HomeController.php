<?php

namespace App\Http\Controllers\Company;

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
    	$request->user()->authorizeRoles('company');
        
        $companyStaffs = DB::table('user_details')->where(['company_id'=> Auth::user()->id])->count();
        
        $companyStaffsVerified = DB::table('user_details')->join('users', 'users.id', 'user_details.user_id')->where(['user_details.company_id'=> Auth::user()->id, 'users.verified'=> 1])->count();

        $companyStaffsUnVerified = DB::table('user_details')->join('users', 'users.id', 'user_details.user_id')->where(['user_details.company_id'=> Auth::user()->id, 'users.verified'=> 0])->count();

        $companyStaffsActive = DB::table('user_details')->join('users', 'users.id', 'user_details.user_id')->where(['user_details.company_id'=> Auth::user()->id, 'users.status'=> 1])->count();
        
        $companyStaffsDeActive = DB::table('user_details')->join('users', 'users.id', 'user_details.user_id')->where(['user_details.company_id'=> Auth::user()->id, 'users.status'=> 2])->count();

       return view('company.dashboard')->with(compact('companyStaffs', 'companyStaffsVerified', 'companyStaffsUnVerified', 'companyStaffsActive', 'companyStaffsDeActive'));
        //return view('company.dashboard');
    }

    public function profile(Request $request){
        $request->user()->authorizeRoles('company');
        
        $user = User::where('id', Auth::user()->id)->first();

        $userDetails = DB::table('users')
                        ->where('users.id', Auth::user()->id)
                        ->join('company_details', 'company_details.user_id', '=', 'users.id')
                        ->leftjoin('countries', 'countries.id', '=', 'company_details.country_id')
                        ->leftjoin('states', 'states.id', '=', 'company_details.state_id')
                        ->leftjoin('cities', 'cities.id', '=', 'company_details.city_id')
                        ->select('company_details.*', 'countries.name as country_name', 'states.name as state_name','cities.name as city_name','company_details.company_name as company_name', 'users.email as email')
                        ->first();
        
        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($user);

        // echo '<pre>';
        // print_r($userDetails);
        // echo '</pre>';
        // exit;
        return view('company.profile')->with(compact('userDetails','token'));
    }
}
