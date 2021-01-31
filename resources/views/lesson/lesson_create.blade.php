@extends('librarybase')
<?php
//TIMETYPES応急措置
$timetypeName = array();
for ($i = 0; $i < 48; $i++) {
    $timetypeName[] = $timetypeRow[$i]->name;
};
//TIMETYPES応急措置

$showWeek = array(
    '日', '月', '火', '水', '木', '金', '土'
);
?>
@section('title','Create')

@section('heading')
<!-- 言語選択システム start -->
<script>
    function onRadioButtonChange() {
        showOverView();
        // 変数作成
        target = document.getElementById("output");

        @for($i = 1; $i <= 13; $i++)
        radiobtn {
            {
                $i
            }
        } = document.getElementById("radioLang{{ $i }}");
        @endfor
        // 変数作成

        // プレビュー要素の置き換え
        if (radiobtn1.checked == true) {
            target.innerHTML =
                '<img src="{{ asset(' / image / lang1.png ') }}" alt="lang1" class="langSizePreview"><h3 class="m-4" style="font-weight: 900; color:#555555">日本語</h3>';
        }

        @for($i = 2; $i <= count($languageRow); $i++)
        else if (radiobtn {
                {
                    $i
                }
            }.checked == true) {
            target.innerHTML =
                '<img src="{{ asset(' / image / lang ' . $i . '.png ') }}" alt="lang{{ $i }}" class="langSizePreview"><h3 class="m-4" style="font-weight: 900; color:#555555">{{ $languageRow[$i-1]->name }}</h3>';
        }
        @endfor
        // プレビュー要素の置き換え
    }

    function showOverView() {
        var input_message = document.getElementById("form2").value;
        input_message = input_message;
        document.getElementById("out_message").innerHTML = input_message;
    }
</script>
<!-- 言語選択システム end -->
@endsection

@section('content')

