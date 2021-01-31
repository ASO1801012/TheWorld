<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $users = Auth::user();
        if($users->firstLogin == 0){
            return view('user.auth.updatepass');
        }else{
            return view('user.home');
        }
    }

    public function updatePassword(Request $request){

        $validate_rule = [
            'new-password' => 'required|string|min:6|confirmed'
         ];
         $this->validate($request, $validate_rule);

        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->firstLogin = 1;
        $user->save();

        return view('user.home');
    }

}