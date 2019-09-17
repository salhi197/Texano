<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;

class LangController extends Controller
{
public function setLang($lang){

    if (in_array($lang, ['en','fr','es','arb','dutch'])) {
        if (auth()->user()) {
            $user = auth()->user();
            $user->lang = $lang;
            $user->save();
        }else{
            if (session()->has('lang')) {
                session()->forget('lang');
            }
        session()->put('lang',$lang);
        }
    }else{
        if (auth()->user()) {
            $user = auth()->user();
            $user->lang = 'en';
            $user->save();
        }else{
            if (session()->has('lang')) {
                session()->forget('lang');
            }
        session()->put('lang',$lang);
        }
    }
    return back();

}


}
