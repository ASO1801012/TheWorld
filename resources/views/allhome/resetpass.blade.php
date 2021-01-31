@extends('layouts.user.app')

@section('content')

<script>
function confirm_test() {
    var select = confirm("よろしいですか？");
    return select;
}
</script>

<form action="{{ url('/allhome/resetpass') }}" method="post" enctype="multupart/form-data" onsubmit="return confirm_test()">
{{ csrf_field() }}
    <table align="center">
    

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            {{ $error }}</br>
        @endforeach
    </div>
    @endif

    @if (session('flash_message'))
        <div class="flash_message alert alert-danger">
            {{ session('flash_message') }}
        </div>
    @endif

    <input type="hidden" name="id" value="{{session("user")->id}}">

    <tr><th>you</th></tr>
        <tr>
            <td>
                {{ session("user")->name}}
            </td>
        </tr>

    <tr><th>新しいパスワード</th></tr>
        <tr>
            <td>
                <input type="text" name="new_pass">
            </td>
        </tr>

    <tr><th>新しいパスワード（確認）</th></tr>
        <tr>
            <td>
                <input type="text" name="confirmation_pass">
            </td>
        </tr>

    <tr>
        <td>
            <input type="submit" value="OK">
        </td>
    </tr>
</form>

@endsection