<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Language;
use App\Models\Attendance;

class LessonlogController extends Controller
{
//レッスン履歴
    public function log(){
        if(Auth::check()){
        //言語取得
        $lang = Language::all();
        $lang_tid = 0;
        $data = [
            'lang'=>$lang,
            'lang_tid'=>$lang_tid,
        ];
        //ログインユーザー
        $user_id = Auth::id();
        //今年
        $year = date('Y');

        //教えた(全件)
        $attendid = Attendance::where('attendFlag',1)->get();
        $teachid = $teachid = Lesson::where('user_id',$user_id)->get();
        $teach_now = [0,0,0,0,0,0,0,0,0,0,0,0];
        $teach_back = [0,0,0,0,0,0,0,0,0,0,0,0];
        for($i=1;$i<13;$i++){
            foreach($attendid as $a){
                foreach($teachid as $t){
                    if($a->lesson_id == $t->id){
                        $res = $t->attendDate;
                        $dd = date('n', strtotime($res));
                        $yy = date('Y', strtotime($res));
                        if($i == $dd && $year == $yy){
                            $teach_now[$i-1] = $teach_now[$i-1] + 1;
                        }elseif($i == $dd && $year-1 == $yy){
                            $teach_back[$i-1] = $teach_back[$i-1] + 1;
                        }
                    }
                }
            }
        }

        //受講した(全件)
        $allattend = Attendance::where([['user_id', $user_id],['attendFlag', 1]])->get();
        $attend_now = [0,0,0,0,0,0,0,0,0,0,0,0];
        $attend_back = [0,0,0,0,0,0,0,0,0,0,0,0];
        for($i=1;$i<13;$i++){
            foreach($allattend as $a){
                $id = $a->lesson_id;
                $attend = Lesson::where('id', $id)->first();
                $res = $attend->attendDate;
                $dd = date('n', strtotime($res));
                $yy = date('Y', strtotime($res));
                if($i == $dd && $year == $yy){
                    $attend_now[$i-1] = $attend_now[$i-1] + 1;
                }elseif($i == $dd && $year-1 == $yy){
                    $attend_back[$i-1] = $attend_back[$i-1] + 1;
                }
            }
        }

        
        $data2 = [
            'year'=>$year,
            'attend_now'=>$attend_now,
            'attend_back'=>$attend_back,
            'teach_now'=>$teach_now,
            'teach_back'=>$teach_back,
        ];


        return view('lesson/lesson_log',$data, $data2);
    }else{
        return redirect('/user/login');
    }
    }


    public function lang(Request $req){
        //言語取得
        $lang = Language::all();
        $lang_tid = $req->language;
        $lang_text = Language::where('id', $lang_tid);
        $data = [
            'lang'=>$lang,
            'lang_tid'=>$lang_tid,
            'lang_text'=>$lang_text,
        ];
        

        //ログインユーザー
        $user_id = Auth::id();
        //今年
        $year = date('Y');
        $lang_id = $req->language;

        //教えた(全件)
        $attendid = Attendance::where('attendFlag',1)->get();
        $teachid = Lesson::where([['user_id',$user_id],['language_id',$lang_id]])->get();
        $teach_now = [0,0,0,0,0,0,0,0,0,0,0,0];
        $teach_back = [0,0,0,0,0,0,0,0,0,0,0,0];
        for($i=1;$i<13;$i++){
            foreach($attendid as $a){
                foreach($teachid as $t){
                    if($a->lesson_id == $t->id){
                        $res = $t->attendDate;
                        $dd = date('n', strtotime($res));
                        $yy = date('Y', strtotime($res));
                        if($i == $dd && $year == $yy){
                            $teach_now[$i-1] = $teach_now[$i-1] + 1;
                        }elseif($i == $dd && $year-1 == $yy){
                            $teach_back[$i-1] = $teach_back[$i-1] + 1;
                        }
                    }
                }
            }
        }

        //受講した(全件)
        $allattend = Attendance::where([['user_id', $user_id],['attendFlag', 1]])->get();
        $attend_now = [0,0,0,0,0,0,0,0,0,0,0,0];
        $attend_back = [0,0,0,0,0,0,0,0,0,0,0,0];
        for($i=1;$i<13;$i++){
            foreach($allattend as $a){
                $id = $a->lesson_id;
                $attend = Lesson::where([['id', $id],['language_id',$lang_id]])->first();
                if($attend){
                    $res = $attend->attendDate;
                    $dd = date('n', strtotime($res));
                    $yy = date('Y', strtotime($res));
                    if($i == $dd && $year == $yy){
                        $attend_now[$i-1] = $attend_now[$i-1] + 1;
                    }elseif($i == $dd && $year-1 == $yy){
                        $attend_back[$i-1] = $attend_back[$i-1] + 1;
                    }
                }
            }
        }


        $data2 = [
            'year'=>$year,
            'attend_now'=>$attend_now,
            'attend_back'=>$attend_back,
            'teach_now'=>$teach_now,
            'teach_back'=>$teach_back,
        ];


        return view('lesson/lesson_log',$data, $data2);
    }
}