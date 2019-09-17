<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Validators\HashValidator;

use App\Components\Models\Text;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Redirect;
use App\User;

class UserController extends Controller
{
public function updatePassword(Request $request){
$user = User::find(Auth::user()->id);
 $this->validate($request,[
            'password' => 'required|min:6',
            'new_password' => 'required|string|min:6',
            'password_confirm' => 'required|same:new_password',
        ],[
            'oldpass.required' => 'Old password is required',
            'oldpass.min' => 'Old password needs to have at least 6 characters',
            'password.required' => 'Password is required',
            'password.min' => 'Password needs to have at least 6 characters',
            'password_confirmation.required' => 'Password does not match'
        ]);

if ($request['password'] == $request['new_password']) {
    return Redirect::back()->with(['errors','Please make sure you changed your passsword']);
}


if (Hash::check($request->get('password'), Auth::user()->password)) {
//User::where(['id','=',Auth::user()->id])->update(array('password ' => bcrypt($request->password)));	
$user->password = Hash::make($request['new_password']);
  $user->save();
  return back()->with('status','password updated');
}
else{
return Redirect::back()->with(['errors','wrong Current password']);
}
 	


}
}
