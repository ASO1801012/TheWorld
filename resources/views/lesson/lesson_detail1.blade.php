@extends('librarybase')
@section('title','LessonInfo')

@section('heading')
<script>
</script>
@endsection

@section('content')

<input type="hidden" name="lesson_id" class="" value="{{ $lessonRow->id }}">

<div style="margin:45px 15% 0;">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h6 class="text-danger">Lesson Detail</h6>
            <div style="font-size:50px;font-weight: 900;">レッスン詳細</div>
            <h5 class="mt-3" style="font-weight: 400;">レッスンの詳細です。</h5>
        </div>
    </div>


    <div class="row">
        <div class="col-sm-6"><!-- レッスン表示 -->
            <div class="card text-center" style="margin:40px 50px 0 50px; padding-top:60px;">
                <div id="output">
                    <img src="{{ asset('/image/lang' . $lessonRow->language_id . '.png') }}" alt="{{ $lessonRow->language->name }}" class="langSizePreview"><h3 class="m-4" style="font-weight: 900; color:#999999">{{ $lessonRow->language->name }}</h3>
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

        <div class="col-sm-6" style="width:100%;"><!-- 講師表示 -->
            <div class="mt-4">
                <div class="mb-4 text-center">
                    <h5 style="font-weight: 400;">このレッスンの講師</h5>
                </div>
                <a href="{{ url('/user/yourProfile/' . $lessonRow->user->id ) }}" class="waves-effect">
                    <div class="p-4 bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                        <div class="row sample1">
                            <div class="col-sm-12 text-center mb-3">
                                <h6 class="text-danger">school name</h6>
                                <div style="font-size:15px;">{{ $schoolRow[($lessonRow->user->school_id)-1]->name }}</div>
                            </div>
                            <div class="col-sm-5 pt-1 text-center">
                                <img src="{{ asset('/storage/' . $lessonRow->user->picturePass) }}" class="trim-image-to-circle">
                            </div>
                            <div class="col-sm-7 pt-3">
                                <h3 style="font-weight: 900;">{{ $lessonRow->user->name }}</h3>
                                @if( $lessonRow->aveReview == 0)
                                評価 : なし<br>
                                @else
                                評価 : <span class="star5_rating" data-rate="{{ $lessonRow->aveReview }}"></span><br>
                                @endif
                                言語 : <img src="/image/lang{{ $lessonRow->user->language_id }}.png" alt="{{ $languageRow[($lessonRow->user->language_id)-1]->name }}" class="langSizeProfile">
                            </div>

                            <div class="col-sm-12 mt-4 mb-3 text-center">
                                <div style="font-size:14px;">自己紹介</div>
                                <div style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC; margin:0 10%; padding:15px;">
                                    <div>{{ $lessonRow->user->intro }}</div>
                                </div>
                            </div>

                            <div class="text-center">
                                <div class="text-light" style="font-size:40px;">{{ $lessonRow->user->student_number }}</div>
                            </div>

                        </div>
                    </div>
                </a>
                <div class="mt-5 text-center">
                    <div>このレッスンは終了しました。</div>
                </div>
            </div>
        </div>
    </div>

</div>

</div>


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

/* プロフィール画像丸表示 */
.trim-image-to-circle {
    background-image: url("summerriver.jpg");  /* 表示する画像 */
    width:  140px;       /* ※縦横を同値に */
    height: 140px;       /* ※縦横を同値に */
    border-radius: 50%;  /* 角丸半径を50%にする(=円形にする) */
    background-position: left top;  /* 横長画像の左上を基準に表示 */
    display: inline-block;          /* 複数の画像を横に並べたい場合 */
}
/* プロフィール画像丸表示 */

/* 星 */
.star5_rating{
    position: relative;
    z-index: 0;
    display: inline-block;
    white-space: nowrap;
    color: #CCCCCC; /* グレーカラー 自由に設定化 */
    /*font-size: 30px; フォントサイズ 自由に設定化 */
}

.star5_rating:before, .star5_rating:after{
    content: '★★★★★';
}

.star5_rating:after{
    position: absolute;
    z-index: 1;
    top: 0;
    left: 0;
    overflow: hidden;
    white-space: nowrap;
    color: #ffcf32; /* イエローカラー 自由に設定化 */
}
<?php
$rateValue = 5.0;
$widthValue = 100;
for ($i = 0; $i < 50; $i++) {
    print ".star5_rating[data-rate='".$rateValue."']:after{ width: ".$widthValue."%; }";
    $rateValue -= 0.1;
    $widthValue -= 2;
};
?>


/* 星 */

</style>

@endsection

@section('script')
<script type="text/javascript">
    $(function(){
        $('#tagtag').click(function(){
            var str = $("#form3").val();
            var str2 = str.replace("\n","<br>");
            $("#preans").html(str2);
            
        });
    });

     function clickBtn2(){
        showOverView();
        var arr2 = [];
        var checkItem = document.getElementsByName("dualData[]");
        var beforeExp

        for (let i = 0; i < checkItem.length; i++){
            if(checkItem[i].checked){ //(checkItem[i].checked === true)と同じ
                // arr2.push(checkItem[i].value);
                beforeExp = (checkItem[i].value).split(';');
                arr2 = arr2 + beforeExp[0] + " * 開始時刻 " + beforeExp[2] + "<br>";
            }
        }
        document.getElementById("span2").innerHTML = arr2;
    } 
</script>


@endsection