<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterAuthRequest;
use Illuminate\Auth\SessionGuard;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Countries;
use App\States;
use App\Cities;
use App\Coupons;

class UtitlityController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware('auth:api')->except(['getCategories', 'getSubCategories', 'getCategoryProducts']);

        $this->user = JWTAuth::parseToken()->authenticate();
    }

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
