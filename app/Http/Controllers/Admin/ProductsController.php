<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Image;
use App\Categories;
use App\Products;
use App\ProductImages;

class ProductsController extends Controller
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

    
    public function index(Request $request){
        $request->user()->authorizeRoles('admin');
    	return view('admin.products.view_products');
    }

    public function pendingProducts(Request $request){
        $request->user()->authorizeRoles('admin');
        return view('admin.products.pending_products');
    }

    public function approvedProducts(Request $request){
        $request->user()->authorizeRoles('admin');
        return view('admin.products.approved_products');
    }

    

    public function adminViewProduct(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        // $productDetails = Products::where(['id'=> $id])->first();

        $productDetails = DB::table('products')
		                    ->join('merchant_details', 'products.user_id', 'merchant_details.user_id')
		                    ->join('users', 'products.user_id', 'users.id')
		                    ->where('products.id', $id)
		                    ->select('products.*','users.email','merchant_details.address','merchant_details.site_url','merchant_details.company_name')
		                    ->first();

        $productImage = ProductImages::where(['products_id'=> $id])->get();
        $categoyList = Categories::pluck('name','id');
        //var_dump($productDetails);exit;
        return view('admin.products.view_product')->with(compact('categoyList', 'productDetails', 'productImage'));
    }


    public function adminUpdateProduct(Request $request, $id=null){
        $request->user()->authorizeRoles('admin');
        if($request->isMethod('post')){
            $data = $request->all();
            try{
            	$updated = Products::where(['id'=>$id])->update(['category_id'=>$data['category_id'], 'status'=>$data['status']]);
	            if($updated){
	                return redirect('/admin/products/pending')->with('success', 'Product Updated Successfully');
	            }else{
	                return redirect('/admin/products/pending')->with('error', 'Error occcured when updating product, kindly try again.');
	            }
            }catch(\Exception $ex){
            	//var_dump($ex->getMessage());exit;
            	return redirect('/admin/products/pending')->with('error', 'Error occcured when updating product, kindly try again.');
            }
            
        }

        $productDetails = Products::where(['id'=> $id])->first();
        $productImage = ProductImages::where(['products_id'=> $id])->get();
        $categoyList = Categories::pluck('name','id');
        //var_dump($productImage);exit;
        return view('merchant.products.edit_product')->with(compact('categoyList', 'productDetails', 'productImage'));
    }


    public function pendingProductData(){
        $products = DB::table('products')
                    ->where('status', 0)
                    ->get();

        return Datatables::of($products)
                ->addColumn('action', function($products){
                    return '<a href="/admin/view-product/'.$products->id.'" class="btn btn-primary btn-sm">View PRoduct</a>';
                })
                ->addColumn('status', function($products){
                    return '<button class="btn btn-danger">Pending</button>';
                })
                // ->addColumn('image', function($products){
                //     return '<img src="/images/products/small/'.$product->image.'" class="datatable-img" />';
                // })
                ->rawColumns(['image', 'action'])
                ->make(true);
    }


    public function approvedProductData(){
        $products = DB::table('products')
                    ->where('status', 1)
                    ->get();

        return Datatables::of($products)
                ->addColumn('action', function($products){
                    return '<a href="/admin/view-product/'.$products->id.'" class="btn btn-primary btn-sm">View PRoduct</a>';
                })
                ->addColumn('status', function($products){
                    return '<button class="btn btn-success">Approved</button>';
                })
                // ->addColumn('image', function($products){
                //     return '<img src="/images/products/small/'.$product->image.'" class="datatable-img" />';
                // })
                ->rawColumns(['image', 'action'])
                ->make(true);
    }
}
