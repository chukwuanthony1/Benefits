<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class MerchantsController extends Controller
{
    
    public function __construct()
    {
        if(Auth::check()){
            
        }else{
            return redirect('/login');
        }
        parent::__construct();
    }

    public function aindex(Request $request){
    	$request->user()->authorizeRoles('admin');
        // $orders = DB::table('orders')->count();
        // $pending_orders = DB::table('orders')->where(['status'=> 0])->count();
        // $delivered_orders = DB::table('orders')->where(['status'=> 1])->count();
        // $cancelled_orders = DB::table('orders')->where(['status'=> 2])->count();
        // $customers = DB::table('users')
        //             ->join('role_user', 'role_user.user_id', '=', 'users.id')
        //             ->where(['role_user.role_id'=> 5])->count();

    	// return view('admin.dashboard')->with(compact('pending_orders', 'delivered_orders', 'cancelled_orders', 'customers', 'orders'));
        return view('admin.dashboard');
    }

    public function pindex(Request $request){
    	$request->user()->authorizeRoles('admin');
        // $orders = DB::table('orders')->count();
        // $pending_orders = DB::table('orders')->where(['status'=> 0])->count();
        // $delivered_orders = DB::table('orders')->where(['status'=> 1])->count();
        // $cancelled_orders = DB::table('orders')->where(['status'=> 2])->count();
        // $customers = DB::table('users')
        //             ->join('role_user', 'role_user.user_id', '=', 'users.id')
        //             ->where(['role_user.role_id'=> 5])->count();

    	// return view('admin.dashboard')->with(compact('pending_orders', 'delivered_orders', 'cancelled_orders', 'customers', 'orders'));
        return view('admin.dashboard');
    }
}
