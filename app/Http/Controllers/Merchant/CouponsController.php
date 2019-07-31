<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\Coupons;
use DateTime;

class CouponsController extends Controller
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


    public function merchantCoupons(Request $request){
        $request->user()->authorizeRoles('merchant');
    	return view('merchant.coupons.view_coupons');
    }


    public function merchantAddCoupon(Request $request){

        $request->user()->authorizeRoles('merchant');
        if($request->isMethod('post')){
            $data = $request->all();
            //var_dump($data);exit;
            $coupon = new Coupons;
            $coupon->name = $data['name'];
            $coupon->code = $data['code'];
            $start_date = new DateTime($data['start_date']);
            $end_date = new DateTime($data['end_date']);
            $coupon->start_date = $start_date;
            $coupon->end_date = $end_date;
            $coupon->user_id = Auth::user()->id;
            
            if($coupon->save()){                
                return redirect('/merchant/coupons')->with('success', 'Product Created Successfully');
            }else{
                return redirect('/merchant/coupon/new')->with('error', 'Error occcured when creating product, kindly try again.');
            }
        }
        return view('merchant.coupons.add_coupon');
    }


    public function merchantEditProduct(Request $request, $id=null){
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


    public function merchantCouponData(){
        $coupons = DB::table('coupons')
                    ->where('user_id', Auth::user()->id)
                    ->get();

        return Datatables::of($coupons)
                ->addColumn('action', function($coupons){
                    return '<a class="btn btn-danger btn-sm" data-id="'.$coupons->id.'">Delete</a>';
                })
                ->make(true);
    }

}
