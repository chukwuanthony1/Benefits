<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailer;
use App\User;
use App\Mail\ApprovedMail;
use App\Mail\RejectedMail;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(Auth::check()){
            
        }else{
            return redirect('/login');
        }
        parent::__construct();
    }


    public function adminUsers(Request $request){
    	$request->user()->authorizeRoles('admin');
    	//$user->roles()->whereIn('name', 'admin')->first();
        return view('admin.users.adminusers');
    }

    public function pendingMerchants(Request $request){
    	$request->user()->authorizeRoles('admin');
        return view('admin.users.pendingmerchants');
    }

    public function approvedMerchants(Request $request){
    	$request->user()->authorizeRoles('admin');
        return view('admin.users.approvedmerchants');
    }


    public function pendingCompanies(Request $request){
    	$request->user()->authorizeRoles('admin');
        return view('admin.users.pendingcompanies');
    }

    public function approvedCompanies(Request $request){
    	$request->user()->authorizeRoles('admin');
        return view('admin.users.approvedcompanies');
    }

    public function addMerchant(Request $request){
        $request->user()->authorizeRoles('admin');
        if($request->isMethod('post')){
            $data = $request->all();
            
            $user = User::create([
              'name'     => $data['name'],
              'email'    => $data['email'],
              'password' => bcrypt('secret'),
            ]);

            $user->roles()->attach(Role::where('name', 'vendor')->first());

            if($user){
                return redirect('/admin/merchants')->with('success', 'User Created Successfully');
            }else{
                return redirect('/admin/merchants/new')->with('error', 'Error occcured when creating user, kindly try again.');
            }
        }
        $roleList = Role::pluck('name','id');
        return view('admin.merchants.add_merchant')->with(compact('roleList'));
    }
    

    public function editMerchant(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        if($request->isMethod('post')){
            $data = $request->all();
            $updated = User::where(['id'=>$id])->update(['name'=>$data['name'], 'email'=>$data['email']]);
            if($updated){
                return redirect('/admin/merchants')->with('success', 'Merchant Updated Successfully');
            }else{
                return redirect('/admin/merchants')->with('error', 'Error occcured when updating merchant, kindly try again.');
            }
        }

        $userDetails = User::where(['id'=> $id])->first();
        $roleList = Role::pluck('name','id');
        return view('admin.merchants.edit_merchant')->with(compact('roleList', 'userDetails'));
    }

    public function deactivateUser(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        $updated = User::where(['id'=>$id])->update(['status'=>2]);
        if($updated){
            return redirect()->back()->with('success', 'User Actived Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating merchant, kindly try again.');
        }
    }

    public function activateUser(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        $updated = User::where(['id'=>$id])->update(['status'=>1]);
        if($updated){
            return redirect()->back()->with('success', 'User Activated Successfully');
        }else{
            return redirect()->back()->with('error', 'Error occcured when updating merchant, kindly try again.');
        }
    }

    public function merchantData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('merchant_details', 'users.id', 'merchant_details.user_id')
                    ->where('role_user.role_id', 2)
                    ->where('users.status', '!=', 0)
                    ->select('users.*', 'merchant_details.company_name')
                    ->get();
        return Datatables::of($users)
                ->addColumn('action', function($users){
                    if($users->status == 1){
                        return '<a href="/admin/deactive-user/'.$users->id.'" class="btn btn-danger btn-sm">De-Activate User</a><a href="/admin/view-merchant/'.$users->id.'" class="btn btn-info btn-sm">View Merchant</a>';
                    }else{
                        return '<a href="/admin/active-user/'.$users->id.'" class="btn btn-success btn-sm">Activate User</a><a href="/admin/view-merchant/'.$users->id.'" class="btn btn-info btn-sm">View Merchant</a>';
                    }
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


    public function pendingMerchantData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('merchant_details', 'users.id', 'merchant_details.user_id')
                    ->where('role_user.role_id', 2)
                    ->where('users.status', 0)
                    ->select('users.*', 'merchant_details.company_name')
                    ->get();
        return Datatables::of($users)
                ->addColumn('action', function($users){
                    return '<a href="/admin/view-merchant/'.$users->id.'" class="btn btn-info btn-sm">View Merchant</a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }

    public function adminViewMerchant(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        // $productDetails = Products::where(['id'=> $id])->first();

        $merchantDetails = DB::table('users')
                            ->join('merchant_details', 'users.id', 'merchant_details.user_id')
                            ->leftjoin('states', 'merchant_details.state_id', 'states.id')
                            ->leftjoin('countries', 'merchant_details.country_id', 'countries.id')
                            ->leftjoin('cities', 'merchant_details.city_id', '=','cities.id')
                            ->where('users.id', $id)
                            ->select('users.id as id', 'users.username as username','users.email as email','merchant_details.address as address','merchant_details.site_url as site_url','merchant_details.company_name as company_name', 'states.name as state_name', 'countries.name as country_name','cities.name as city_name', 'users.status as status' )
                            ->first();

        //var_dump($merchantDetails);exit;
        return view('admin.users.merchant_details')->with(compact('merchantDetails'));
    }

    public function adminUpdateMerchant(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        if($request->isMethod('post')){
            $data = $request->all();
            try{
                $updated = User::where(['id'=>$id])->update(['status'=>$data['status']]);
                if($updated){
                    return redirect('/admin/approvedmerchants')->with('success', 'Merchant Updated Successfully');
                }else{
                    return redirect('/admin/pendingmerchants')->with('error', 'Error occcured when updating merchant, kindly try again.');
                }
            }catch(\Exception $ex){
                //var_dump($ex->getMessage());exit;
                return redirect('/admin/pendingmerchants')->with('error', 'Error occcured when updating merchant, kindly try again.');
            }  
        }

        // $productDetails = Products::where(['id'=> $id])->first();
        // $productImage = ProductImages::where(['products_id'=> $id])->get();
        // $categoyList = Categories::pluck('name','id');
        // //var_dump($productImage);exit;
        // return view('merchant.products.edit_product')->with(compact('categoyList', 'productDetails', 'productImage'));
    }



    public function adminData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('user_details', 'users.id', 'user_details.user_id')
                    ->where('role_user.role_id', 1)
                    ->select('users.*')
                    ->get();
        return Datatables::of($users)
                ->addColumn('action', function($users){
                    if($users->status == 1){
                        return '<a href="/admin/deactive-user/'.$users->id.'" class="btn btn-danger btn-sm">De-Activate User</a>';
                    }else if ($users->status == 2){
                        return '<a href="/admin/active-user/'.$users->id.'" class="btn btn-success btn-sm">Activate User</a>';
                    }
                })
                ->addColumn('name', function($users){
                    return $users->first_name ." ". $users->last_name ;
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }

    public function companyData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('company_details', 'users.id', 'company_details.user_id')
                    ->where('role_user.role_id', 3)
                    ->where('users.status','!=', 0)
                    ->where('users.status','!=', 2)
                    ->select('users.*', 'company_details.company_name')
                    ->get();
        return Datatables::of($users)
                ->addColumn('action', function($users){
                    if($users->status == 1){
                        return '<a href="/admin/deactive-user/'.$users->id.'" class="btn btn-danger btn-sm">De-Activate User</a><a href="/admin/view-company/'.$users->id.'" class="btn btn-info btn-sm">View Details</a>';
                    }else if ($users->status == 2){
                        return '<a href="/admin/active-user/'.$users->id.'" class="btn btn-success btn-sm">Activate User</a><a href="/admin/view-company/'.$users->id.'" class="btn btn-info btn-sm">View Details</a>';
                    }
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


    public function pendingCompanyData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('company_details', 'users.id', 'company_details.user_id')
                    ->where('role_user.role_id', 3)
                    ->where('users.status', 0)
                    ->select('users.*', 'company_details.company_name')
                    ->get();
        return Datatables::of($users)
                ->addColumn('action', function($users){
                    return '<a href="/admin/view-company/'.$users->id.'" class="btn btn-info btn-sm">View Details</a>';
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }


    public function adminViewCompany(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        // $productDetails = Products::where(['id'=> $id])->first();

        $companyDetails = DB::table('users')
                            ->join('company_details', 'users.id', 'company_details.user_id')
                            ->leftjoin('states', 'company_details.state_id', 'states.id')
                            ->leftjoin('countries', 'company_details.country_id', 'countries.id')
                            ->leftjoin('cities', 'company_details.city_id', '=','cities.id')
                            ->where('users.id', $id)
                            ->select('users.id as id', 'users.username as username','users.email as email','company_details.address as address','company_details.company_name as company_name', 'states.name as state_name', 'countries.name as country_name','cities.name as city_name', 'users.status as status' )
                            ->first();

        //var_dump($companyDetails);exit;
        return view('admin.users.company_details')->with(compact('companyDetails'));
    }

    public function adminUpdateCompany(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        if($request->isMethod('post')){
            $data = $request->all();
            try{

                $user = User::join('company_details', 'company_details.user_id', '=', 'users.id')->select('users.email', 'company_details.company_code as companyCode', 'company_details.company_name as companyName', 'users.status as status')->where(['users.id'=>$id])->first();
                
                $updated = User::where(['id'=>$id])->update(['status'=>$data['status']]);

                if($updated){
                    //var_dump($data['status']);exit;
                    //exit;
                    if($data['status'] == '1'){
                        Mail::to($user->email)->send(new ApprovedMail($user));
                    }else if($data['status'] == '2'){
                        Mail::to($user->email)->send(new RejectedMail($user));
                    }

                    return redirect('/admin/approvedcompanies')->with('success', 'Company Updated Successfully');
                }else{
                    return redirect('/admin/pendingcompanies')->with('error', 'Error occcured when updating company, kindly try again.');
                }
            }catch(\Exception $ex){
                var_dump($ex->getMessage());exit;
                //return redirect('/admin/pendingcompanies')->with('error', 'Error occcured when updating company, kindly try again.');
            }  
        }

        // $productDetails = Products::where(['id'=> $id])->first();
        // $productImage = ProductImages::where(['products_id'=> $id])->get();
        // $categoyList = Categories::pluck('name','id');
        // //var_dump($productImage);exit;
        // return view('merchant.products.edit_product')->with(compact('categoyList', 'productDetails', 'productImage'));
    }
}
