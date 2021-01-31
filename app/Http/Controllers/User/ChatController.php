<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Group;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Language;
use App\Models\Timetype;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Validator;
use DateTime;

class ChatController extends Controller
{
    public function chat_mes()
    {
        return view('chat_mes');
    }

    public function user_search(Request $req)
    {
        $search = $req->search;
        $query = User::query();
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('student_number', 'like', '%' . $search . '%');
        }
        $data = $query->get();
        foreach( $data as $i ){

            $i -> aveReview = 0;
            $revSys0 = Lesson::where([
                ['user_id','LIKE',$i->id],
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
                $i -> aveReview = $retData;
            };

        }
        $seedData = $this -> getSeedData();
        return view('chat.search')->with([
            "data" => $data,
            'schoolRow'=>$seedData[0],
            'languageRow'=>$seedData[1],
            'timetypeRow'=>$seedData[2]
        ]);
    }

    public function group_make($id=0)
    {
        /* $friend_id=$req->friend_id; */
        $friend_id=$id;
        $group = new group;
        $my_id = auth::id();
        $group_get = Group::all();
        $validator = Validator::make([],[]); 
        foreach($group_get as $g){
            if($my_id == $g->user_id1 && $friend_id == $g->user_id2 || $friend_id == $g->user_id1 && $my_id == $g->user_id2){
                $validator->errors()->add('group','このユーザーとはすでにつながっています');
                return back()->withinput()->witherrors($validator);
            }else if($my_id == $friend_id){
                $validator->errors()->add('group','自分とチャットグループを作ることはできません');
                return back()->withinput()->witherrors($validator);
            }
        }

        $group->user_id1 = $my_id;
        $group->user_id2 = $friend_id;
        $group->save();

        $whoAmI = auth::user();
        $groupA = Group::orderBy("updated_at","desc")->take(1)->get();
        $message = new message;
        $message -> intro = "(".$whoAmI->name."さんが新しくチャットを始めました。)";
        $message -> user_id = $whoAmI->id;
        $message -> group_id = $groupA[0]->id;
        $message -> save();


        return redirect('/user/chat');
    }

    /*自分が所属するグループテーブルid全件取得
    (id1、id2どちらも参照して一致したテーブルを取り出す)*/
    public function chat(Request $req)
    {
        $group_t = Message::query();
        $my_id = auth::id();
        $data = DB::select('
            SELECT
            groups.id,
            CASE
            WHEN user_id1 = ? THEN user_id2
            WHEN user_id2 = ? THEN user_id1
            END as userid,
            CASE
            WHEN user_id1 = ? THEN users2.name
            WHEN user_id2 = ? THEN users1.name
            END as username
            FROM groups
            INNER JOIN users as users1 ON groups.user_id1 = users1.id
            INNER JOIN users as users2 ON groups.user_id2 = users2.id
            WHERE user_id1 = ? OR user_id2 = ?
            ORDER BY groups.updated_at DESC
            ', [$my_id, $my_id, $my_id, $my_id, $my_id, $my_id]
        );
        /* $data->orderBy('updated_at','desc'); */
        if (!empty($data)){
            $group_id = $data[0]->id;
            foreach($data as $i){
                $picturePassBef = User::find($i->userid);
                $i->picturePass = $picturePassBef->picturePass;
            } 
            $group_t->where('group_id', $group_id);
            $mes_data = $group_t->get();
            return view('chat.chat')->with([
                "mes_data" => $mes_data,
                "data" => $data,
                "my_id" => $my_id,
                "group_id" => $group_id,
            ]);
        }else{
            $data=0;
            $mes_data=0;
            $group_id=0;
            return view('chat.chat')->with([
                "mes_data" => $mes_data,
                "data" => $data,
                "my_id" => $my_id,
                "group_id" => $group_id,
            ]);
        }
    }

    public function send_mes(Request $req)
    {
        $mes = new Message;
        $my_id = auth::id();
        $mes_in = $req->chatsend;
        $group = $req->group_id;
        $mes->intro = $mes_in;
        $mes->user_id = $my_id;
        $mes->group_id = $group;

        Group::where('id', $group)->update(['updated_at' => new DateTime()]);

        $mes->save();

        return redirect('/user/chat');
    }

    public function get_mes(Request $req)
    {
        $group_id = $req->group_id;

        /*
        $group_t = Message::query();
        $group_t->where('group_id', $group_id)
        ->orderBy('updated_at', 'desc');
        $mes_data = $group_t->get();
*/
        $mes_data = Message::where('group_id', $group_id)->get();


        $my_id = auth::id();
        $data = DB::select('
            SELECT
            groups.id,
            CASE
            WHEN user_id1 = ? THEN user_id2
            WHEN user_id2 = ? THEN user_id1
            END as userid,
            CASE
            WHEN user_id1 = ? THEN users2.name
            WHEN user_id2 = ? THEN users1.name
            END as username
            FROM groups
            INNER JOIN users as users1 ON groups.user_id1 = users1.id
            INNER JOIN users as users2 ON groups.user_id2 = users2.id
            WHERE user_id1 = ? OR user_id2 = ?     
            ORDER BY groups.updated_at DESC  
            ', [$my_id, $my_id, $my_id, $my_id, $my_id, $my_id]
        );
        foreach($data as $i){
            $picturePassBef = User::find($i->userid);
            $i->picturePass = $picturePassBef->picturePass;
        } 
        return view('chat.chat')->with([
            "mes_data" => $mes_data,
            "data" => $data,
            "group_id" => $group_id,
            "my_id" => $my_id,
        ]);
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
