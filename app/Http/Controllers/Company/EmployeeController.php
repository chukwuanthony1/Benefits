<?php

namespace App\Http\Controllers\Company;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailer;
use Auth;
use Session;
use App\User;
use App\Role;
use App\UserDetails;
use App\VerifyUser;
use App\Mail\WelcomeMail;
use Excel;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeController extends Controller
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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            //'company_name' => ['unique:company_details'],
        ]);
    }

    public function companyEmployee(Request $request){
        $request->user()->authorizeRoles('company');
    	return view('company.employee.view_employee');
    }


    public function companyAddEmployee(Request $request){

        $request->user()->authorizeRoles('company');

        if($request->isMethod('post')){
            $data = $request->all();

            //var_dump($data);exit;
            $staff = new User;
            $staff->username = $data['first_name'].''.$data['last_name'];
            $staff->email = $data['email'];
            $staff->password = Hash::make('password');
            $staff->status = 1;
            
            $validator = Validator::make($data, [
				            'phone_no' => ['required', 'string', 'max:255','unique:user_details'],
				            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
				            //'company_name' => ['unique:company_details'],
				        ]);

	        if($validator->fails()){
	        	return redirect('/company/employee/new')->with('error', $validator->errors());
	        }elseif($staff->save()){

	            $userDetails = new UserDetails([
				                    'first_name' => $data['first_name'],
				                    'last_name' => $data['last_name'],
				                    'email' => $data['email'],
				                    'phone_no' => $data['phone_no'],
				                    'address' => $data['address'],
				                    'address1' => "",
				                    'company_id' => Auth::user()->id,
				                    'city_id' => $data['city_id'],
				                    'state_id' => $data['state_id'],
				                    'country_id' => $data['country_id']
				                ]);

	            $staff->userdetails()->save($userDetails);

	            $staff->roles()->attach(Role::where('name', 'company_staff')->first());

	            $verifyUser = VerifyUser::create([
	                'user_id' => $staff->id,
	                'token' => sha1(time())
	            ]);

	            //var_dump($user->verifyUser->token);exit;
	            Mail::to($data['email'])->send(new WelcomeMail($staff));

                return redirect('/company/employees')->with('success', 'Employee Created Successfully');
            }else{
                return redirect('/company/employee/new')->with('error', 'Error occcured when creating employee, kindly try again.');
            }
        }
        return view('company.employee.add_employee');
    }


    public function companyUploadEmployee(Request $request){

        $request->user()->authorizeRoles('company');

        if($request->file('uploadfile')) {

        	//Excel::import(new UsersImport, request()->file('your_file'));

        	//$array = Excel::toArray(new UsersImport, 'users.xlsx');

		    $path = $request->file('uploadfile')->getRealPath();
	        $data = Excel::load($path)->get();


	        if($data->count()){
	        	foreach($data as $key => $value){
	        		$staff = new User;
		            $staff->username = $value['first_name'].''.$value['last_name'];
		            $staff->email = $value['email'];
		            $staff->password = Hash::make('password');
		            $staff->status = 0;
		            $rules = [
					            'phone_no' => ['string', 'max:255','unique:user_details'],
					            'email' => ['string', 'email', 'max:255', 'unique:users'],
					            //'company_name' => ['unique:company_details'],
					        ];
					$vdata = $data->toArray();
					$validator = Validator::make($vdata[$key], $rules);
					$errorList = [];

			        if(!$validator->fails())
			        {
			        	//var_dump($validator->errors());
			        	if($staff->save()){
				            $userDetails = new UserDetails([
							                    'first_name' => $value['first_name'],
							                    'last_name' => $value['last_name'],
							                    'email' => $value['email'],
							                    'phone_no' => $value['phone_no'],
							                    'address' => $value['address'],
							                    'address1' => "",
							                    'company_id' => Auth::user()->id,
							                    // 'city_id' => $data['city_id'],
							                    // 'state_id' => $data['state_id'],
							                    // 'country_id' => $data['country_id']
							                ]);

				            $staff->userdetails()->save($userDetails);

				            $staff->roles()->attach(Role::where('name', 'company_staff')->first());

				            $verifyUser = VerifyUser::create([
				                'user_id' => $staff->id,
				                'token' => sha1(time())
				            ]);

				            //var_dump($user->verifyUser->token);exit;
				            //Mail::to($value['email'])->send(new WelcomeMail($staff));
				        }else{

				        }
			        }else{
			        	array_push($errorList, $vdata[$key]);
			        }
	        	}

	        	$count = sizeof($errorList);

	        	// Request::session()->flash('status', $count.' records already exist');

	        	return redirect('/company/employees')->with('success', 'Records uploaded successfully with '.$count.' email(s) already in our record');
	        }
		}
        
        return view('company.employee.upload_employee');
    }


    public function companyEditEmployee(Request $request, $id=null){
        $request->user()->authorizeRoles('merchant');
        if($request->isMethod('post')){
            $data = $request->all();
            $updated = Products::where(['id'=>$id])->update(['product_name'=>$data['product_name'], 'description'=>$data['description'], 'price'=>$data['price'], 'category_id'=>$data['category_id']]);
            if($updated){
                return redirect('/merchant/products')->with('success', 'Product Updated Successfully');
            }else{
                return redirect('/merchant/products')->with('error', 'Error occcured when updating product, kindly try again.');
            }
        }

        $productDetails = Products::where(['id'=> $id])->first();
        $productImage = ProductImages::where(['products_id'=> $id])->get();
        $categoyList = Categories::pluck('name','id');
        //var_dump($productImage);exit;
        return view('merchant.coupons.edit_product')->with(compact('categoyList', 'productDetails', 'productImage'));
    }


    public function companyEmployeeData(){
        $users = DB::table('users')
                    ->join('role_user', 'users.id', 'role_user.user_id')
                    ->join('user_details', 'users.id', 'user_details.user_id')
                    ->where('role_user.role_id', 4)
                    ->where('user_details.company_id', Auth::user()->id)
                    //->where('users.status','!=', 0)
                    ->select('users.*', 'user_details.*')
                    ->get();
        return Datatables::of($users)
                ->addColumn('verified', function($users){
                    if($users->verified == 0){
                        return '<button class="btn btn-warning btn-sm">Pending</button>';
                    }else if ($users->verified == 1){
                        return '<button class="btn btn-success btn-sm">Verified</button>';
                    }
                })
                ->addColumn('status', function($users){
                    if($users->status == 1){
                        return '<button class="btn btn-success btn-sm">Approved</button>';
                    }else if ($users->status == 2){
                        return '<button class="btn btn-danger btn-sm">Rejected</button>';
                    }else if ($users->status == 0){
                        return '<button class="btn btn-warning btn-sm">Pending</button>';
                    }
                })
                ->editColumn('id', 'ID: {{$id}}')
                ->make(true);
    }
}
