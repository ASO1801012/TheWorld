@extends('librarybase')
@section('title','List')

<div class="tab_wrap">
	<input id="tab1" type="radio" name="tab_btn" checked>
	<input id="tab2" type="radio" name="tab_btn">
	<input id="tab3" type="radio" name="tab_btn">
	<input id="tab4" type="radio" name="tab_btn">
 
	<div class="tab_area">
 		<label class="tab1_label" for="tab1"><i class="fa fa-4x fa-user" aria-hidden="true"></i><br>受講前</label>
 		<label class="tab2_label" for="tab2"><i class="fa fa-4x fa-balance-scale" aria-hidden="true"></i><br>受講後</label>
 		<label class="tab3_label" for="tab3"><i class="fa fa-4x fa-graduation-cap" aria-hidden="true"></i><br>レッスン予定</label>
		<label class="tab4_label" for="tab4"><i class="fa fa-4x fa-balance-scale" aria-hidden="true"></i><br>レッスン後</label>
 	</div>
 	<div class="panel_area">
 		<div id="panel1" class="tab_panel"><!-- ============== tab0 ============== -->
			<div style="margin:0 15% 0;">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h6 class="text-danger">Lesson list</h6>
						<div style="font-size:50px;font-weight: 900;">受講前のレッスン一覧</div>
						<h5 class="mt-3" style="font-weight: 400;">受講予定のレッスンの一覧です。<br>詳細を見るには選択します。</h5>
					</div>
				</div>
				<!-- 検索結果 -->
				@if(isset($lessonRow0))

				<div>
					<h5> {{ count($lessonRow0) }} 件</h5>
					@foreach($lessonRow0 as $row)
					@if($row->attendDanger == '0')
					<div class="card p-4 m-3">
					@else
					<div class="card p-4 m-3 alert-danger">
					@endif
						<a href="{{ url('/user/lesson/detail_0/' . $row -> id ) }}">
							<div class="row">
								<div class="col-sm-3 text-center">
									<img src="{{ asset('/image/lang' . $row->language_id . '.png') }}" alt="{{$row->language->name}}" class="langSize">
									<div class="langText">{{$row->language->name}}</div>
								</div>
								@if($row->attendDanger == '0')
								<div class="col-sm-3 p-1 text-center">
								@else
								<div class="col-sm-3 p-1 text-center text-danger">
								@endif
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
				</div>

				@endif
			</div>

		</div>
		
 		<div id="panel2" class="tab_panel"><!-- ============== tab1 ============== -->
		 	<div style="margin:0 15% 0;">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h6 class="text-danger">Lesson list</h6>
						<div style="font-size:50px;font-weight: 900;">受講後のレッスン一覧</div>
						<h5 class="mt-3" style="font-weight: 400;">受講の修了したレッスンの一覧です。<br>詳細を見るには選択します。</h5>
					</div>
				</div>
				<!-- 検索結果 -->
				@if(isset($lessonRow1))

				<div>
					<h5> {{ count($lessonRow1) }} 件</h5>
					<div class="row">
						@foreach($lessonRow1 as $row)
						<div class="col-sm-10">
							<div class="card p-4 my-3">
								<a href="{{ url('/user/lesson/detail_1/' . $row -> id ) }}">
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
						</div>
						<div class="col-sm-2">
							<div class="card p-4 my-3">
								@if($row->review == 0)
								<div id="modalActivate" type="button" data-toggle="modal" data-target="#exampleModalPreview{{ $row->id }}"><!-- ポップアップボタン -->
									<div class="p-1 text-center">
										<i class="fa fa-2x fa-star-o" aria-hidden="true"></i><br>評価する
									</div>
								</div>
								@else
								<div class="p-2 text-center">
									<span class="star5_rating" data-rate="{{$row->review}}"></span><br>評価済
								</div>
								@endif
							</div>
						</div>

						<!-- 評価前ポップアップ -->
						<div class="modal fade right" id="exampleModalPreview{{ $row->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalPreviewLabel{{ $row->id }}" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalPreviewLabel{{ $row->id }}">講師（{{$row->user->name}}）を評価する</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form action="{{ url('/user/lesson/review') }}" method="post" enctype="multipart/form-data">
									{{ csrf_field() }}
									<input type="hidden" name="lesson_id" class="" value="{{ $row->id }}">
									<div class="modal-body pt-5"><!-- ポップアップ内容 -->
										<div class="evaluation">
											<input id="star1{{ $row->id }}" type="radio" name="review" value="5" />
											<label for="star1{{ $row->id }}"><span class="text">5</span>★</label>
											<input id="star2{{ $row->id }}" type="radio" name="review" value="4" />
											<label for="star2{{ $row->id }}"><span class="text">4</span>★</label>
											<input id="star3{{ $row->id }}" type="radio" name="review" value="3" />
											<label for="star3{{ $row->id }}"><span class="text">3</span>★</label>
											<input id="star4{{ $row->id }}" type="radio" name="review" value="2" />
											<label for="star4{{ $row->id }}"><span class="text">2</span>★</label>
											<input id="star5{{ $row->id }}" type="radio" name="review" value="1" />
											<label for="star5{{ $row->id }}"><span class="text">1</span>★</label>
										</div>
									</div>
									<div class="modal-footer">
										<button type="submit" class="btn btn-primary">評価する</button>
									</div>
								</form>
							</div>
						</div>
						</div>
						<!-- 評価前ポップアップ -->
						@endforeach
					</div>
				</div>

				@endif
			</div>
		</div>
		
 		<div id="panel3" class="tab_panel"><!-- ============== tab2 ============== -->
		 	<div style="margin:0 15% 0;">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h6 class="text-danger">Lesson list</h6>
						<div style="font-size:50px;font-weight: 900;">レッスン予定のレッスン一覧</div>
						<h5 class="mt-3" style="font-weight: 400;">レッスン（教える）予定のレッスンの一覧です。<br>詳細を見るには選択します。</h5>
					</div>
				</div>
				<!-- 検索結果 -->
				@if(isset($lessonRow2))

				<div>
					<h5> {{ count($lessonRow2) }} 件</h5>
					<div class="row">
						@foreach($lessonRow2 as $row)
						<div class="col-sm-10">
							@if($row->attendDanger == '0')
							<div class="card p-4 m-3">
							@else
							<div class="card p-4 m-3 alert-danger">
							@endif
								<a href="{{ url('/user/lesson/detail_2/' . $row -> id ) }}">
									<div class="row">
										<div class="col-sm-3 text-center">
											<img src="{{ asset('/image/lang' . $row->language_id . '.png') }}" alt="{{$row->language->name}}" class="langSize">
											<div class="langText">{{$row->language->name}}</div>
										</div>
										@if($row->attendDanger == '0')
										<div class="col-sm-3 p-1 text-center">
										@else
										<div class="col-sm-3 p-1 text-center text-danger">
										@endif
											<i class="fa fa-2x fa-calendar" aria-hidden="true"></i><br>{{$row->attendDate}}
										</div>
										<div class="col-sm-3 p-1 text-center">
											<i class="fa fa-2x fa-clock-o" aria-hidden="true"></i><br>{{$row->timetype->name}}
										</div>
										<div class="col-sm-3 text-center">
											<div class="langText text-muted" style="position: absolute; bottom: 0; right: 0;">
												講師 : あなた
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-sm-2">					
							@if($row->attendUser == '0')
								<div class="card p-4 my-3 bg-light">
									<div class="p-1 text-center">
										受講者<br>なし
									</div>
								</div>
							@else
								<a href="{{ url('/user/yourProfile/' . $row->attendUserId ) }}">	
									@if($row->attendDanger == '0')
									<div class="card p-4 my-3">
									@else
									<div class="card p-4 my-3 alert-danger">
									@endif
										<div class="p-2 text-center">
											受講者<br>{{$row->attendUser}}
										</div>
									</div>
								</a>
							@endif
						</div>
						@endforeach
					</div>
				</div>

				@endif
			</div>
 		</div>


		<div id="panel4" class="tab_panel"><!-- ============== tab3 ============== -->
			<div style="margin:0 15% 0;">
				<div class="row">
					<div class="col-sm-12 text-center">
						<h6 class="text-danger">Lesson list</h6>
						<div style="font-size:50px;font-weight: 900;">レッスン後のレッスン一覧</div>
						<h5 class="mt-3" style="font-weight: 400;">レッスン（教えた）後のレッスンの一覧です。<br>詳細を見るには選択します。</h5>
					</div>
				</div>
				<!-- 検索結果 -->
				@if(isset($lessonRow3))

				<div>
					<h5> {{ count($lessonRow3) }} 件</h5>
					<div class="row">
						@foreach($lessonRow3 as $row)
						<div class="col-sm-10">
							<div class="card p-4 m-3">
								<a href="{{ url('/user/lesson/detail_3/' . $row -> id ) }}">
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
												講師 : あなた
											</div>
										</div>
									</div>
								</a>
							</div>
						</div>
						<div class="col-sm-2">
							@if($row->attendUser == '0')
								<div class="card p-4 my-3 bg-light">
									<div class="p-1 text-center">
										受講者<br>なし
									</div>
								</div>
							@else
								<a href="{{ url('/user/yourProfile/' . $row->attendUserId ) }}">
									<div class="card p-4 my-3">
										<div class="p-2 text-center">
											受講者<br>{{$row->attendUser}}
										</div>
									</div>
								</a>
							@endif
						</div>
						@endforeach
					</div>
				</div>

				@endif
			</div>

		</div>

 	</div>
