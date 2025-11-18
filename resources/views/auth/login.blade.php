@extends('layouts.main_page')

@section('content')


<div class="mainImage__cont">
    <div class="mainImage__background">
      <div class="mainImage__black"></div>
      <div class="mainImage__image" style="background-image: url( /images/login.jpg )"></div>
      <div class="mainImage__filter"></div>
    </div>
    <div class="mainImage__content">
      <div class="container">
        <div class="container-inner">
          <h2 class="h2">Авторизація</h2>
        </div>
      </div>
    </div>
</div>

<div class=" loginCont">
    <div class="login-container">
        <form  action="{{ route('login') }}" class="login-form" method="POST">
            @csrf
            <h2>Вхід</h2>
            <label for="username">Логін *</label>
            <input type="text" id="username" name="email" required placeholder="Будь ласка, заповніть поле">
            <label for="password">Пароль *</label>
            <div class="password-wrapper">
                <input type="password" id="password" name="password" required placeholder="Будь ласка, заповніть поле">
                <span class="toggle-password">
                    <img src="/images/icons/eye.svg">
                </span>
            </div>
            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Запам’ятати мене</label>
            </div>
            <button type="submit">Увійти</button>
        </form>
    </div>
    
</div>

{{-- 
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
<div> --}}



@endsection
