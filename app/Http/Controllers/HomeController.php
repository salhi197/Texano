<?php

namespace App\Http\Controllers;
use App;
use App\Subscription;
use Illuminate\Http\Request;
use App\Components\Models\Text;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Mail;
use App\Mail\Texano;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab)
    {
        $title = $tab;
        if($tab=="plan-usage"){
            $limitation= DB::table('limitations')->where([
                ['user_id', '=', Auth::user()->id],
            ])->first();  
            $requests = $limitation->limit;
            $pourcentage = (int)($requests*100/1000);          
            return view('home', compact('tab','title','requests','pourcentage'));
        }
        if($tab=="billing-history"){

            \Stripe\Stripe::setApiKey("sk_test_EcS3rKxvQP2X5UdG2LYwjIXN006MvfYy90");

//            $invoices=Subscription::all();
            $invoices=\Stripe\Invoice::all(["limit" => 3,"customer"=>"cus_DKgHAxRCCU1eeK"]);
            return view('home', compact('tab','title','invoices'));
        }
        if ($tab=="billing-settings") {
            # code...
        }

        return view('home', compact('tab','title'));
    }






}