</div>

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

/* 評価ラジオ */

.evaluation{
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
}
.evaluation input[type='radio']{
  display: none;
}
.evaluation label{
  position: relative;
  padding: 10px 10px 0;
  color: gray;
  cursor: pointer;
  font-size: 50px;
}
.evaluation label .text{
  position: absolute;
  left: 0;
  top: 0;
  right: 0;
  text-align: center;
  font-size: 12px;
  color: gray;
}
.evaluation label:hover,
.evaluation label:hover ~ label,
.evaluation input[type='radio']:checked ~ label{
  color: #ffcc00;
}

/* 評価ラジオ */

/* タブシステム */

.tab_wrap{ margin:80px auto 20px;}
input[type="radio"]{display:none;}
.tab_area{font-size:0; margin:0 10px;}
.tab_area label{width:24%; height:90px; margin:0 5px; display:inline-block; padding:12px 0; color:#AAA; background:#CFEFFF; text-align:center; font-size:13px; cursor:pointer; transition:ease 0.2s opacity;}
.tab_area label:hover{opacity:0.5;}
.panel_area{background:#fff;}
.tab_panel{width:100%; padding:80px 0; display:none;}
.tab_panel p{font-size:40px; letter-spacing:1px; text-align:center;}
 
#tab1:checked ~ .tab_area .tab1_label{background:#fff; color:#000;}
#tab1:checked ~ .panel_area #panel1{display:block;}
#tab2:checked ~ .tab_area .tab2_label{background:#fff; color:#000;}
#tab2:checked ~ .panel_area #panel2{display:block;}
#tab3:checked ~ .tab_area .tab3_label{background:#fff; color:#000;}
#tab3:checked ~ .panel_area #panel3{display:block;}
#tab4:checked ~ .tab_area .tab4_label{background:#fff; color:#000;}
#tab4:checked ~ .panel_area #panel4{display:block;}


.evaluation{
  display: flex;
  flex-direction: row-reverse;
  justify-content: center;
}
.evaluation input[type='radio']{
  display: none;
}
.evaluation label{
  position: relative;
  padding: 10px 10px 0;
  color: gray;
  cursor: pointer;
  font-size: 50px;
}
.evaluation label .text{
  position: absolute;
  left: 0;
  top: 0;
  right: 0;
  text-align: center;
  font-size: 12px;
  color: gray;
}
.evaluation label:hover,
.evaluation label:hover ~ label,
.evaluation input[type='radio']:checked ~ label{
  color: #ffcc00;
}

#modal-content{
	width:50%;
	margin:1.5em auto 0;
	padding:10px 20px;
	border:2px solid #aaa;
	background:#fff;
	z-index:2;
}

.modal-p{
	margin-top:1em;
}

.modal-p:first-child{
	margin-top:0;
}

.button-link{
	color:#00f;
	text-decoration:underline;
}
 
.button-link:hover{
	cursor:pointer;
	color:#f00;
}

/* タブシステム */

</style>
	