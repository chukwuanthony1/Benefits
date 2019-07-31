<?php

namespace App\Http\Controllers\Merchant;

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

    function seoUrl($string) {
        $string = strtolower($string);
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", "-", $string);
        return $string;
    }
    
    public function index(Request $request){
        $request->user()->authorizeRoles('merchant');
    	return view('merchant.products.view_products');
    }

    public function merchantProducts(Request $request){
        $request->user()->authorizeRoles('merchant');
        return view('merchant.products.view_products');
    }

    protected function validator(Request $request)
    {
        return Validator::make($request, [
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
    }

    public function merchantAddProduct(Request $request){

        $request->user()->authorizeRoles('merchant');
        if($request->isMethod('post')){
            $data = $request->all();
            //var_dump($data);exit;
            $product = new Products;
            $product->product_name = $data['name'];
            $product->alias = "";
            $product->product_code = 'PRO'.uniqid();
            $product->description = $data['description'];
            $product->category_id = $data['category_id'];
            $product->price = $data['price'];
            $product->status = 0;
            $product->user_id = Auth::user()->id;
            
            if($product->save()){
                if($request->hasFile('image')){
                    foreach($request->file('image') as $image_tmp)
                    {
                        //$image_tmp = Input::file('image');
                        if($image_tmp->isValid()){
                            $extension = $image_tmp->getClientOriginalExtension();
                            $filename = str_replace(" ", "-", $data['name']).''.rand(111,99999).'.'.$extension;
                            $large_image_path = 'images/products/large/'.$filename;
                            $medium_image_path = 'images/products/medium/'.$filename;
                            $small_image_path = 'images/products/small/'.$filename;     
                            Image::make($image_tmp)->resize(1200,700)->save($large_image_path);
                            Image::make($image_tmp)->resize(600,400)->save($medium_image_path);
                            Image::make($image_tmp)->resize(200,200)->save($small_image_path);
                            $product->image = $filename;
                        }

                        $productImages = new ProductImages([
                            'image_path' => $filename,
                        ]);

                        $product->productImages()->save($productImages); 
                    }

                    
                }

                $product = Products::find($product->id);
                $product->alias = $this->seoUrl($data['name']).'-'.$product->id;
                $product->save();
                return redirect('/merchant/products')->with('success', 'Product Created Successfully');
            }else{
                return redirect('/merchant/products/new')->with('error', 'Error occcured when creating product, kindly try again.');
            }
        }
        $categoyList = Categories::pluck('name','id');
        return view('merchant.products.add_product')->with(compact('categoyList'));
    }
    

    public function merchantEditProduct(Request $request, $id=null){
        $request->user()->authorizeRoles('merchant');
        if($request->isMethod('post')){
            $data = $request->all();
            $updated = Products::where(['id'=>$id])->update(['product_name'=>$data['product_name'], 'description'=>$data['description'], 'price'=>$data['price'], 'category_id'=>$data['category_id']]);
            if($updated){
                if($request->hasFile('image')){
                    foreach($request->file('image') as $image_tmp)
                    {
                        //$image_tmp = Input::file('image');
                        if($image_tmp->isValid()){
                            $extension = $image_tmp->getClientOriginalExtension();
                            $filename = str_replace(" ", "-", $data['name']).''.rand(111,99999).'.'.$extension;
                            $large_image_path = 'images/products/large/'.$filename;
                            $medium_image_path = 'images/products/medium/'.$filename;
                            $small_image_path = 'images/products/small/'.$filename;     
                            Image::make($image_tmp)->resize(1200,700)->save($large_image_path);
                            Image::make($image_tmp)->resize(600,400)->save($medium_image_path);
                            Image::make($image_tmp)->resize(200,200)->save($small_image_path);
                            $product->image = $filename;
                        }

                        $productImages = new ProductImages([
                            'image_path' => $filename,
                        ]);

                        $updated->productImages()->save($productImages); 
                    }
                }
                return redirect('/merchant/products')->with('success', 'Product Updated Successfully');
            }else{
                return redirect('/merchant/products')->with('error', 'Error occcured when updating product, kindly try again.');
            }
        }

        $productDetails = Products::where(['id'=> $id])->first();
        $productImage = ProductImages::where(['products_id'=> $id])->get();
        $categoyList = Categories::pluck('name','id');
        //var_dump($productImage);exit;
        return view('merchant.products.edit_product')->with(compact('categoyList', 'productDetails', 'productImage'));
    }

    public function merchantDeleteProduct(Request $request, $id=null){
        $request->user()->authorizeRoles('merchant');
        if(!empty($id)){
            $data = $request->all();
            $deleted = Products::where(['id'=>$id])->delete();
            if($deleted){
                return redirect('/merchant/products')->with('success', 'Product Deleted Successfully');
            }else{
                return redirect('/merchant/products')->with('error', 'Error cccured when deleting product, kindly try again.');
            }
        }

        $productDetails = ProductsProducts::where(['id'=> $id])->first();
        $categoyList = Categories::pluck('name','id');
        return view('merchant.products.view_product')->with(compact('categoyList', 'productDetails'));
    }

    public function merchantDeleteProductImage(Request $request, $id=null, $product_id=null){
        $request->user()->authorizeRoles('merchant');
        if(!empty($id)){
            $data = $request->all();
            $deleted = ProductImages::where(['id'=>$id])->delete();
            if($deleted){
                return redirect('/merchant/edit-product/'.$product_id)->with('success', 'Product Image Deleted Successfully');
            }else{
                return redirect('/merchant/edit-product/'.$product_id)->with('error', 'Error cccured when deleting product image, kindly try again.');
            }
        }

        $productDetails = ProductsProducts::where(['id'=> $id])->first();
        $categoyList = Categories::pluck('name','id');
        return view('merchant.products.view_product')->with(compact('categoyList', 'productDetails'));
    }

    public function merchantProductData(){
        $products = DB::table('products')
                    ->where('user_id', Auth::user()->id)
                    ->get();

        return Datatables::of($products)
                ->addColumn('action', function($products){
                    return '<a href="/merchant/edit-product/'.$products->id.'" class="btn btn-primary btn-sm">Edit</a> <a class="btn btn-danger btn-sm" data-id="'.$products->id.'">Delete</a>';
                })
                ->addColumn('status', function($products){
                    if($products->status == 1){
                        return '<button class="btn btn-success">Approved</button>';
                    }else{
                        return '<button class="btn btn-danger">Pending</button>';
                    }
                })
                // ->addColumn('image', function($products){
                //     return '<img src="/images/products/small/'.$product->image.'" class="datatable-img" />';
                // })
                ->rawColumns(['image', 'action'])
                ->make(true);
    }
}
