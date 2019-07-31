<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Categories;
use App\Products;

class ProductsController extends Controller
{
    public function __construct()
    {
        if(Auth::check()){
            
        }else{
            return redirect('/login');
        }
        parent::__construct();
    }

    public function viewCatProducts(Request $request, $alias=null)
    {
        $categories = Categories::where(['parent_id'=>0])->get();
        $sub_categories = Categories::where('parent_id', '!=', 0)->get();
        $categoryDetails = Categories::where('alias', '=', $alias)->firstOrFail();
        
        $categoryCount = Categories::where(['alias'=>$alias])->count();
        $categoryList = Categories::pluck('name','id');
        
        if($categoryCount == 0){
            return view('404')->with(compact('categories', 'sub_categories','brandList','modelList','categoryList'));
        }

        if($categoryDetails->parent_id == 0){
            $subCatDetails = Categories::where(['parent_id'=>$categoryDetails->id])->get();
            foreach($subCatDetails as $key =>$subcat){
                $cat_ids[] = $subcat->id;
            }
            array_push($cat_ids, $categoryDetails->id);
            //$products = Products::wherein('category_id',$cat_ids)->paginate(12);

            $products = DB::table('products')
                         ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                         ->wherein('category_id',$cat_ids)->paginate(12);

            $randomProducts = DB::table('products')
                                 ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                                 ->wherein('category_id',$cat_ids)->inRandomOrder()->take(5)->get();
        }else{
            $products = DB::table('products')
                         ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                         ->where(['category_id'=>$categoryDetails->id])->paginate(12);
            $randomProducts = DB::table('products')
                                ->select('products.product_name','products.alias','products.price','products.product_code','products.category_id', DB::raw('(SELECT image_path FROM product_images WHERE product_images.products_id = products.Id LIMIT 1) as productImage'))
                                ->where(['category_id'=>$categoryDetails->id])->inRandomOrder()->take(5)->get();
        }

        return view('staffs.category_products')->with(compact('categories', 'sub_categories', 'products', 'categoryDetails', 'brandList', 'modelList', 'categoryList','randomProducts'));
    }

    public function viewProduct(Request $request, $alias=null)
    {
        $categories = Categories::where(['parent_id'=>0])->get();
        $sub_categories = Categories::where('parent_id', '!=', 0)->get();

        $categoryList = Categories::pluck('name','id');

        //$categoryDetails = Categories::find($catid);
        $productDetails = Products::where('alias', '=',$alias)
                                    ->join('merchant_details', 'products.user_id', 'merchant_details.user_id')
                                    ->join('users', 'users.id', 'merchant_details.user_id')
                                    ->select('products.*', 'merchant_details.company_name', 'merchant_details.address', 'merchant_details.site_url', 'merchant_details.image_path', 'merchant_details.id as merchant_id','users.email as email')
                                    ->firstOrFail();

        $productImages = DB::table('product_images')
                            ->where('products_id', $productDetails->id)
                            ->select('image_path')
                            ->get();

        //var_dump($productImages);
        //exit;
        return view('staffs.product_details')->with(compact('categories', 'sub_categories', 'productDetails', 'categoryDetails', 'productImages', 'categoryList'));
    }
}
