@extends('librarybase')
@section('title','ChatRoom')

@section('heading')
<meta charset="UTF-8">
<script type="text/javascript" src="iframe.js?var=1.0"></script>
<style>

.id{{ $group_id }}{
  background-color: #DDDDDD;
}

.rightWindow {
  background-color:#EEEEFF;
}

/* プロフィール画像丸表示 */
.trim-image-to-circle {
    background-image: url("summerriver.jpg");  /* 表示する画像 */
    width:  40px;       /* ※縦横を同値に */
    height: 40px;       /* ※縦横を同値に */
    border-radius: 50%;  /* 角丸半径を50%にする(=円形にする) */
    background-position: left top;  /* 横長画像の左上を基準に表示 */
    display: inline-block;          /* 複数の画像を横に並べたい場合 */
}
/* プロフィール画像丸表示 */

</style>
@endsection

@section('content')

<div class="row mx-5 mt-3">

@if(0!=$data)

<div class="col-sm-3" style="margin-top:20px;">
  <div style="width:100%; height:600px; overflow:auto;">

    <div class="mb-3">
        <h6 class="text-danger">Chat Room</h6>
        <h2 style="font-weight: 900;">チャット</h2>
        <h5 style="font-weight: 300;">学籍番号や名前で検索する事で新たな生徒と会話を始めることができます。</h5>
    </div>


    <form name="user_search" method="get" action="{{ url('/user/user_search') }}"><!-- 検索ボックスボタン -->
      @csrf
      <table style="width:100%">
        <tr>
          <td><input type="text" class="search form-control" name="search" id="search" type="text" placeholder="学籍番号 or 名前"></td>
          <td><button type="submit" class="btn btn-success waves-effect"><i class="fas fa-search"></i></button></td>
        </tr>
      </table>
    </form>

    <div class="p-4 bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->

      @foreach($data as $th)<!-- トークリスト -->
        <form  name="get_mes" method="post" action="{{ url('/user/get_mes/' . $th->id ) }}">
          @csrf
          <input type="hidden" name="group_id" id="group_id" value="{{$th->id}}">
          <input type="hidden" name="your_id" value="{{$th->userid}}">
          
          <button type="submit" class="id{{ $th->id }} card px-4 py-3" style="width:100%">
            <div><!-- 改行防止タグ -->
              @if( strcmp($th->picturePass,'noImage.png') == 0)
                <img src="{{ asset('/noimage.png') }}" class="trim-image-to-circle"> 
              @else
                <img src="{{ asset('/storage/' . $th->picturePass ) }}" class="trim-image-to-circle"> 
              @endif
              <span class="ml-2">{{$th->username}}</span>
            </div>
          </button>
        </form>
      @endforeach

    </div>

  </div>
</div>

<div class="col-sm-9">

  <div class="chat card px-4 py-2 rightWindow" id="chat" style="height:550px;overflow: scroll;"><!-- 右側 -->

    @foreach($mes_data as $aa)<!-- メッセージウィンドウ -->
      @if($my_id == $aa->user_id)
        <div class="card" style="margin:10px 0 10px auto; background-color: #AADDAA; padding: 10px;">
          {{$aa->intro}}
        </div>
      @else
        <div class="card" style="margin:10px auto 10px 0; background-color: #F7F7F7; padding: 10px;">
          {{$aa->intro}}
        </div>
      @endif
    @endforeach

  </div>

  <div class="send"><!-- テキストエリアと送信ボタン -->

    <form name="send_mes" method="post" action="{{ url('/user/send_mes') }}">
      @csrf
      <input type="hidden" name="group_id" value="{{$group_id}}">

      <div class="card py-2 mt-3 rightWindow">
        <div class="row">
          <div class="col-sm-1"></div>
          <div class="col-sm-9">
            <textarea rows="1" class="form-control" name="chatsend" id="chatsend" placeholder="送信メッセージ"></textarea>
          </div>
          
          <div class="col-sm-1">
            <button type="button" name="sent-bt" class="btn btn-primary btn-block p-2" onclick="return chk(this.form)" />
              <i class="fa fa-paper-plane" aria-hidden="true"></i>
            </button>
          </div>
          <div class="col-sm-1"></div>
        </div>
      </div>


    </form>
    
  </div>

</div>

@else

<div class="col-sm-3">
  <div style="width:100%; height:600px; overflow:auto;">

    <div class="mb-3">
        <h6 class="text-danger">Chat Room</h6>
        <h2 style="font-weight: 900;">チャット</h2>
        <h5 style="font-weight: 300;">学籍番号や名前で検索する事で新たな生徒と会話を始めることができます。</h5>
    </div>

    <form name="user_search" method="get" action="{{ url('/user/user_search') }}"><!-- 検索ボックスボタン -->
      @csrf
      <table style="width:100%">
        <tr>
          <td><input type="text" class="search form-control" name="search" id="search" type="text" placeholder="学籍番号 or 名前"></td>
          <td><button type="submit" class="btn btn-success waves-effect"><i class="fas fa-search"></i></button></td>
        </tr>
      </table>
    </form>

    <button  class="card px-4 py-3" style="width:90%">
      <span class="name">トーク相手がいません。</span>
    </button>

  </div>
</div>

<div class="col-sm-9">

  <div class="chat card px-4 py-3 rightWindow" id="chat" style="height:550px;overflow: scroll;"></div><!-- 右側 -->

  <div class="card py-2 mt-3 rightWindow">
    <div class="row">
      <div class="col-sm-1"></div>
      <div class="col-sm-9">
        <textarea rows="1" class="form-control" name="chatsend" id="chatsend" placeholder="相手がいません。"></textarea>
      </div>
      
      <div class="col-sm-1">
        <button name="sent-bt" class="btn btn-primary btn-block p-2">
          <i class="fa fa-paper-plane" aria-hidden="true"></i>
        </button>
      </div>
      <div class="col-sm-1"></div>
    </div>
  </div>
  
</div>

@endif

</div>

<script>
  function chk(frm) {
    if (frm.elements["chatsend"].value == "") {
      alert("テキストボックスに入力してください");
    } else if (frm.elements["group_id"].value == "") {
      alert("ユーザーを選択してください");
    } else {
      /* submitメソッドでフォーム送信 */
      frm.submit();
    }
  }

  var obj = document.getElementById("chat");
  obj.scrollTop = obj.scrollHeight;
</script>
<!--     <script>
    function mes(frm_2){
      var mes
      mes= document.getElementById("group_id").value;
      frm_2.submit(mes);
    }
  </script> -->

@endsection