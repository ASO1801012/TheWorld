<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Language;
use App\Models\School;
use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index()
    {
        //DBから生徒の情報を持ってくる
        $user = User::orderBy('student_number')->get();

        //DBから学校の情報を持ってくる
        $school = School::all();

        //一つにまとめる
        $data = ["user"=>$user, "school"=>$school,];

        //表示する
        return view('student.index', $data);
    }

    public function create(Request $req){
        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->student_number = $req->number;
        $user->school_id = $req->school;
        $user->picturePass = 'noImage.png';
        $user->intro = 'よろしくお願いします！';
        $user->language_id = 13;
        $user->save();


        $user = User::all();

        //DBから学校の情報を持ってくる
        $school = School::all();

        //一つにまとめる
        $data = ["user"=>$user, "school"=>$school,];

        //表示する
        return view('student.index', $data);

    }

    public function detail($id)
    {
        //idが同じ学生の情報を持ってくる
        $user = User::all()->where('id',$id)->first();

        //DBから学校の情報を持ってくる
        $school = School::all();

        //一つにまとめる ※名前をつけないと送れない
        $data = ["user"=>$user, "school"=>$school];

        //表示する
        return view('student.detail', $data);
    }

    public function update(StudentRequest $request)
    {
        //IDが同じ人のデータを持ってくる
        $user = User::find($request->id);

        //学籍番号の保存
        $user->student_number = $request->student_number;

        //名前の保存
        $user->name = $request->name;

        //学校IDの保存
        $user->school_id = $request->school_id;

        //メールアドレスの保存
        $user->email = $request->email;

        $school = School::all();

        //データベースに保存
        $user->save();

        //ファッシュメッセージ
        session()->flash('message', '更新したよ');

        //リダイレクト
        // return redirect('/student/detail/',$user->id)->with('status','更新したよ');
        return view('student/detail', compact('user','school'))->with('status','更新したよ');
    }

    public function delete($id)
    {
        //IDが同じ人のデータを持ってくる
        $user = User::find($id);

        //データを消す
        $user->delete();

        //一覧表示画面にリダイレクト
        return redirect('/user/student/list')->with('status','削除しました');
    }
}