<form action="{{ url('/user/lesson/create') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}


    <div style="margin:0 15%;">
        <div class="row">
            <div class="col-sm-6">
                <!-- プレビュー表示 -->
                <div class="card text-center" style="margin:40px 50px 0 50px; padding-top:60px;">
                    <div id="output">
                        <img src="{{ asset('/image/lang13.png') }}" alt="言語未選択" class="langSizePreview">
                        <h3 class="m-4" style="font-weight: 900; color:#999999">言語を選択</h3>
                    </div>
                    <br>
                    <div style="font-size:14px;">概要</div>
                    <div style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC; margin:0 10%; padding:15px;">
                        <div id="out_message"></div>
                    </div>
                    <div class="mt-4" style="font-size:14px;">登録する日付と時間帯</div>
                    <div class="card mr-5 ml-5 mb-5">
                        <br>
                        <p>
                        <div id="span2"></div>
                        </p><br>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" style="width:100%; height:600px; overflow:auto;">
                <!-- ラジオボタン表示 -->
                <div class="m-5">
                    <div class="mb-5">
                        <h6 class="text-danger">Create Lesson</h6>
                        <h2 style="font-weight: 900;">レッスンを募集</h2>
                        <h5 style="font-weight: 400;">レッスンを作成しましょう。<br>募集に使用する内容を入力します。</h5>
                    </div>
                    <div class="mb-2" style="font-weight: bold; ">言語を選ぶ。</div>

                    <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;">
                        <!-- 枠線 -->
                        <div class="row sample1">

                            @for($i = 1; $i <= count($languageRow); $i++) <div class="col-sm-3 pt-1">
                                <input type="radio" name="language_id" id="radioLang{{ $i }}" onchange="onRadioButtonChange();" value="{{ $i }}">
                                <label for="radioLang{{ $i }}"><img src="{{ asset('/image/lang' . $i . '.png') }}" alt="{{ $languageRow[$i-1]->name }}" class="langSize"></label>
                                <div class="langText">{{ $languageRow[$i-1]->name }}</div>
                        </div>
                        @endfor

                    </div>
                    @if($errors->has('language_id'))
                    <tr>
                        <th>
                            <font color="red">*{{$errors->first('language_id')}}</font>
                        </th>
                    </tr>
                    @endif
                </div>


                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="mb-2" style="font-weight: bold; ">概要を書く。</div>
                <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;">
                    <!-- 枠線 -->
                    <!--Basic textarea-->
                    <div class="md-form amber-textarea active-amber-textarea-2">
                        <textarea id="form2" name="intro" class="md-textarea form-control" rows="3"></textarea>
                        <label for="form2">概要を書く。</label>
                    </div>
                    <!--Basic textarea-->
                    @if($errors->has('intro'))
                    <tr>
                        <th>
                            <font color="red">*{{$errors->first('intro')}}</font>
                        </th>
                    </tr>
                    @endif
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="mb-2" style="font-weight: bold; ">日付と時間帯を決める。</div>
                <div class="p-4 text-center bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;">
                    <!-- 枠線 -->
                    <!--Basic textarea-->
                    <div class="md-form textarea active-textarea-2 form-group col-md-12 text-right">
                        <div class="text-center">
                            <button id="tagtag" type="button" class="btn btn-secondry waves-effect" data-toggle="modal" data-target="#modalPreview">
                                カレンダーを開く
                            </button>
                        </div>
                    </div>
                    <!--Basic textarea-->
                    @if($errors->has('dualData'))
                    <tr>
                        <th>
                            <font color="red">*{{$errors->first('dualData')}}</font>
                        </th>
                    </tr>
                    @endif
                </div>

                <div class="mt-5 mb-5" style="border-bottom: 1px solid #BBBBBB;"></div>

                <div class="text-center">
                    <button id="modalActivate" type="button" class="btn btn-primary btn-block waves-effect" data-toggle="modal" data-target="#modalPreview0">登録する</button>
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
                    <h3 class="modal-title" id="modalPreviewLabel0">レッスンを登録します</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding:40px;">
                    <h6 class="pb-5">□登録後、このレッスンは公開されます。<br>□登録したレッスンは、「レッスン一覧」の<br>　「レッスン予定」からご覧になれます。<br>□予約が来た場合、メールが通知されます。<br>□レッスンを開始する場合は、レッスン一覧から<br>　「レッスンを始める」を選択します。</h6>
                    <button type="submit" class="btn btn-primary btn-block waves-effect">OK</button>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- 確定前ポップアップ -->


    </div>

    <!-- 説明のプレビュー(カード)処理 -->
    <div class="modal fade right" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel" aria-hidden="true">
        <div class="modal-dialog modal-fluid" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPreviewLabel">日付と時間帯を決める。</h5>
                </div>
                <div class="modal-body" id="preansNONE">
                    <button type="button" onclick="clickBtn2()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!--ATTENDDATE & TIMETYPE-->
                    <table border="1" class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                @for($i = 0; $i < 14; $i++) 
                                    <?php
                                        $arger = '+' . $i . ' day';
                                        $showDate = date("d", strtotime($arger));
                                        if (substr($showDate, 0, 1) == 0) {
                                            $showDate = substr($showDate, 1, 1);
                                        }
                                        ?>
                                    <th scope="col">{{ $showDate.'日' }}</th>
                                @endfor
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = 0; $i < 48; $i++) <tr>
                                <th scope="row">{{{ $timetypeName[$i] }}}</th>
                                @for($j = 0; $j < 14; $j++) <?php
                                                            $arger = '+' . $j . ' day';
                                                            $showDate = date("Y-m-d", strtotime($arger));
                                                            ?> <td class="text-center">
                                    <div class="cp_ipcheck">
                                        <label>
                                            <input type="checkbox" name="dualData[]" class="option-input02 checkbox" value="{{ $showDate }};{{ $i+1 }};{{ $timetypeName[$i] }}" />
                                        </label>
                                    </div>
                                    </td>
                                    @endfor
                                    </tr>
                                    <tr>
                                        @endfor
                        </tbody>
                    </table>
                    <!--ATTENDDATE & TIMETYPE-->
                    <button type="button" onclick="clickBtn2()" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>

        <!-- 説明のプレビュー(カード)処理 -->

</form>


