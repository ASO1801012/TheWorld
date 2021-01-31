@extends('librarybasead')
@section('title','生徒情報')
@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>学生一覧</h1>
<hr>
<div class="row">
    <!-- 学生一覧 -->
    <div class="col-md-7">
        <form action="{{ url('/student/list') }}" method="post" class="mb-3" style="margin-left:150px;">
        {{csrf_field()}}
            <input type="text" name="number" placeholder="学籍番号を入力">
            <input type="submit" value="検索">
        </form>
        <table border="1" class="table-clickable" style="text-align:center; margin-left:120px;">
            <tr>
                <th>学籍番号</th><th>名前</th><th>学校名</th>
            </tr>
            @foreach($user as $us)
            <tr data-href="{{ url('/student/detail/' . $us->id ) }}">
                <td class="pl-4 pr-4">{{ $us->student_number }}</td>
                <td class="pl-4 pr-4">{{ $us->name }}</td>
                <td class="pl-4 pr-4">{{ $school[$us->school_id-1]->name }}</td>
            </tr>
            @endforeach
        </table>
        {{ $user->links() }}
    </div>

    <!-- 学生登録 -->
    <div class="col-md-5" style="margin-top:50px;">
        <div class="card">
            <div class="card-header">学生登録</div>
            <div class="card-body">
                <form method="post" action="{{ url('/student/create') }}">
                {{ csrf_field() }}
                    <div class="mb-3">
                        <p class="sp">学籍番号</p>
                        <input type="text" name="student_number" id="studnet_number" class="mb-0">
                        @if($errors->has('student_number'))
                        <div class="text-danger" style="font-size:9pt;">{{$errors->first('student_number')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <p class="sp">名前</p>
                        <input type="text" name="name" id="name" class="mb-0">
                        @if($errors->has('name'))
                        <div class="text-danger" style="font-size:9pt;">{{$errors->first('name')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <p class="sp">学校</p>
                        <select name="school" id="school" class="mb-0">
                            <option selected disabled>学校を選択</option>
                            @foreach($school as $school)
                                <option value="{{$school->id}}">{{$school->name}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('school'))
                            <div class="text-danger" style="font-size:9pt;">{{$errors->first('school')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <p class="sp">メールアドレス</p>
                        <input type="text" name="email" id="email" class="mb-0">
                        @if($errors->has('email'))
                        <div class="text-danger" style="font-size:9pt;">{{$errors->first('email')}}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <p class="sp">初期パスワード</p>
                        <input type="text" name="pass" id="pass" class="mb-0">
                        @if($errors->has('pass'))
                        <div class="text-danger" style="font-size:9pt;">{{$errors->first('pass')}}</div>
                        @endif
                    </div>

                    <br>
                    <div style="margin-left:60px;">
                        <input type="submit" value="登録" class="btn btn-primary btn-md">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<br>

<!-- 学生登録(csvインポート) -->
<div class="card" style="width:40%; margin:auto;">
    <div class="card-header">学生登録(csvインポート)</div>
    <div class="card-body">
        <h4>CSVファイルを選択してください</h4>
            <p style="text-align:left; margin-left:100px; margin-bottom:50px;">
            1. CSVで保存します。<br>
            2. ファイル選択し読み込んでください。</p>
        
        <form role="form" method="post" action="{{ url('/student/list/import') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="csv_file" id="csv_file">
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-md btn-success">登録</button>
            </div>
        </form>
    </div>
</div>

@endsection

<!-- スクリプト＆CSS -->
@section('script')
<style>
    .pagination { 
        margin-top:10px;
        justify-content: center; 
    }
    form{
        margin-left:100px;
    }
    .sp{
        font-size:15px;
        margin-bottom:0;
    }

    #studnet_number, #name, #language, #email, #pass{
        width:200px;
        margin-bottom:20px;
    }
    #school{
        margin-bottom:20px;
    }
    
    .card{
        width:80%;
        background: #f0f8ff;
    }
    .card-header{
        background: #87cefa;
    }
  td, th {
            padding: 5px 10px;
        }
 
        th {
            background: #1e90ff;
            color: #fff;
        }
 
        tbody tr:first-child {
            border-top: none;
        }
 
        tbody tr.even td {
            background: #fbfbfb;
        }
 
        tbody tr.clickable:hover td {
            background: #ecf2fa;
            cursor: pointer;
        }
}
</style>
<script>
jQuery( function($) {
    $('tbody tr[data-href]').addClass('clickable').click( function() {
        window.location = $(this).attr('data-href');
    }).find('a').hover( function() {
        $(this).parents('tr').unbind('click');
    }, function() {
        $(this).parents('tr').click( function() {
            window.location = $(this).attr('data-href');
        });
    });
});
</script>
@endsection