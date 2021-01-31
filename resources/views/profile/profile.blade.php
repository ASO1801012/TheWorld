@extends('librarybase')
@section('title','Profile')

@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

<form action="{{ url('/user/profile') }}" method="post" enctype="multipart/form-data">
{{ csrf_field() }}
<input type="hidden" name="id" value="{{$user->id}}">

<div style="margin:45px 15% 0;">
    <div class="row">
        <div class="col-sm-6"><!-- レッスン表示 -->
            <div class="mt-4">
                <div class="mb-4 text-center">
                    <h5 style="font-weight: 400;">現在のプロフィール</h5>
                </div>

                <div class="p-4 bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                    <div class="row sam1">
                        <div class="col-sm-12 text-center mb-3">
                            <h6 class="text-danger">school name</h6>
                            <div style="font-size:15px;">{{ $school[($user->school_id)-1]->name }}</div>
                        </div>
                        <div class="col-sm-5 pt-1 text-center">
                            @if( strcmp($user->picturePass,'noImage.png') == 0)
                            <img src="{{ asset('/noimage.png') }}" class="trim-image-to-circle">
                            @else
<<<<<<< HEAD
                            <!-- <img src="{{ asset('/storage/' . $user->picturePass ) }}" class="trim-image-to-circle"> -->
                            <img src="{{ Storage::url($user->picturePass) }}" class="trim-image-to-circle">
=======
                            <img src="{{ asset('/storage/' . $user->picturePass ) }}" class="trim-image-to-circle">
>>>>>>> 096e46580c86578c7c693e40d398d24a365dc4bf
                            @endif
                        </div>
                        <div class="col-sm-7 pt-3">
                            <h3 style="font-weight: 900;">{{ $user->name }}</h3>
                            @if( $user->aveReview == 0)
                            評価 : なし<br>
                            @else
                            評価 : <span class="star5_rating" data-rate="{{ $user->aveReview }}"></span><br>
                            @endif
                            言語 : <img src="{{ asset('/image/lang' . $user->language_id . '.png') }}" alt="{{ $language[($user->language_id)-1]->name }}" class="langSizeProfile">
                        </div>

                        <div class="col-sm-12 mt-4 mb-3 text-center">
                            <div style="font-size:14px;">自己紹介</div>
                            <div class="card p-4 mx-5 mt-3">
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

        <div class="col-sm-6" style="width:100%; height:600px; overflow:auto;"><!-- 講師表示 -->
            <div class="m-5">
                <div class="mb-5">
                    <h6 class="text-danger">Profile Page</h6>
                    <h2 style="font-weight: 900;">プロフィール</h2>
                    <h5 style="font-weight: 400;">自己紹介をしましょう。<br>編集するには下記に内容を入力します。</h5>
                </div>
                <div class="mb-2" style="font-weight: bold; ">名前を変更する。</div>
                <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                    <div class="md-form">
                        <input type="text" id="form1" name="name" size="15" maxlength="20" class="form-control" value="{{ $user->name }}">
                        <label for="form1">名前を書く。</label>
                    </div>
                    @if($errors->has('name'))
                    <tr><th><font color="red">*{{$errors->first('name')}}</font></th></tr>
                    @endif
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="mb-2" style="font-weight: bold; ">自己紹介を書く。</div>
                <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
<!--                     <textarea name="intro" value="" maxlength="100" value="{{ $user->intro }}">{{$user->intro}}</textarea> -->
                    <div class="md-form amber-textarea active-amber-textarea-2">
                        <textarea id="form2" name="intro" class="md-textarea form-control" rows="3" maxlength="100">{{$user->intro}}</textarea>
                        <label for="form2">概要を書く。</label>
                    </div>
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="mb-2" style="font-weight: bold; ">得意言語を選ぶ。</div>
                <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                    <select name="language_id">
                        @foreach($language as $index)
                            @if($index->id == $user->language_id)
                                <option value="{{ $index->id }}" selected>{{$index->name}}</option>
                            @else
                                <option value="{{ $index->id }}">{{$index->name}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="mb-2" style="font-weight: bold; ">写真を変更する。</div>
                <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                    <form>
                        <input type="file" name="picturePass" id="myImage" accept='image/*' onchange="previewImage(this);">
                    </form>
                    <p>
                    選択した画像：<br>
                    <img id="preview2" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" width="200px" height="100" class="trim-image-to-circle">
                    </p>
                    <script>
                    function previewImage(obj)
                    {
                        var fileReader = new FileReader();
                        fileReader.onload = (function() {
                            document.getElementById('preview2').src = fileReader.result;
                        });
                        fileReader.readAsDataURL(obj.files[0]);
                    }
                    </script>
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block">登録する</button>
                </div>
            </div>
        </div>
    </div>
</div>

</form>

<style>
.sam1 input[type="radio"]:not(:checked) + label:hover {
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