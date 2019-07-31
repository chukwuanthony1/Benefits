<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Countries;
use App\States;
use App\Cities;
use App\Coupons;

class UtitlityController extends Controller
{

    public function getCountries() {
        $country = Countries::get();
        return response()->json($country);
    }

    public function getCountryStates(Request $request, $country_id=null){
        $data = $request->all();
        $state = States::where(['country_id'=>$data['country_id']])->get();
        return response()->json($state);
    }

    public function getStateCities(Request $request, $state_id=null){
        $data = $request->all();
        $cities = Cities::where(['state_id'=>$data['state_id']])->get();
        return response()->json($cities);
    }

    public function getMerchantCoupon(Request $request, $merchant_id=null){
        $data = $request->all();
        $coupon = Coupons::where(['user_id'=>$data['merchant_id']])->first();
        return response()->json($coupon);
    }
}
