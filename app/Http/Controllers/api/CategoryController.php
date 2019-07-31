<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Facades\Datatables;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Categories;
use App\Products;
use Session;
use Image;

class CategoryController extends Controller
{
    protected $user;

	public function __construct()
    {
        $this->middleware('auth:api')->except(['getCategories', 'getSubCategories', 'getCategoryProducts']);

        $this->user = JWTAuth::parseToken()->authenticate();
    }
  
	public function getCategories(){
    	return Categories::where(['parent_id'=>0])->get();
    }

    public function getSubCategories(){
    	return Categories::where('parent_id', '!=', 0)->get();
    }

    public function getCategoryProducts($alias =null){
    	$categoryDetails = Categories::where('alias', '=', $alias)->first();
        $categoryCount = Categories::where(['alias'=>$alias])->count();

        if($categoryCount == 0){
            return response()->json(null, 204);
        }else{

        	if($categoryDetails->parent_id == 0){
	            $subCatDetails = Categories::where(['parent_id'=>$categoryDetails->id])->get();
	            foreach($subCatDetails as $key =>$subcat){
	                $cat_ids[] = $subcat->id;
	            }
	            array_push($cat_ids, $categoryDetails->id);

                $products = DB::table('products')
                             ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                             ->wherein('category_id',$cat_ids)
                             ->get();

	            // $products = Products::wherein('category_id',$cat_ids)->join('users', 'users.id', '=', 'products.user_id')->select('users.name', 'products.*')->get();
	        }else{

                $products = DB::table('products')
                             ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                             ->where('category_id',$categoryDetails->id)
                             ->get();

	            // $products = Products::where(['category_id'=>$id])->join('users', 'users.id', '=', 'products.user_id')->select('users.name', 'products.*')->get();
	        }

	        return response()->json($products, 200);
        }
    }
}