<style>
    .sample1 input[type="radio"] {
        display: none;
        /* チェックボックスは非表示 */
    }

    /* --- チェックボックス直後のlabel --- */
    .sample1 input[type="radio"]+label {
        display: inline-block;
        margin: 5px;
        /* labelの間隔  */
        opacity: 0.3;
        /* 透明度       */
        cursor: pointer;
        /* カーソル設定 */
        transition: .2s;
        /* なめらか変化 */
        transform: scale(0.9, 0.9);
        /* 少し小さく   */
    }

    /* --- 選択されたチェックボックス直後のlabel --- */
    .sample1 input[type="radio"]:checked+label {
        opacity: 1;
        /* 透明度       */
        transform: scale(1, 1);
        /* 原寸に戻す   */
    }

    /* --- 選択されたチェックボックス直後のlabel --- */
    .sample1 input[type="radio"]:not(:checked)+label:hover {
        opacity: 0.9;
        /* 透明度       */
    }

    .langSizePreview {
        width: 170px;
        /* 言語マーク大 */
    }

    .langSize {
        width: 40px;
        /* 言語マーク   */
    }

    .langText {
        font-size: 13px;
        /* 言語マーク   */
    }

    /* 概要欄 */
    .active-amber-textarea-2 textarea.md-textarea {
        border-bottom: 1px solid #ffa000;
        box-shadow: 0 1px 0 0 #ffa000;
    }

    .active-amber-textarea-2.md-form label.active {
        color: #ffa000;
    }

    .active-amber-textarea-2.md-form label {
        color: #ffa000;
    }

    .active-amber-textarea-2.md-form textarea.md-textarea:focus:not([readonly])+label {
        color: #ffa000;
    }

    /* 概要欄 */
    /* カレンダーのチェックボックス */
    .cp_ipcheck {
        width: 100%;
        /*margin: 2em auto;*/
        /*text-align: left;*/
    }

    @keyframes click-wave {
        0% {
            position: relative;
            width: 30px;
            height: 30px;
            opacity: 0.35;
        }

        100% {
            width: 200px;
            height: 200px;
            margin-top: -80px;
            margin-left: -80px;
            opacity: 0;
        }
    }

    .cp_ipcheck .option-input02 {
        position: relative;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        width: 30px;
        height: 30px;
        cursor: pointer;
        transition: all 0.15s ease-out 0s;
        color: #ffffff;
        border: none;
        outline: none;
        background: #d7cbcb;
        -webkit-appearance: none;
        appearance: none;
    }

    .cp_ipcheck .option-input02:hover {
        background: #d6a9a9;
    }

    .cp_ipcheck .option-input02:checked {
        background: #da3c41;
    }

    .cp_ipcheck .option-input02:checked::before {
        font-size: 20px;
        line-height: 30px;
        position: absolute;
        display: inline-block;
        width: 30px;
        height: 30px;
        content: '✔';
        text-align: center;
    }

    .cp_ipcheck .option-input02:checked::after {
        position: relative;
        display: block;
        content: '';
        -webkit-animation: click-wave 0.65s;
        animation: click-wave 0.65s;
        background: #da3c41;
    }

    .cp_ipcheck .option-input02.radio {
        border-radius: 50%;
    }

    .cp_ipcheck .option-input02.radio::after {
        border-radius: 50%;
    }

    .cp_ipcheck label {
        line-height: 40px;
        display: block;
    }

    .cp_ipcheck .option-input02:disabled {
        cursor: not-allowed;
        background: #b8b7b7;
    }

    .cp_ipcheck .option-input02:disabled::before {
        font-size: 20px;
        line-height: 30px;
        position: absolute;
        display: inline-block;
        width: 30px;
        height: 30px;
        content: '✖︎';
        text-align: center;
    }

    /* カレンダーのチェックボックス */
</style>

@endsection

@section('script')
<script type="text/javascript">
    $(function() {
        $('#tagtag').click(function() {
            var str = $("#form3").val();
            var str2 = str.replace("\n", "<br>");
            $("#preans").html(str2);

        });
    });

    function clickBtn2() {
        showOverView();
        var arr2 = [];
        var checkItem = document.getElementsByName("dualData[]");
        var beforeExp

        for (let i = 0; i < checkItem.length; i++) {
            if (checkItem[i].checked) { //(checkItem[i].checked === true)と同じ
                // arr2.push(checkItem[i].value);
                beforeExp = (checkItem[i].value).split(';');
                arr2 = arr2 + beforeExp[0] + " * 開始時刻 " + beforeExp[2] + "<br>";
            }
        }
        document.getElementById("span2").innerHTML = arr2;
    }
</script>


@endsection