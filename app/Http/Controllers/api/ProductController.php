<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Categories;
use App\Products;
use App\User;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth:api')->except(['getCategories', 'getSubCategories', 'getCategoryProducts','getProducts', 'getRandomProducts', 'getMerchants']);
    }

    public function viewProduct(Request $request, $catid=null, $alias=null)
    {
        $categoryDetails = Categories::find($catid);
        //$productDetails = Products::where('alias', '=',$alias)->first();

        $productDetails = Products::where('alias', '=',$alias)
                                    ->join('merchant_details', 'products.user_id', 'merchant_details.user_id')
                                    ->join('users', 'users.id', 'merchant_details.user_id')
                                    ->select('products.*', 'merchant_details.company_name', 'merchant_details.address', 'merchant_details.site_url', 'merchant_details.image_path', 'merchant_details.id as merchant_id','users.email as email')
                                    ->firstOrFail();

        $productImages = DB::table('product_images')
                            ->where('products_id', $productDetails->id)
                            ->select('image_path')
                            ->get();

        return response()->json([$productDetails, $productImages], 200);
    }

    public function getProducts(){

        $products =DB::table('products')
                     ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                     ->get();

        //return $products;
        return response()->json($products, 200);
    }

    public function getRandomProducts(){

        $products =DB::table('products')
                     ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                     ->inRandomOrder()->limit(10)
                     ->get();
        //return $products;
        return response()->json($products, 200);
    }

    public function getMerchants(){

        $merchants = DB::table('users')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('roles.name', '=','vendor')
            ->select('users.id', 'users.name', 'users.email', 'users.primary_phone_no', 'users.other_phone_no')
            ->get();

        return $merchants;
        //return response()->json($products, 200);
    }
}