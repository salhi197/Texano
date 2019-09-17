<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Stripe\stripe;
use Redirect;
use App\Components\Models\Subscription;
use App\Mail\Texano;
class SubscriptionController extends Controller
{
    /**
     * @param Request $request
     */
    public function upgradeToPro(Request $request) {
        $user = User::find(auth()->id());
        try {
            $user->newSubscription('Monthly', 'prod_FA5LDB5Yz0lDje')->create($request['stripeToken']);
            //update limitaojn table 
        } catch (\Exception $e) {
            return redirect()->route('home', ['tab' => 'billing-settings'])->with('error',$e->getMessage());
        }//updating or inserting  in  limitation table 
            DB::table('limitations')
            ->where('user_id', Auth::user()->id)
            ->update(['limit' => 10000]);            
            return redirect()->route('home', ['tab' => 'billing-settings'])->with('status','Your plan subscribed successfully');           

    }
    public function contact(Request $request){
        try {
            \Mail::to("salhiali197@gmail.com")->send(new Texano($request));                                  

        } catch (\Exception $e) {
            return redirect()->route('home', ['tab' => 'billing-settings'])->with('error',$e->getMessage());//, ['tab' => 'billing-settings'])->with('error',$e->getMessage());
        }//updating or inserting  in  limitation table 

         return redirect()->route('home', ['tab' => 'billing-settings'])->with('status','message sended');

    }

}
