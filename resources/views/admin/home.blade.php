@extends('librarybasead')
@section('title','管理者ホーム')
@section('content')


<div style="margin:45px 0 0;">
    <div class="row">
        <div class="col-sm-9 text-center" id="home">
            <div style="font-size:50px;font-weight: 900; margin: 0px -350px 0px 0px;">管理者ホーム</div>
        </div>
        <div class="col-sm-3 text-center" id="home">
            <section class="card">
                <div class="card-content">
                    <p class="card-text">総ユーザー数：{{$user}}人</p>
                    <p class="card-text">総レッスン活用回数：{{$attendance}}回</p>
                </div>
            </section>
        </div>
        <div class="col-sm-6 p-5 btner oneer" onclick="location.href='{{url('/student/list')}}'">学生管理</div>
        <div class="col-sm-6 p-5 btner secer" onclick="location.href='{{url('/admin/list')}}'">管理者管理</div>
    </div> 
</div>



    
<style>
#home{
    margin-bottom:100px;
}
.btner{
    text-align: center;
    font-weight: 700;
    font-size: 30px;
    color: 333333;
}
.oneer{
    background-color: AFCFEF;

}
.secer{
    background-color: E6E6E6;

}
.card {
  width: 200px;
  background: #FFFFCC;
  border-radius: 5px;
  box-shadow: 0 2px 5px #ccc;
}
.card-content {
  padding: 20px;
}
.card-text {
  color: #777;
  font-size: 14px;
  line-height: 1.5;
}

</style>
@endsection