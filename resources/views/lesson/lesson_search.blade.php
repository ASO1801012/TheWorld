@extends('librarybase')
@section('title','Search')


@section('content')

<form action="{{ url('/user/lesson/search') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div style="margin:45px 15% 0;">

        <div class="row">
            <div class="col-sm-12 text-center">
                <h6 class="text-danger">Search Lesson</h6>
                <div style="font-size:50px;font-weight: 900;">レッスンを検索する</div>
                <h5 class="mt-3" style="font-weight: 400;">レッスンを検索します。<br>検索に使用する条件を選択します。</h5>
            </div>
        </div>


        <div class="row mt-4 mb-4">

            <div class="col-sm-4"><!-- ドロップダウン表示 -->
                <div class="cp_ipselect cp_sl01">
                <select required name="language_id">
                    <option value="0">言語を選択</option>
                    @for($i = 1; $i <= count($languageRow); $i++)
                        <option value="{{ $i }}">{{ $languageRow[$i-1]->name }}</option>
                    @endfor
                </select>
                </div>
            </div>
            <div class="col-sm-4"><!-- ドロップダウン表示 -->
                <div class="cp_ipselect cp_sl01">
                <select required name="attendDate">
                    <option value="0">日付を選択</option>
                    @for($i = 0; $i <= 14; $i++)
                        <?php
                            $arger = '+'.$i.'day';
                            $showDate = date("Y-m-d",strtotime($arger));
                        ?>
                        <option value="{{ $showDate }}">{{ $showDate }}</option>
                    @endfor
                </select>
                </div>
            </div>
            <div class="col-sm-4"><!-- ドロップダウン表示 -->
                <div class="cp_ipselect cp_sl01">
                <select required name="timetype_id"> 
                    <option value="0">時間帯を選択</option>
                    @for($i = 1; $i <= count($timetypeRow); $i++)
                        <option value="{{ $i }}">{{ $timetypeRow[$i-1]->name }}</option>
                    @endfor
                </select>
                </div>
            </div>

        </div>


        <div class="text-center" style="margin:0 25% 45px;">
            <button type="submit" class="btn btn-primary btn-block">検索する ></button>
        </div>

        <!-- 検索結果 -->

        @if(isset($lessonRow))

        <div>
            <h5>検索結果 {{ count($lessonRow) }} 件</h5>
            @if(count($lessonRow) == 0)
                <div class="card p-5 m-3 text-center">
                    レッスンは見つかりませんでした。
                </div>
            @else
                @foreach($lessonRow as $row)
                <div class="card p-4 m-3">
                    <a href="{{ url('/user/lesson/show/' . $row -> id ) }}">
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <img src="{{ asset('/image/lang' . $row->language_id . '.png') }}" alt="{{$row->language->name}}" class="langSize">
                                <div class="langText">{{$row->language->name}}</div>
                            </div>
                            <div class="col-sm-3 p-1 text-center">
                                <i class="fa fa-2x fa-calendar" aria-hidden="true"></i><br>{{$row->attendDate}}
                            </div>
                            <div class="col-sm-3 p-1 text-center">
                                <i class="fa fa-2x fa-clock-o" aria-hidden="true"></i><br>{{$row->timetype->name}}
                            </div>
                            <div class="col-sm-3 text-center">
                                <div class="langText text-muted" style="position: absolute; bottom: 0; right: 0;">
                                
                                    @if( $row->aveReview == 0 )
                                    講師 : {{$row->user->name}} （評価なし）
                                    @else
                                    講師 : {{$row->user->name}} <span class="star5_rating" data-rate="{{$row->aveReview}}"></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            @endif
        </div>

        @endif

        <!-- 検索結果 -->
    </div>
</form>


<style>
.langSize {
    width: 40px;                /* 言語マーク   */
}
.langText {
    font-size: 13px;                /* 言語マーク   */
}

/* 3つのドロップダウン  */
.cp_ipselect {
	overflow: hidden;
	width: 90%;
	margin: 2em auto;
	text-align: center;
}
.cp_ipselect select {
	width: 100%;
	padding-right: 1em;
	cursor: pointer;
	text-indent: 0.01px;
	text-overflow: ellipsis;
	border: none;
	outline: none;
	background: transparent;
	background-image: none;
	box-shadow: none;
	-webkit-appearance: none;
	appearance: none;
}
.cp_ipselect select::-ms-expand {
    display: none;
}
.cp_ipselect.cp_sl01 {
	position: relative;
	border: 1px solid #bbbbbb;
	border-radius: 2px;
	background: #ffffff;
}
.cp_ipselect.cp_sl01::before {
	position: absolute;
	top: 0.8em;
	right: 0.9em;
	width: 0;
	height: 0;
	padding: 0;
	content: '';
	border-left: 6px solid transparent;
	border-right: 6px solid transparent;
	border-top: 6px solid #666666;
	pointer-events: none;
}
.cp_ipselect.cp_sl01 select {
	padding: 8px 38px 8px 8px;
	color: #666666;
}
/* 3つのドロップダウン  */

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

@endsection