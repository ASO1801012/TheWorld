<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Language;
use App\Models\Timetype;
use App\Mail\lesson_schedule;
use Illuminate\Support\Facades\Mail;

class LessonController extends Controller{

    // 相手プロフィール
    public function yourProfile($id=1){
        $user = User::find($id);

        $attendance = Attendance::get();
        $x = array();
        foreach($attendance as $i){
            $x[] = $i->lesson_id;
        }
        $lesson = Lesson::where([
            ['user_id',$user->id]
            // ['attendDate','>=',date('Y-m-d')]
        ])
        ->whereNotIn('id',$x)
        ->orderBy('attendDate')
        ->get();

        $seedData = $this -> getSeedData();
        $data = ['user'=>$user, 'lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('profile.yourProfile',$data); 
    }

    // 検索ページ表示
    public function search(){
        $seedData = $this -> getSeedData();
        $data = ['schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_search',$data);
    }

    // レッスン予約確認画面表示
    public function show($lesson_id=1){
        $lesson = Lesson::find($lesson_id);
        $lesson -> aveReview = $this -> getAveReview($lesson);

        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_show',$data);
    }

    // レッスン予約確定処理
    public function reserve(Request $req){
        $attendance = new Attendance;
        $attendance = $this -> inputReqAttendanceData($attendance,$req);
        $attendance->save();

        //ログインしているIDを持ってくる
        $loginid = Auth::id();

        //ログインしている人の名前を取得する
        $user_name = User::find($loginid)->name;

        //ログインIDと同じものをユーザーテーブルから探し、メールアドレスを持ってくる
        $user_email = User::find($loginid)->email;

        //ログインユーザーのメールアドレスを持ってくる
        //$mail = $user->email;

        //メール送信
        //Mail::to($mail)->send(new Test('データベースから探したよ'));

        //レッスンのIDを取得する
        $lesson_id = $req->lesson_id;

        //レッスンIDの概要を取得する
        $lesson_intro = Lesson::find($lesson_id)->intro;

        //レッスンIDの日付を取得する
        $lesson_attenddate = Lesson::find($lesson_id)->attendDate;

        //レッスンIDのuser_id(教える人)を持ってくる
        $teacher_id = Lesson::find($lesson_id)->user_id;

        //レッスンを教える人の名前を取得する
        $teacher_name = User::find($teacher_id)->name;

        //レッスンIDの講師とユーザーIDが同じ人のメールアドレスを持ってくる
        $teacher_email = User::find($teacher_id)->email;

        //一つにまとめる
        $to = [$user_email,$teacher_email];

        //メール本文の内容
        $mail_text = "レッスン予約が完了したよ！"."\n".
                    "教える人:　".$teacher_name."さん\n".
                    "教わる人:　".$user_name."さん\n".
                    "日時：　".$lesson_attenddate."\n".
                    "レッスン内容：　".$lesson_intro."\n".
                    "それじゃ、忘れないようにね！";

        //メールを送信する
        Mail::to($to)->send(new lesson_schedule($mail_text));
        return redirect('/user/lesson/list');
    }

    // 検索結果ページ表示
    public function result(Request $req){
        $WhoAmI = Auth::user();
        $attendance = Attendance::get();
        $x = array();
        foreach($attendance as $i){
            $x[] = $i->lesson_id;
        }
        if($req->attendDate == '0'){$req->attendDate = '%%';};
        if($req->language_id == '0'){$req->language_id = '%%';};
        if($req->timetype_id == '0'){$req->timetype_id = '%%';};
        
        $lesson = Lesson::where([
            ['attendDate','LIKE',$req->attendDate],
            ['attendDate','>=',date('Y-m-d')],
            ['review','0'],
            ['user_id','!=',$WhoAmI->id],
            ['language_id','LIKE',$req->language_id],
            ['timetype_id','LIKE',$req->timetype_id],
        ])
        ->whereNotIn('id',$x)
        ->orderBy('attendDate')
        ->get(); 

        foreach($lesson as $i){
            $i -> aveReview = $this -> getAveReview($i);
        }
        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson.lesson_search',$data); 
    }

    // 登録ページ表示
    public function create(){
        $seedData = $this -> getSeedData();
        $data = ['schoolRow'=>$seedData[0],'languageRow'=>$seedData[1],'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_create',$data);
    }

    // レッスンの登録処理
    public function insert(LessonCreateRequest $req){
        $member = count($req->dualData);
        for($i = 0; $i < $member; $i++){
            $lesson = new Lesson;
            $lesson = $this -> inputReqLessonData($lesson,$req,$i);
            $lesson->save();
        }
        $seedData = $this -> getSeedData();
        $data = ['schoolRow'=>$seedData[0],'languageRow'=>$seedData[1],'timetypeRow'=>$seedData[2]];
        return redirect('/user/lesson/list');
    }

    //レッスン一覧表示
    public function list(){
        // ============== 0tab ================
        $attendance0 = Attendance::where([
            ['user_id',Auth::id()],
            ['attendFlag','0']
        ])->get();

        $resCheck0 = array();
        foreach($attendance0 as $i){
            $resCheck0[] = $i->lesson_id;
        }
        $lesson0 = Lesson::whereIn('id',$resCheck0)
        ->orderBy('attendDate')
        ->get();
        foreach($lesson0 as $i){
            // そのユーザーの平均評価取得
            $i -> aveReview = $this -> getAveReview($i);

            //レッスンは期限超過しているか否か
            $i -> attendDanger = 0;
            if($i->attendDate < date('Y-m-d')){
                $i -> attendDanger = 1;
                if($i->attendDate == date('Y-m-d') && $i->timetype->endTime <= date('H:i:s')){
                    $i -> attendDanger = 1;
                }
            }
        }

        // ============== 1tab ================
        $attendance1 = Attendance::where([
            ['user_id',Auth::id()],
            ['attendFlag','1']
        ])->get();
        
        $resCheck1 = array();
        foreach($attendance1 as $i){
            $resCheck1[] = $i->lesson_id;
        }    
        $lesson1 = Lesson::whereIn('id',$resCheck1)
        ->orderBy('attendDate')
        ->get(); 
        foreach($lesson1 as $i){
            $i -> aveReview = $this -> getAveReview($i);
        }

        // ============== 2tab ================
        $attendance9 = Attendance::where('attendFlag','1')->get();
        $resCheck2 = array();
        foreach($attendance9 as $i){
            $resCheck2[] = $i->lesson_id;
        }  
        $lesson2 = Lesson::where('user_id',Auth::id())->wherenotIn('id',$resCheck2)->get();
        foreach($lesson2 as $i){
            $i -> attendUser = '0';
            $i -> attendUserId = '0';
            $attendance2 = Attendance::where('lesson_id',$i->id)->get();
            if(count($attendance2) > 0){
                $i -> attendUser = $attendance2[0]->user->name;
                $i -> attendUserId = $attendance2[0]->user->id;
            }
            $i -> aveReview = $this -> getAveReview($i);

            //レッスンは期限超過しているか否か
            $i -> attendDanger = 0;
            if($i->attendDate < date('Y-m-d')){
                $i -> attendDanger = 1;
                if($i->attendDate == date('Y-m-d') && $i->timetype->endTime <= date('H:i:s')){
                    $i -> attendDanger = 1;
                }
            }
        }

        // ============== 3tab ================
        $attendance10 = Attendance::where([
            ['attendFlag','1']
        ])->get();
        
        $resCheck3 = array();
        foreach($attendance10 as $i){
            $resCheck3[] = $i->lesson_id;
        }    
        $lesson3 = Lesson::where('user_id',Auth::id())
        ->whereIn('id',$resCheck3)
        ->orderBy('attendDate')
        ->get(); 
        foreach($lesson3 as $i){
            $i -> attendUser = '0';
            $i -> attendUserId = '0';
            $attendance3 = Attendance::where('lesson_id',$i->id)->get();
            if(count($attendance3) > 0){
                $i -> attendUser = $attendance3[0]->user->name;
                $i -> attendUserId = $attendance3[0]->user->id;
            }
            $i -> aveReview = $this -> getAveReview($i);
        }

        $seedData = $this -> getSeedData();
        $data = ['lessonRow0'=>$lesson0, 'lessonRow1'=>$lesson1, 'lessonRow2'=>$lesson2, 'lessonRow3'=>$lesson3, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_list',$data); 
    }

    //レッスン詳細表示
    public function detail0($lesson_id = 0){
        date_default_timezone_set('Asia/Tokyo');
        $lesson = Lesson::find($lesson_id);
        $lesson -> aveReview = $this -> getAveReview($lesson);

        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_detail0',$data);
    }
    //レッスン詳細表示
    public function detail1($lesson_id = 0){
        $lesson = Lesson::find($lesson_id);
        $lesson -> aveReview = $this -> getAveReview($lesson);

        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_detail1',$data);
    }
    //レッスン詳細表示
    public function detail2($lesson_id = 0){
        $lesson = Lesson::find($lesson_id);
        $attendance = Attendance::where('lesson_id',$lesson_id)->get();
        $lesson -> aveReview = 0;
        $attendance -> aveReview = 0;
        $lesson -> attendUser = 0;

        if(count($attendance) > 0){
            $lesson -> attendUserId = $attendance[0]->user->id;
            $lesson -> attendUser = $attendance[0]->user->name;
            $lesson -> attendUserSc = $attendance[0]->user->school_id;
            $lesson -> attendUserLa = $attendance[0]->user->language_id;
            $lesson -> attendUserIn = $attendance[0]->user->intro;
            $lesson -> attendUserPi = $attendance[0]->user->picturePass;
            $lesson -> attendUserNu = $attendance[0]->user->student_number;
            $attendance -> aveReview = $this -> getAveReview($attendance[0]);
            $lesson -> attendUserAv = $attendance -> aveReview;
            
        }
        $lesson -> aveReview = $this -> getAveReview($lesson);

        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_detail2',$data);
    }
    //レッスン詳細表示
    public function detail3($lesson_id = 0){
        $lesson = Lesson::find($lesson_id);
        $attendance = Attendance::where('lesson_id',$lesson_id)->get();
        $lesson -> aveReview = 0;
        $attendance -> aveReview = 0;
        $lesson -> attendUser = 0;

        if(count($attendance) > 0){
            $lesson -> attendUserId = $attendance[0]->user->id;
            $lesson -> attendUser = $attendance[0]->user->name;
            $lesson -> attendUserSc = $attendance[0]->user->school_id;
            $lesson -> attendUserLa = $attendance[0]->user->language_id;
            $lesson -> attendUserIn = $attendance[0]->user->intro;
            $lesson -> attendUserPi = $attendance[0]->user->picturePass;
            $lesson -> attendUserNu = $attendance[0]->user->student_number;
            $attendance -> aveReview = $this -> getAveReview($attendance[0]);
            $lesson -> attendUserAv = $attendance -> aveReview;
            
        }
        $lesson -> aveReview = $this -> getAveReview($lesson);

        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/lesson_detail3',$data);
    }

    // レッスンキャンセル処理
    public function cancel0(Request $req){
        $attendance0 = Attendance::where('lesson_id',$req->lesson_id)->get();
        $attendance1 = Attendance::find($attendance0[0]->id);
        $attendance1->delete();
        return redirect('/user/lesson/list');
    }
    public function cancel2(Request $req){
        
        $lesson = Lesson::find($req->lesson_id);
        $lesson->delete();
        $attendance0 = Attendance::where('lesson_id',$req->lesson_id)->get();
        $attendance1 = Attendance::find($attendance0[0]->id);
        $attendance1->delete();
        return redirect('/user/lesson/list');
    }
    public function cancel2_1($lesson_id=1){
        
        $lesson = Lesson::find($lesson_id);
        $lesson->delete();
        return redirect('/user/lesson/list');
    }

    // 評価処理
    public function review(Request $req){
        $lesson = Lesson::find($req->lesson_id);
        $lesson -> review = $req -> review;
        $lesson -> save();
        return redirect('/user/lesson/list');
    }

    // ビデオチャット画面表示
    public function inRoom($lesson_id=0){
        $lesson = Lesson::find($lesson_id);
        $lesson -> aveReview = $this -> getAveReview($lesson);

        $attendance = Attendance::where('lesson_id',$lesson_id)->first();

        $seedData = $this -> getSeedData();
        $data = ['lessonRow'=>$lesson, 'attendanceRow'=>$attendance, 'schoolRow'=>$seedData[0], 'languageRow'=>$seedData[1], 'timetypeRow'=>$seedData[2]];
        return view('lesson/room99',$data);
    }

    // ビデオチャット退室
    public function leaveRoom(Request $req){
        $attendance = Attendance::where('lesson_id',$req->lesson_id)->first();
        $attendance -> attendFlag = 1;
        $attendance -> save();
        return redirect('/user/lesson/list');
    }

    // シードデータ取得
    private function getSeedData(){
        $school = School::get();
        $language = Language::get();
        $timetype = Timetype::get();
        $retData = array(
            $school, $language, $timetype
        );
        return $retData;
    }

    // フォームデータ変換1
    private function inputReqLessonData($lesson,$req,$num){
        $dual = explode(';',$req->dualData[$num]);
        $lesson->attendDate = $dual[0];
        $lesson->review = 0;
        $lesson->intro = $req->intro;
        $lesson->user_id = Auth::id();
        $lesson->language_id = $req->language_id;
        $lesson->timetype_id = $dual[1];

        return $lesson;
    }


    // フォームデータ変換2
    private function inputReqAttendanceData($attendance,$req){
        $attendance->attendFlag = 0;
        $attendance->user_id = Auth::id();
        $attendance->lesson_id = $req->lesson_id;

        return $attendance;
    }

    // レッスンの講師のの評価を取得
    private function getAveReview($lesson){
        $retData = '0';
        $revSys0 = Lesson::where([
            ['user_id','LIKE',$lesson -> user_id],
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
        };

        return $retData;
    }

}