@extends('librarybase')
@section('title','Profile')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<div style="margin:45px 15% 0;">
    <div class="row">
        <div class="col-sm-6"><!-- レッスン表示 -->
            <div class="mt-4">
                <div class="mb-4 text-center">
                    <h5 style="font-weight: 400;">相手のプロフィール</h5>
                </div>
                <div class="p-4 bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                    <div class="row sample1">
                        <div class="col-sm-12 text-center mb-3">
                            <h6 class="text-danger">school name</h6>
                            <div style="font-size:15px;">{{ $schoolRow[($user->school_id)-1]->name }}</div>
                        </div>
                        <div class="col-sm-5 pt-1 text-center">
                            @if( strcmp($user->picturePass,'noImage.png') == 0)
                            <img src="{{ asset('/noimage.png') }}" class="trim-image-to-circle">
                            @else
                            <img src="{{ asset('/storage/' . $user->picturePass ) }}" class="trim-image-to-circle">
                            @endif
                        </div>
                        <div class="col-sm-7 pt-3">
                            <h3 style="font-weight: 900;">{{ $user->name }}</h3>
                            @if( $user->aveReview == 0)
                            評価 : なし<br>
                            @else
                            評価 : <span class="star5_rating" data-rate="{{ $user->aveReview }}"></span><br>
                            @endif
                            言語 : <img src="{{ asset('/image/lang' . $user->language_id . '.png') }}" alt="{{ $languageRow[($user->language_id)-1]->name }}" class="langSizeProfile">
                        </div>

                        <div class="col-sm-12 mt-4 mb-3 text-center">
                            <div style="font-size:14px;">自己紹介</div>
                            <div style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC; margin:0 10%; padding:15px;">
                                <div>{{ $user->intro }}</div>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="text-light" style="font-size:40px;">{{ $user->student_number }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-6" style="width:100%; height:600px; overflow:auto;"><!-- レッスン表示 -->
            <div class="m-5">
                <div class="mb-5">
                    <h6 class="text-danger">Profile Page</h6>
                    <h2 style="font-weight: 900;">プロフィール</h2>
                    <h5 style="font-weight: 400;">{{ $user->name }}さんのプロフィールです。<br>下記は{{ $user->name }}さんが募集中のレッスンです。</h5>
                </div>

                @if(count($lessonRow) == 0)

                <div class="card p-5 m-3 text-center">
                    募集中のレッスンはありません
                </div>

                @else

                @foreach($lessonRow as $row)
                    <div class="card p-4 m-3">
                        <a href="{{ url('/user/lesson/show/' . $row -> id ) }}">
                            <div class="row">
                                <div class="col-sm-4 text-center">
                                    <img src="{{ asset('/image/lang' . $row->language_id . '.png') }}" alt="{{$row->language->name}}" class="langSize">
                                    <div class="langText">{{$row->language->name}}</div>
                                </div>
                                <div class="col-sm-4 p-1 text-center">
                                    <i class="fa fa-2x fa-calendar" aria-hidden="true"></i><br>{{$row->attendDate}}
                                </div>
                                <div class="col-sm-4 p-1 text-center">
                                    <i class="fa fa-2x fa-clock-o" aria-hidden="true"></i><br>{{$row->timetype->name}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach

                @endif

                
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