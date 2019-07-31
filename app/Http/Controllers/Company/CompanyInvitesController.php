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
use App\CompanyInvites;
use App\Mail\InviteMail;

class CompanyInvitesController extends Controller
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
        return view('company.invites.index');
    }

    public function newInvites(Request $request){
    	$request->user()->authorizeRoles('company');
    	
    	if($request->isMethod('post')){
            $data = $request->all();

            $emailList = preg_split('/(;|,|\*)/', $data['email_address']);

            //var_dump($emailLists);exit;
            $user = User::join('company_details', 'company_details.user_id', '=', 'users.id')->select('users.email', 'company_details.company_code as companyCode', 'company_details.company_name as companyName', 'users.status as status')->where(['users.id'=>Auth::user()->id])->first();

            foreach($emailList as $key => $value){

	        		$invite = new CompanyInvites;

		            $invite->email_address = $value;
		            $invite->company_id = Auth::user()->id;
		            $invite->status = 0;
		            $rules = [
		            			'email' => ['string', 'email', 'unique:users'],
					        ];

					$validator = Validator::make([$emailList[$key]], $rules);
					$errorList = [];

			        if(!$validator->fails())
			        {
			        	if($invite->save()){
				            Mail::to($value)->send(new InviteMail($user));
				        }
			        }else{
			        	array_push($errorList, $emailList[$key]);
			        }
        	}

        	$count = sizeof($errorList);

        	return redirect('/company/invites')->with('success', 'Invitation sent out successfully with '.$count.' faulty email(s) or emails already in our record');
        }
        
        return view('company.invites.add');
    }
}
