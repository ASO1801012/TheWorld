<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Language;
use App\Models\School;
use App\Http\Requests\StudentRequest;
use Illuminate\Support\Facades\Hash;
use SplFileObject;
use App\Models\Group;

class StudentController extends Controller
{
    protected $csv = null;
    
    public function index()
    {
        if(Auth::check()){
            $user = User::orderBy('student_number')->paginate(15);

            $school = School::all();

            $data = ["user"=>$user, "school"=>$school,];

            return view('student.index', $data);
        }else{
            return view('admin.auth.login');
        }
    }
    
    public function search(Request $req)
    {
        if($req->number == null){
            $user = User::orderBy('student_number')->paginate(15);
        }else{
            $user = User::where('student_number',$req->number)->paginate(15);
        }

        $school = School::all();

        $data = ["user"=>$user, "school"=>$school,];

        return view('student.index', $data);
    }

    public function create(StudentRequest $req){
        $user = new User;
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->pass);
        $user->student_number = $req->student_number;
        $user->school_id = $req->school;
        $user->picturePass = 'noImage.png';
        $user->intro = 'よろしくお願いします！';
        $user->language_id = 13;
        $user->one_pass = 0;
        $user->save();

        $user = User::orderBy('student_number')->paginate(15);

        //DBから学校の情報を持ってくる
        $school = School::all();

        //一つにまとめる
        $data = ["user"=>$user, "school"=>$school,];

        //表示する
        return redirect('/student/list');

    }

    public function detail($id)
    {
        $user = User::all()->where('id',$id)->first();

        $school = School::all();

        $data = ["user"=>$user, "school"=>$school];

        return view('student.detail', $data);
    }

    public function update(StudentRequest $request)
    {
        if(isset($_POST['kousin'])){
        $user = User::find($request->id);
        $user->student_number = $request->student_number;
        $user->name = $request->name;
        $user->school_id = $request->school;
        $user->email = $request->email;
        $user->save();


        $school = School::all();

        session()->flash('message', '更新しました');

        return view('student/detail', compact('user','school'))->with('status','更新しました');
        }
        
        else{
            $user = User::find($request->id);

            $user->delete();

            return redirect('/student/list')->with('status','削除しました');
        }
    }
    
    // csv初期化
    public function __construct(User $csv)
    {
        $this->csvimport = $csv;
    }
    //csvインポート
    public function import(Request $req)
    {
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $uploaded_file = $req->file('csv_file');
        $file_path = $req->file('csv_file')->path($uploaded_file);
        $file = new SplFileObject($file_path);
        $file->setFlags(SplFileObject::READ_CSV);
        $row_count = 1;
        foreach ($file as $row)
        {
            if ($row === [null]) continue;
            
            if ($row_count > 1)
            {
                $name = $row[0];
                $email = $row[1];
                $password = $row[2];
                $student_number = $row[3];
                $school_id = $row[4];
                $language_id = $row[5];
                
                User::insert(array(
                    'name' => $name,
                    'email' => $email,
                    'password' => $password = Hash::make($req->pass),
                    'student_number' => $student_number,
                    'picturePass' => 'noImage.png',
                    'intro' => 'よろしくお願いします。',
                    'school_id' => $school_id,
                    'language_id' => '13',
                    'one_pass' => '0'
                ));
            }
            $row_count++;
        }    
        
        return redirect('/student/list');
        
    }
}