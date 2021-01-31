@extends('librarybasead')
@section('title','管理者ホーム')
@section('content')

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>管理者一覧</h1>
<hr>
<div class="row">

    <!-- 管理者一覧 -->
    <div class="col-md-7">
    <form action="{{ url('/admin/list') }}" method="post" class="mb-3" style="margin-left:150px;">
    {{csrf_field()}}
        <input type="text" name="number" placeholder="管理者IDを入力">
        <input type="submit" value="検索">
    </form>

    <table border="1" class="table-clickable" style="text-align:center; margin-left:150px;">
        <tr>
            <th>管理者ID</th><th>名前</th><th>学校名</th>
        </tr>
        @foreach($admin as $ad)
        <tr data-href="{{ url('/admin/detail/' . $ad->id ) }}">
            <td class="pl-4 pr-4">{{ $ad->adminsId }}</td>
            <td class="pl-4 pr-4">{{ $ad->name }}</td>
            <td class="pl-4 pr-4">{{ $school[$ad->school_id-1]->name }}</td>
        </tr>
        @endforeach
    </table>
    {{ $admin->links() }}
    </div>

    <!-- 管理者登録 -->
    <div class="col-md-5" style="margin-top:50px;">
        <div class="card">
            <div class="card-header">管理者登録</div>
            <div class="card-body">
                <form method="post" action="{{ url('/admin/create') }}">
                {{ csrf_field() }}

                <div class="mb-3">
                    <p class="sp">管理者ID</p>
                    <input type="text" name="number" id="number" class="mb-0">
                    @if($errors->has('number'))
                    <div class="text-danger" style="font-size:9pt;">{{$errors->first('number')}}</div>
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
            </div>
        </div>
    </div>
</div>
@endsection

<!-- スクリプト＆CSS -->
@section('script')
<style>
    form{
        margin-left:100px;
    }
    .sp{
        font-size:15px;
        margin-bottom:0;
    }

    #number, #name, #language, #email, #pass{
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