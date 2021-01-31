@extends('layouts.user.app')

@section('content')

<script>
function confirm_test() {
    var select = confirm("よろしいですか？");
    return select;
}
</script>

<form action="{{ url('/allhome/onepass') }}" method="post" enctype="multupart/form-data" onsubmit="return confirm_test()">
{{ csrf_field() }}
    <table align="center">

    @if (session('flash_message2'))
        <div class="flash_message alert alert-success">
            {{ session('flash_message2') }}
        </div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            {{ $error }}</br>
        @endforeach
    </div>
    @endif

    <tr><th>ワンタイムパスワード</th></tr>
        <tr>
            <td>
                <input type="text" name="onepass">
            </td>
        </tr>

    <tr>
        <td>
            <input type="submit" value="OK">
        </td>
    </tr>
</form>
@endsection