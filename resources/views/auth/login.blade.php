@extends('layouts.front')

@section('content')
<div class="container">

    <div class="popup_body">
        <div class="popup_left">

                <div class="popaup_header">
                    <div class="popup_headline">
                        <h4>Авторизація</h4>
                    </div>
                    
                </div>

                <form action="{{ route('login') }}" class="popup_form sign_in active" method="POST">
                    @csrf
                    <div class="popup_fields sign_in">
                        <div class="popup_field_item">
                            <label for="email">E-mail</label>
                            <input type="text" name="email" id="email" class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>Не вірно введена пошта</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="popup_field_item password">
                            <label for="password">Пароль</label>
                            <input type="password" name="password" id="password" class="@error('password') is-invalid @enderror" required autocomplete="current-password">
                            <span class="pwd_show" id="pwd-show"></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="popup_button sign_in_btn">
                        <span class="popup_button_text">Вхід</span>
                        <img src="/images/icons/arrow-small-next.svg" alt="Вхід">
                    </button>
                </form>

                <div class="popup_bottom">
                    <a href="{{ route('register') }}" class="bottom_btns registration">
                        <span>Реєстрація</span>
                    </a>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="bottom_btns">
                        <span>Забули пароль?</span>
                    </a>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
<div>
@endsection
