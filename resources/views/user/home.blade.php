@extends('librarybase')

@section('title','Home')

@section('content')


<div style="margin:45px 0 0;">
    <div class="row">
        <div class="col-sm-12 text-center mb-4">
            <h6 class="text-danger">HOME</h6>
            <div style="font-size:50px;font-weight: 900;">HOME</div>
            <h5 class="mt-3" style="font-weight: 400;">レッスンを募集するなら「レッスン登録」、<br>レッスンを予約するなら「レッスン検索」を選択しましょう！ <i class="fa fa-question-circle-o text-primary waves-effect" aria-hidden="true" data-toggle="modal" data-target="#helpPop"></i></h5>
        </div>
        <div class="col-sm-6 p-5 btner oneer waves-effect" onclick="location.href='{{url('/user/lesson/create')}}'">レッスン登録</div>
        <div class="col-sm-6 p-5 btner secer waves-effect" onclick="location.href='{{url('/user/lesson/search')}}'">レッスン検索</div>
        <div class="col-sm-6 p-5 btner secer waves-effect" onclick="location.href='{{url('/user/profile')}}'">プロフィール</div>
        <div class="col-sm-6 p-5 btner oneer waves-effect" onclick="location.href='{{url('/user/chat')}}'">チャット</div>
        <div class="col-sm-6 p-5 btner oneer waves-effect" onclick="location.href='{{url('/user/lesson/list')}}'">レッスン一覧</div>
        <div class="col-sm-6 p-5 btner secer waves-effect" onclick="location.href='{{url('/user/lesson/log')}}'">レッスン履歴</div>
    </div> 
</div>

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
        <h5>□レッスン登録</h5>
        <h6>......新しくレッスンを募集します。教えたい方はこちらから！</h6><br>
        <h5>□レッスン検索</h5>
        <h6>......募集中のレッスンを検索します。教わりたい方はこちらから！</h6><br>
        <h5>□プロフィール</h5>
        <h6>......あなたのプロフィールを自由にカスタマイズします。</h6><br>
        <h5>□チャット</h5>
        <h6>......他の生徒とトークができます。</h6><br>
        <h5>□レッスン一覧</h5>
        <h6>......自分が教える、教わる全てのレッスンを管理します。レッスンの開始もこちらから！</h6><br>
        <h5>□レッスン履歴</h5>
        <h6>......自分の今までのレッスン累計数を表示します。</h6><br>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ヘルプポップアップ -->



    
<style>

.btner{
    text-align: center;
    font-weight: 700;
    font-size: 30px;
    color: 333333;
}
.oneer{
    background-color: BFDFFF;

}
.secer{
    background-color: E6E6E6;

}


</style>
@endsection
