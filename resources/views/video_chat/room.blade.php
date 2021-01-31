@extends('librarybase')
@section('title','Lesson Now...')

@section('heading')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<style>

    video {
        width: 100%
    }

</style>
@endsection

@section('content')

<form action="{{ url('/user/lesson/room/leave') }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="lesson_id" class="" value="{{ $lessonRow->id }}">
<div id="app" style="margin:25px 15% 0;">

  <div class="row">
    <div class="col-sm-5 text-center">
        <h6 class="text-danger">Lesson Now</h6>
        <div style="font-size:50px;font-weight: 900;">LESSON</div>
    </div>
    <div class="col-sm-7">
        <h5 class="mt-4" style="font-weight: 400;">レッスン中です。制限時間はありません。<br>終了するには「退室する」を選択します。<i class="fa fa-question-circle-o text-primary" aria-hidden="true" data-toggle="modal" data-target="#helpPop"></i></h5>
    </div>
  </div>

  <div class="mt-3 p-4 text-center" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
    <div class="row">
      <div class="col-sm-6 text-center">
        <div class="card p-4">
          <div><i class="fa fa-graduation-cap" aria-hidden="true"></i> あなたの映像 <i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
          <video ref="video-here" autoplay class="m-1 box22"></video>
        </div>
      </div>
      <div class="col-sm-6 text-center">
        <div class="card p-4">
          <div><i class="fa fa-user" aria-hidden="true"></i> 相手の映像 <i class="fa fa-user" aria-hidden="true"></i></div>
          <video ref="video-there" autoplay class="m-1 box21"></video>
        </div>
      </div>
      <div class="col-sm-12 text-center">
        <div class="mt-3 p-4 text-center" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;">
          <div v-for="(name,userId) in others">
            <a id="autoBtn" href="#" @click.prevent="startVideoChat(userId)" class="btn btn-primary">「@{{ name }}」さんと映像を接続する</a>
          </div>
        </div>
      </div>
    </div>
  </div>


  <p id="my-id"></p>
  <p id="their-id"></p>

  <div class="row">
    <div class="col-sm-6">
    <div class="m-5">
                <div class="mb-5">
                    <h6 class="text-danger">Lesson Info</h6>
                    <h2 style="font-weight: 900;">実行中のレッスン⇨</h2>
                    <h5 style="font-weight: 400;">右記は実行中のレッスンの概要です。<br><br>□注意事項□<br>レッスン中は「ログアウト」と「MENU」はご利用いただけません。<br>一度レッスンを終了するか、ブラウザバックにてこのページから一度離脱していただく必要があります。</h5>
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="text-center">
                    <button id="modalActivate" type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalPreview0">退室する</button>
                </div>
            </div>
    </div>
    <div class="col-sm-6"><!-- レッスン表示 -->
        <div class="card text-center" style="margin:40px 50px 0 50px; padding-top:60px;">
            <div id="output">
                <img src="{{ url('/image/lang' . $lessonRow->language_id . '.png') }}" alt="{{ $lessonRow->language->name }}" class="langSizePreview"><h3 class="m-4" style="font-weight: 900; color:#999999">{{ $lessonRow->language->name }}</h3>
            </div>
            <br>
            <div style="font-size:14px;">概要</div>
            <div style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC; margin:0 10%; padding:15px;">
                <div>{{ $lessonRow->intro }}</div>
            </div>
            <div class="mt-4" style="font-size:14px;">日付と時間帯</div>
            <div class="card mr-5 ml-5 mb-5 pt-3">
                <br><p>{{ $lessonRow->attendDate }}  {{ $lessonRow->timetype->name }}</p><br>
            </div>
        </div>
    </div>

  </div>



</div>

<!-- 確定前ポップアップ -->
<div class="modal fade right" id="modalPreview0" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel0" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modalPreviewLabel0">レッスンを終了します</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="padding:40px;">
                <h6 class="pb-5">□終了後、このレッスンは「終了後」に移動されます。<br>□終了したレッスンは、再度受けることができません。</h6>
                <button id="leave-room" type="submit" class="btn btn-danger btn-block" data-toggle="modal" data-target="#modalPreview0">終了する</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!-- 確定前ポップアップ -->

</form>

