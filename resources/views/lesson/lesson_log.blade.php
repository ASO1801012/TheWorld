@extends('librarybase')
@section('title','Log')

@section('content')
<div style="margin:45px 5% 0;">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h6 class="text-danger">Lesson Log</h6>
            <div style="font-size:50px;font-weight: 900;">レッスンの履歴</div>
            <h5 class="mt-3" style="font-weight: 400;">レッスンの履歴を表示します。<br>言語で検索することができます。</h5>
        </div>
    </div>


    <div class="row mt-5 mb-4">
        <div class="col-sm-12">
            
            <div class="card pt-3 pb-5 mb-5">
                <div class="chartWrapper" style="position: relative; margin-top:30px;">
                    <div class="chartContainer" style="height:500px; width:80%; margin-right:auto; margin-left:auto;">
                        <canvas id="chart" style="height:500px;"></canvas>
                    </div>
                </div>
                <div class="text-center">
                    <button id="back" class="btn btn-success">{{$year-1}}年</button>
                    <button id="next" class="btn btn-success">{{$year}}年</button>
                </div>
            </div>
            <div class="mb-2" style="font-weight: bold; ">言語を絞り込む。</div>
            <div class="text-center px-5 pt-4 pb-3 bg-white" style="border: 1px solid; border-radius: 6px; border-color: #CCCCCC;"><!-- 枠線 -->
                <form action="{{ url('/user/lesson/log') }}" method="POST">
                {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-7">
                            <div class="card px-2">
                            <div class="row">
                                <div class="col-sm-6"><!-- ドロップダウン表示 -->
                                    <div class="cp_ipselect cp_sl01" id="language">
                                    <select required name="language"> 
                                        <option value="0">言語を選択</option>
                                        @foreach($lang as $lang)
                                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mt-4">
                                    <input type="submit" value="選択した言語で表示" class="btn btn-info btn-block">
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-5 mt-4 px-5">
                            <div class="btn btn-info btn-block" onclick="location.href='{{url('/user/lesson/log')}}'">全言語で表示</div>
                        </div>
                    </div>

                </form>
            </div>

            
        </div>
    </div>
</div>

<style>
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
</style>

@endsection

@section('script')
<script>
    var attend_now = <?php echo json_encode($attend_now); ?>;
    var attend_back = <?php echo json_encode($attend_back); ?>;
    var teach_now = <?php echo json_encode($teach_now); ?>;
    var teach_back = <?php echo json_encode($teach_back); ?>;

    var attend = attend_now;
    var teach = teach_now;
    onCal();

    document.getElementById('back').onclick = function(){
        if(chart){
            chart.destroy();
        }
        attend = attend_back;
        teach = teach_back;
        onCal();
    };

    document.getElementById('next').onclick = function(){
        if(chart){
            chart.destroy();
        }
        attend = attend_now;
        teach = teach_now;
        onCal();
    };

    function onCal(){
        var ctx = document.getElementById('chart').getContext('2d');
        window.chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['１月', '２月', '３月', '４月', '５月', '６月', '７月', '8月', '9月', '10月', '11月', '12月'],
                datasets: [
                    {
                        label: '受講した',
                        data: attend,
                        backgroundColor: 'rgb(255,0,0,0.9)',
                        borderColor: 'rgb(255,0,0,0.9)'
                    },
                    {
                        label: '教えた',
                        data: teach,
                        backgroundColor: 'rgb(0,128,255,1)',
                        borderColor: 'rgb(0,128,255,1)'
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            suggestedMax: 10,
                            min: 0,
                            fontSize: 18, 
                        },

                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 18,
                        },
                    }],
                },
            },
        });
    }
</script>
@endsection
