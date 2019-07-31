<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Categories;
use App\Products;
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
    	$request->user()->authorizeRoles('company_staff');
        $categories = Categories::where(['parent_id'=>0])->get();
        $sub_categories = Categories::where('parent_id', '!=', 0)->get();
        //$randomProducts = Products::inRandomOrder()->take(24)->get();

        $randomProducts =DB::table('products')
	                     ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
	                     ->get();
        //var_dump($randomProducts);exit;
        // $brandList = Brand::pluck('name','id');
        // $modelList = Moel::pluck('name','id');
        // $categoryList = Category::pluck('name','id');
        // return view('home')->with(compact('categories', 'sub_categories','randomProducts','brandList','modelList','categoryList'));

        return view('staffs.home')->with(compact('categories', 'sub_categories','randomProducts'));
    }

    public function profile(Request $request){
        $request->user()->authorizeRoles('company_staff');
        $categories = Categories::where(['parent_id'=>0])->get();
        $sub_categories = Categories::where('parent_id', '!=', 0)->get();

        $user = User::where('users.id', Auth::user()->id)->first();

        $userDetails = DB::table('users')
                        ->where('id', Auth::user()->id)
                        ->join('user_details', 'user_details.user_id', '=', 'users.id')
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
        return view('staffs.profile')->with(compact('categories', 'sub_categories', 'userDetails','token'));
    }

}
