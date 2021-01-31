<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Language;
use App\Models\School;
use App\Models\Lesson;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function profile(){

        //ログイン
        $login = Auth::user();

        //ログインしているIDを持ってくる
        $loginid = Auth::id();

        //ログインIDと同じものをユーザーテーブルから探す
        $user = User::find($loginid);

        //Languageモデルのインスタンスを作成
        $language = Language::all();

        //Languageモデルのインスタンスを作成
        $school = School::all();

        //ログインIDの評価をuserインスタンスへ追加(EZAKI
        $user -> aveReview = 0;
        $revSys0 = Lesson::where([
            ['user_id','LIKE',$user->id],
            ['review','>','0']
        ])
        -> get();
        $jCount = 0;
        $revSys1 = 0;
        for($j = 0; $j < count($revSys0); $j++){
            $revSys1 += $revSys0[$j] -> review;
            $jCount = $jCount + 1;
        };
        if($jCount > 0){
            $retData = round($revSys1 / $jCount,1);
            $user -> aveReview = $retData;
        };

        //モデルのインスタンスを一つにまとめる
        $data = ["login"=>$login, "user" => $user, "language" => $language, "school" => $school];
        
        //profile.blade.phpへ渡す
        return view('profile.profile', $data);

    }

    public function profileupdate(ProfileRequest $request)
    {
        //日付取得
        $time = date("H:i:s");

        //IDが同じ人のデータを持ってくる
        $user = User::find($request->id);

        //名前保存
        $user->name = $request->name;

        //自己紹介保存
        $user->intro = $request->intro;

        //言語ID保存
        $user->language_id = $request->language_id;

        //プロフィール画像保存
        if($request->has('picturePass')){    
            $filename = $request->picturePass->storeAs('public/picture_file', $time.'_'.Auth::user()->id . '.jpg');
            $user->picturePass = str_replace('public/','',$filename);
        };

        //データベースに保存
        $user->save();

        //リダイレクト
        return redirect('/user/profile')->with('status', '更新しました。');
    }
    
}