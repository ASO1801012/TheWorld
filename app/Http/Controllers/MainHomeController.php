<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\onetimepass;
use Illuminate\Support\Facades\Hash;
use Session;

class MainHomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showforgot()
    {
        return view('allhome.forgot');
    }

    public function forgot(Request $request)
    {
        //バリデーション 
        $request->validate([
            'student_number' => 'required|digits:7|integer',
            'email' => 'required|email',
        ]);

        //userテーブルの情報を取得する
        $user = User::all();

        //入力された情報が存在するかを確認する
        foreach($user as $use){
            if(strcmp($use->student_number,$request->student_number) == 0 && strcmp($use->email,$request->email) == 0){
                //同じであればその人のメールアドレス情報を取得する
                $email = User::where([
                    ['student_number',$request->student_number],
                    ['email',$request->email]
                ])->first();

                //ワンタイムパスワードをメールで送る
                //乱数を作成
                $number = "";
                for($i=0; $i<5; $i++) {
                    $number .= rand(0, 9);
                }

                //ワンタイムパスワードをデータベースに保存
                $email->one_pass = $number;
                $email->save();

                //メールの本文
                $mail_text = "ワンタイムパスワード"."\n".$number;
                //メールを送信
                Mail::to($email)->send(new onetimepass($mail_text));

                return redirect('/allhome/onepass')->with('flash_message2', $request->email."にメールを送ったよ！確認してね！");
            }
        }
        return redirect('/allhome/forgot')->with('flash_message2', $request->email."にメールを送ったよ！確認してね！");
    }

    public function showonepass() {
        return view('allhome.onepass');
    }

    public function onepass(Request $request)
    {
        //バリデーション 
        $request->validate([
            'onepass' => 'required|digits:5'
        ]);
        
        $user = User::all();
        
        foreach($user as $use){
            if($use->one_pass == $request->onepass){
                $you = User::where('one_pass',$request->onepass)->first();
                session()->regenerate();
                session(['user'=>$you]);
                return redirect('/allhome/resetpass');
            }
        }
        return redirect('/user/login');
    }

    public function showresetpass()
    {
        return view('allhome.resetpass');
    }

    public function resetpass(Request $request)
    {
        //バリデーション 
        $request->validate([
            'new_pass' => 'required|digits_between:8,20',
            'confirmation_pass' => 'required|digits_between:8,20',
        ]);

        //入力値が同じかチェック
        if(strcmp($request->new_pass,$request->confirmation_pass) == 0 )
        {
            $user = User::find($request->id);

            //パスワードをハッシュ化
            $hash = Hash::make($request->new_pass);
            
            $user->password = $hash;
            $user->one_pass = 0;
            $user->save();
            session()->flush();
            return redirect('/user/login')->with('result',);
        }
      
        return redirect('/allhome/resetpass')->with('flash_message', '同じパスワードを入力してね！');
    }
}