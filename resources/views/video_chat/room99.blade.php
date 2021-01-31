@extends('librarybase')
@section('title','LESSON_SHOW')

@section('heading')
<meta charset="UTF-8">
<title>Pusher Testing</title>
<script>
    let localStream;
    
    // camera image acquisition
    navigator.mediaDevices.getUserMedia({video: true, audio: true})
    .then( stream => {
    // On success, the video element is set to a camera image and played back.
    const videoElm = document.getElementById('my-video');
    videoElm.srcObject = stream;
    videoElm.play();
    // Save the camera image to a global variable so that it can be returned to the other party when a call comes in.
    localStream = stream;
    }).catch( error => {
    // Outputs error log in case of failure.
    console.error('mediaDevice.getUserMedia() error:', error);
    return;
    });


    let remoteStream;
    navigator.mediaDevices.getUserMedia({video: true, audio: true})
    .then( stream => {
    // On success, the video element is set to a camera image and played back.
    const videoElm = document.getElementById('their-video');
    videoElm.srcObject = stream;
    videoElm.play();
    // Save the camera image to a global variable so that it can be returned to the other party when a call comes in.
    remoteStream = stream;
    }).catch( error => {
    // Outputs error log in case of failure.
    console.error('mediaDevice.getUserMedia() error:', error);
    return;
    });

    //Peer作成
    const peer = new Peer({
      key: '941cb351-3bd3-4859-bd0d-cbfc7610ef1e',
      debug: 3
    });
    //PeerID取得
    peer.on('open', () => {
        document.getElementById('my-id').textContent = peer.id;
    });
</script>
<!-- AD200106 -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
@endsection

@section('content')

<form action="/user/lesson/room/leave" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="lesson_id" class="" value="{{ $lessonRow->id }}">
<div style="margin:25px 15% 0;">

  <div class="row">
    <div class="col-sm-5 text-center">
        <h6 class="text-danger">Lesson Now</h6>
        <div style="font-size:50px;font-weight: 900;">LESSON</div>
    </div>
    <div class="col-sm-7">
        <h5 class="mt-4" style="font-weight: 400;">レッスン中です。制限時間はありません。<br>終了するには「退室する」を選択します。</h5>
    </div>
  </div>

  <div class="mt-3 p-4 text-center" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
    <div class="row">
      <div class="col-sm-6 text-center">
        <div class="card p-4">
          <div><i class="fa fa-graduation-cap" aria-hidden="true"></i> 講師 <i class="fa fa-graduation-cap" aria-hidden="true"></i></div>
          <video id="my-video" float:left width="400px" autoplay muted playsinline class="m-1 box22"></video>
          <div>{{ $lessonRow->user->name }}</div>
        </div>
      </div>
      <div class="col-sm-6 text-center">
        <div class="card p-4">
          <div><i class="fa fa-user" aria-hidden="true"></i> 受講者 <i class="fa fa-user" aria-hidden="true"></i></div>
          <video id="their-video" float:left width="400px" autoplay muted playsinline class="m-1 box21"></video>
          <div>{{ $attendanceRow->user->name }}</div>
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
                    <h6 class="text-danger">Lesson Now</h6>
                    <h2 style="font-weight: 900;">実行中のレッスン⇨</h2>
                    <h5 style="font-weight: 400;">実行中のレッスンの概要です。</h5>
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="text-center">
                    <button id="modalActivate" type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#modalPreview0">退室する</button>
                </div>
            </div>
    </div>
    <div class="col-sm-6"><!-- レッスン表示 -->
        <div class="card text-center" style="margin:40px 50px 0 50px; padding-top:60px;">
            <div id="output">
                <img src="/image/lang{{ $lessonRow->language_id }}.png" alt="{{ $lessonRow->language->name }}" class="langSizePreview"><h3 class="m-4" style="font-weight: 900; color:#999999">{{ $lessonRow->language->name }}</h3>
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