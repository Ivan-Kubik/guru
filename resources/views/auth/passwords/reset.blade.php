@extends('layouts.app')

@section('content')
<div class="block_login">
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1>Сброс пароля</h1>
            </div>
            <div class="col-md-12 form_login">
                <form method="POST" action="{{ route('password.update') }}" class="login-form">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <label for="email">E-Mail адрес
                    <input id="email" type="email" class="@error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </label>
                    
                    <label for="password">Пароль
                    <input id="password" type="password" class="@error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    </label>
                    
                    <label for="password-confirm">
                    Повторите пароль
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password">
                    </label>
                    <button type="submit" id="login-submit-button">Изменить пароль</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
