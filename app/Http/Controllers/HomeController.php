<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function userHome()
    {
        if (\Auth::user()->roles[0]['name'] == 'admin') {
            return redirect("/admin/dashboard/");
        }elseif(\Auth::user()->roles[0]['name'] == 'company'){
            return redirect("/company/dashboard/");
        }elseif(\Auth::user()->roles[0]['name'] == 'merchant'){
            return redirect("/merchant/dashboard/");
        }elseif(\Auth::user()->roles[0]['name'] == 'company_staff'){
            return redirect("/benefit/home");
        }else{
            return redirect("/");
        }
    }


    public function userProfile()
    {
        if (\Auth::user()->roles[0]['name'] == 'admin') {
            return redirect("/admin/profile/");
        }elseif(\Auth::user()->roles[0]['name'] == 'company'){
            return redirect("/company/profile/");
        }elseif(\Auth::user()->roles[0]['name'] == 'merchant'){
            return redirect("/merchant/profile/");
        }elseif(\Auth::user()->roles[0]['name'] == 'company_staff'){
            return redirect("/benefit/profile");
        }else{
            return redirect("/login");
        }
    }

    public function getCountries() {
        $country = Country::where(['active'=>'1'])->get();
        return response()->json($country);
    }

    public function getCountryStates(Request $request, $country_id=null){
        $data = $request->all();
        $state = State::where(['country_id'=>$data['country_id']])->get();
        return response()->json($state);
    }

    public function getStateCities(Request $request, $state_id=null){
        $data = $request->all();
        $cities = City::where(['state_id'=>$data['state_id']])->get();
        return response()->json($cities);
    }
}
