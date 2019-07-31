<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Input;
use Request;
use App\Role;
use App\CompanyDetails;
use App\MerchantDetails;
use App\UserDetails;
use App\VerifyUser;
use App\Mail\WelcomeMail;
use Image;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            //'username' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'company_name' => ['unique:company_details'],
            'company_name' => ['unique:merchant_details'],
            'site_url' => ['url', 'unique:merchant_details'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */

    protected function create(array $data)
    {
        //exit;
        try{
            if($data['reg_type'] == "company"){
                
                //exit;
                $user = User::create([
                        'username' => $data['username'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'status'=> 0
                    ]);

                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

                $sunComName = substr($data['company_name'],0, 4);
                
                $companyCode = $sunComName.''.substr(str_shuffle($permitted_chars), 0, 10);

                $companyDetails = new CompanyDetails([
                    'company_name' => $data['company_name'],
                    'company_code'=> $companyCode,
                    'address' => $data['address'],
                    'address1' => "",
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id']
                ]);

                $user->companies()->save($companyDetails);

                $user->roles()->attach(Role::where('name', 'company')->first());

                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                ]);

                //var_dump($user->verifyUser->token);exit;
                Mail::to($data['email'])->send(new WelcomeMail($user));

                $this->guard()->logout();

                Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');

                return $user;
                //return redirect('/login')->with('success', 'Company Created Successfully');

            }else if($data['reg_type'] == "merchant"){
                $filename = "";
                if(Request::hasFile('merchant_logo')){
                    $image_tmp = Input::file('merchant_logo');
                    if($image_tmp->isValid()){
                        $extension = $image_tmp->getClientOriginalExtension();
                        $filename = str_replace(" ", "-", $data['username']).''.rand(111,99999).'.'.$extension;
                        $large_image_path = 'images/logos/large/'.$filename;
                        $medium_image_path = 'images/logos/medium/'.$filename;
                        $small_image_path = 'images/logos/small/'.$filename;     
                        Image::make($image_tmp)->resize(1200,700)->save($large_image_path);
                        Image::make($image_tmp)->resize(600,400)->save($medium_image_path);
                        Image::make($image_tmp)->resize(200,200)->save($small_image_path);
                        //$category->image_path = $filename;
                    }
                }

                $user = User::create([
                            'username' => $data['username'],
                            'email' => $data['email'],
                            'password' => Hash::make($data['password']),
                            'status'=> 0,
                        ]);

                $merchantDetails = new MerchantDetails([
                    'company_name' => $data['company_name'],
                    'site_url' => $data['site_url'],
                    'address' => $data['address'],
                    'address' => $data['address'],
                    'address1' => "",
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id'],
                    'image_path' => $filename
                ]);

                $user->merchants()->save($merchantDetails);

                $user->roles()->attach(Role::where('name', 'merchant')->first());

                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                ]);

                Mail::to($data['email'])->send(new WelcomeMail($user));
                
                $this->guard()->logout();

                Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');

                return $user;
                //return redirect('/login')->with('success', 'Merchant Created Successfully');
            }else if($data['reg_type'] == "userreg"){

                if($data['emailUse'] == '1' || $data['company_code'] == null){
                    $spiltEmail = explode('@', $data['email']);
                    $searchR = DB::table('users')
                                ->join('role_user', 'users.id', 'role_user.user_id')
                                ->join('company_details', 'users.id', 'company_details.user_id')
                                ->where('role_user.role_id', 3)
                                ->where('email', 'LIKE', '%'.$spiltEmail[1].'%')
                                ->select('users.id', 'users.email', 'company_details.company_code')
                                ->get();
                    
                    if(sizeof($searchR) < 1){
                        Request::session()->flash('warning', 'Company not registered on this platform.');
                        return "/user/registration";
                    }elseif(sizeof($searchR) > 1){
                        var_dump('disu');exit;
                        Request::session()->flash('warning', 'Company not registered on this platform.');
                        return "/user/registration";
                    }else{
                        $company_id = $searchR[0]->id;
                    }
                    
                }elseif($data['company_code'] != null || $data['company_code'] != ""){

                    $searchR = DB::table('users')
                                ->join('role_user', 'users.id', 'role_user.user_id')
                                ->join('company_details', 'users.id', 'company_details.user_id')
                                ->where('role_user.role_id', 3)
                                ->where('company_details.company_code', $data['company_code'])
                                ->select('users.id', 'users.email', 'company_details.company_code')
                                ->get();

                    if(sizeof($searchR) < 1){
                        Request::session()->flash('warning', 'Company not registered on this platform.');
                        return "/user/registration";
                    }elseif(sizeof($searchR) > 1){
                        Request::session()->flash('warning', 'Company not registered on this platform.');
                        return "/user/registration";
                    }else{
                        $company_id = $searchR[0]->id;
                    }
                }else{

                    $searchR = DB::table('users')
                                ->join('role_user', 'users.id', 'role_user.user_id')
                                ->join('company_details', 'users.id', 'company_details.user_id')
                                ->where('role_user.role_id', 3)
                                ->where('company_details.company_code', $data['company_code'])
                                ->select('users.id', 'users.email', 'company_details.company_code')
                                ->get();

                    if(sizeof($searchR) < 1){
                        Request::session()->flash('warning', 'Company not registered on this platform.');
                        return "/user/registration";
                    }elseif(sizeof($searchR) > 1){
                        Request::session()->flash('warning', 'Company not registered on this platform.');
                        return "/user/registration";
                    }else{
                        //var_dump('disu');exit;

                        $company_id = $searchR[0]->id;
                    }
                }
                //exit;
                $user = User::create([
                        'username' => $data['first_name'].$data['last_name'],
                        'email' => $data['email'],
                        'password' => Hash::make($data['password']),
                        'status'=> 1
                    ]);

                $userDetails = new UserDetails([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'phone_no' => "",
                    'address' => $data['address'],
                    'address1' => "",
                    'company_id' => (int)$company_id,
                    'city_id' => $data['city_id'],
                    'state_id' => $data['state_id'],
                    'country_id' => $data['country_id']
                ]);               

                $user->userdetails()->save($userDetails);

                //var_dump($userDetails);exit;
                $user->roles()->attach(Role::where('name', 'company_staff')->first());

                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                ]);

                //var_dump($user->verifyUser->token);exit;
                Mail::to($data['email'])->send(new WelcomeMail($user));

                $this->guard()->logout();

                Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');

                return $user;
                //return redirect('/login')->with('success', 'Company Created Successfully');

            }else{
                return redirect('/register')->with('danger', 'An error has occured');
            }
        }catch(\Exception $ex){
            //var_dump($ex->getMessage());exit;
            Request::session()->flash('warning', 'An error has occured.');
            return '/register';
            //return back()->withError($ex->getMessage())->withInput();
        }
        
    }  

    
    public function redirectTo()
    {
        if (\Auth::user()->verified != 1) {
            auth()->logout();
            Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');
            return "/login";
        }else{
            Request::session()->flash('status', 'We sent you an activation code. Check your email and click on the link to verify.');
            return "/login";
        }
    }

    public function showRegistrationForm(Request $request){
        return view('auth/register');
    }

    public function showUserRegistrationForm(Request $request, $company_code=null){
        
        if($company_code != null){
            $comSearch = CompanyDetails::where('company_code','=',$company_code)->select('company_code')->first();
            return view('auth/user_registration')->with(compact('comSearch'));
        }else{
            return view('auth/user_registration');
        }
    }

}
