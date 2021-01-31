<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonCreateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Language;
use App\Models\Timetype;
use App\Mail\lesson_schedule;
use Illuminate\SUpport\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class RoomController extends Controller
{
    public function indexA($lesson_id=0) {   // ビデオチャットページ講師側

        $lesson = Lesson::find($lesson_id);
        $others = User::where('id', '=', $lesson->user_id)->pluck('name', 'id');

        $user = Auth::user();
        
        return view('video_chat.room')->with([
            'user' => collect($user->only(['id', 'name'])),
            'others' => $others,
            'lessonRow' => $lesson
        ]);

    }

    public function indexB($lesson_id=0) {   // ビデオチャットページ受講者側

        $lesson = Lesson::find($lesson_id);
        $attendance = Attendance::where('lesson_id',$lesson_id)->first();
        $others = User::where('id', '=', $attendance->user_id)->pluck('name', 'id');

        $user = Auth::user();
        
        return view('video_chat.room')->with([
            'user' => collect($user->only(['id', 'name'])),
            'others' => $others,
            'lessonRow' => $lesson
        ]);

    }

    public function auth(Request $request) {    // Pusherの認証
        try {
            $user = $request->user();
            $socket_id = $request->socket_id;
            $channel_name = $request->channel_name;
            $pusher = new Pusher(
                config('broadcasting.connections.pusher.key'),
                config('broadcasting.connections.pusher.secret'),
                config('broadcasting.connections.pusher.app_id'),
                [
                    'cluster' => config('broadcasting.connections.pusher.options.cluster'),
                    'encrypted' => true
                ]
            );
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
        return response(
            $pusher->presence_auth($channel_name, $socket_id, $user->id)
        );
    }
}
