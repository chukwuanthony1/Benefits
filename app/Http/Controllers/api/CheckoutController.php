<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Cart;
use Mail;
use App\Mail\OrderShipped;
//use Request;
use App\Brand;
use App\Moel;
use App\Category;
use App\Product;
use App\Order;
use App\Payment;
use App\ShippingAddress;
use App\Country;
use App\State;
use App\City;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request){
        
        if($request->isMethod('post')){
            $data = $request->all();

            if($data['shipping_id'] == ''){
                $address = new ShippingAddress;
                $address->address = $data['address'];
                $address->landmark = $data['landmark'];
                $address->country_id = $data['country_id'];
                $address->state_id = $data['state_id'];
                $address->city_id = $data['city_id'];
                $address->user_id = Auth::user()->id;

                if($address->save()){
                    $order = new Order;
                    $order->user_id = Auth::user()->id;
                    $order->cart = uniqid();
                    $order->shipping_id = $address->id;
                    $order->payment_id = $data['payments'];
                    $order->status = '0';
                    if($order->save()){
                        foreach($cart as $row){
                            DB::table('orders_products')->insert([['order_id' => $order->id, 'product_id' => $row->id, 'qty'=>$row->qty,'total'=>$row->subtotal]]);
                        }

                        Mail::to(Auth::user()->email)->send(new OrderShipped($order));
                        
                        return redirect('/orderSuccess')->with('success', 'Category Created Successfully');
                    }else{
                        return redirect('/home')->with('error', 'Error cccured when creating category, kindly try again.');
                    }
                }
            }else{
                $order = new Order;
                $order->user_id = Auth::user()->id;
                $order->cart = uniqid();
                $order->shipping_id = $data['shipping_id'];
                $order->payment_id = $data['payments'];
                $order->status = '0';

                $shipping_address = DB::table('shipping_address')
                    ->join('countries', 'shipping_address.country_id', '=', 'countries.id')
                    ->join('states', 'shipping_address.state_id', '=', 'states.id')
                    ->join('cities', 'shipping_address.city_id', '=', 'cities.id')
                    ->where('shipping_address.id', '=', $data['shipping_id'])
                    ->select('shipping_address.*', 'countries.name as country_name', 'states.name as state_name', 'cities.name as city_name')
                    ->get();

                if($order->save()){
                    foreach($cart as $row){
                        DB::table('orders_products')->insert([['order_id' => $order->id, 'product_id' => $row->id, 'qty'=>$row->qty,'total'=>$row->subtotal]]);
                    }

                    $content = ['title'=>'eSHOP', 'cart'=> $cart, 'name'=> Auth::user()->name, 'body'=>'Thanks for the Order', 'shipping'=> $shipping_address];

                    Mail::to(Auth::user()->email)->send(new OrderShipped($content));
                    return response()->json(['status'=>'success'], 200);
                }else{
                    return response()->json(['status'=>'failed'], 400);
                }
            }
            
        }
        
    }
}
