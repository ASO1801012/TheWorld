@extends('layouts.user.app')

@section('content')

<form action="{{ url('/allhome/forgot') }}" method="post" enctype="multupart/form-data">
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

    <tr><th>学籍番号</th></tr>
        <tr>
            <td>
                <input type="text" name="student_number">
            </td>
        </tr>

    <tr><th>メールアドレス</th></tr>
        <tr>
            <td>
                <input type="email" name="email">
            </td>
        </tr>

    <tr>
        <td>
            <input type="submit" value="OK">
        </td>
    </tr>
</form>
@endsection