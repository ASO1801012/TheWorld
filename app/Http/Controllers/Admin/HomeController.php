<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        //ユーザーの数取得
        $user = User::all()->count();

        //レッスンが行われた数取得
        $attendance = Attendance::where('attendFlag','=',1)->count();

        //一つにまとめる
        $data = ["user"=>$user, "attendance"=>$attendance];

        return view('admin.home',$data);
    }

}