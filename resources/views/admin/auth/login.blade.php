@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="card" style="width:50%; margin-top:150px;">
            <div class="card-header" style="background-color:#1565C0; color:white;">{{ __('Login') }}</div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="adminsId" class="col-md-4 col-form-label text-md-right">{{ __('管理者ID') }}</label>

                        <div class="col-md-6">
                            <input id="adminsId" type="text" class="form-control @error('adminsId') is-invalid @enderror" name="adminsId" value="{{ old('adminsId') }}" required autofocus>

                            @error('adminsId')
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
                            <button type="submit" class="btn btn-primary" style="background-color:#1565C0;">
                                {{ __('Login') }}
                            </button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