<!-- ヘルプポップアップ -->
<div class="modal fade right" id="helpPop" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalPreviewLabel"><i class="fa fa-question-circle-o" aria-hidden="true"></i> HELP</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h5>□なかなかビデオチャットが繋がらない場合</h5>
        <h6> 「「〇〇」さんと映像を接続する」ボタンを押した後に相手がビデオチャットルームに入るとビデオチャットが開始するようになっています。<br>画面を再ロードし、「「〇〇」さんと映像を接続する」ボタンを押していただくと改善される場合があります。</h6><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ヘルプポップアップ -->

<script src="{{ url('/js/app.js') }}"></script>
<script>

new Vue({
    el: '#app',
    data: {
        pusher: {
            key: '{{ config('broadcasting.connections.pusher.key') }}',
            cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}' 
        },
        user: {!! $user !!},
        others: {!! $others !!},
        channel: null,
        stream: null,
        peers: {}
    },
    methods: {
        startVideoChat(userId) {

            console.log(this.pusher.key);
            console.log("61::newView");
            this.getPeer(userId, true);

        },
        getPeer(userId, initiator) {

            if(this.peers[userId] === undefined) {

                let peer = new Peer({
                    initiator,
                    stream: this.stream,
                    trickle: false
                });
                peer.on('signal', (data) => {

                        this.channel.trigger('client-signal-'+ userId, {
                            userId: this.user.id,
                            data: data
                        });

                    })
                    .on('stream', (stream) => {

                        const videoThere = this.$refs['video-there'];
                        videoThere.srcObject = stream;

                    })
                    .on('close', () => {

                        const peer = this.peers[userId];

                        if(peer !== undefined) {

                            peer.destroy();

                        }

                        delete this.peers[userId];
                    });

                this.peers[userId] = peer;

            }

            return this.peers[userId];

        }
    },
    mounted() {

        // エラー表示できます。
        // Pusher.logToConsole = true;

        // カメラ、音声にアクセス
        navigator.mediaDevices.getUserMedia({ video: true, audio: true })
            .then((stream) => {

                const videoHere = this.$refs['video-here'];
                videoHere.srcObject = stream;
                this.stream = stream;

                // Pusher の準備
                const pusher = new Pusher(this.pusher.key, {
                    authEndpoint: "{{ url('/user/lesson/auth/video_chatA') }}",
                    cluster: this.pusher.cluster,
                    auth: {
                        headers: {
                            'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]').content
                        }
                    }
                });
                console.log('Pusherの準備end');
                this.channel = pusher.subscribe('presence-video-chat');
                this.channel.bind('client-signal-'+ this.user.id, (signal) => {

                    const userId = signal.userId;
                    const peer = this.getPeer(userId, false);
                    peer.signal(signal.data);

                });

            });

    }
});

// document.getElementById('autoBtn').click();
</script>
  
<style>
.sample1 input[type="radio"]:not(:checked) + label:hover {
  opacity    : 0.9;             /* 透明度       */
}

.langSizePreview {
    width: 170px;               /* 言語マーク大 */
}
.langSizeProfile {
    width: 30px;                /* 言語マーク   */
}
.langSize {
    width: 40px;                /* 言語マーク   */
}
.langText {
    font-size: 13px;                /* 言語マーク   */
}

/* 概要欄 */
.active-amber-textarea-2 textarea.md-textarea {
  border-bottom: 1px solid #00a0ff;
  box-shadow: 0 1px 0 0 #00a0ff;
}
.active-amber-textarea-2.md-form label.active {
  color: #00a0ff;
}
.active-amber-textarea-2.md-form label {
  color: #00a0ff;
}
.active-amber-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
  color: #00a0ff;
}
/* 概要欄 */


/* ビデオの枠線 */
.box21{
    padding: 0.5em 1em;
    background: -moz-linear-gradient(#ffb03c, #ff708d);
    background: -webkit-linear-gradient(#ffb03c, #ff708d);
    background: linear-gradient(to right, #ffb03c, #ff708d);
    color: #FFF;
}
.box21 p {
    margin: 0; 
    padding: 0;
}

.box22{
    padding: 0.5em 1em;
    background: -moz-linear-gradient(#3cb0ff, #8d70ff);
    background: -webkit-linear-gradient(#3cb0ff, #8d70ff);
    background: linear-gradient(to right, #3cb0ff, #8d70ff);
    color: #FFF;
}
.box22 p {
    margin: 0; 
    padding: 0;
}
/* ビデオの枠線 */
</style>

@endsection