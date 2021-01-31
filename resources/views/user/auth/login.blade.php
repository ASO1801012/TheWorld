@extends('layouts.user.app')
@section('title','LogIn')
@section('content')
<div class="container">

<div class="row">

    <div class="col-sm-12">

        <div class="row justify-content-center">
                <div class="card" style="width:50%; margin-top:170px;">
                    <div class="card-header" style="background-color:#009688; color:white;">{{ __('Login') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="student_number" class="col-md-4 col-form-label text-md-right">{{ __('学籍番号') }}</label>

                                <div class="col-md-6">
                                    <input id="student_number" type="text" class="form-control @error('student_number') is-invalid @enderror" name="student_number" value="{{ old('student_number') }}" required autofocus>

                                    @error('student_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('パスワード') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                <div><a href="{{ url('/allhome/forgot') }}">パスワードを忘れた方はこちら</a></div>
                                    <button type="submit" class="btn btn-primary"style="background-color:#009688;">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
        </div>

    </div>

</div>



@endsection
