@extends('layouts.main_page')

@section('content')

<div class="mainImage__cont">
    <div class="mainImage__background">
      <div class="mainImage__black"></div>
      <div class="mainImage__image" style="background-image: url( /images/contacts.jpg )"></div>
      <div class="mainImage__filter"></div>
    </div>
    <div class="mainImage__content">
      <div class="container">
        <div class="container-inner">
          <h2 class="h2">Зворотній звʼязок</h2>
        </div>
      </div>
    </div>
</div>
  
<div class="contacts">
    <div class="container content ">
        <div class="container-inner">
            <div class="">
                <section class="contact-section">
                    <div class="contact-container">
                
                        <!-- Левая колонка -->
                        <div class="contact-left">
                            <div class="contact-block">
                                <h3>Адреса</h3>
                                <p>м. Київ, вул. Михайла Коцюбинського, 1</p>
                            </div>
                
                            <div class="contact-block">
                                <h3>Приймальня</h3>
                                <p>+38 (044) 251-70-10</p>
                            </div>
                
                            <div class="contact-block">
                                <h3>Соцмережі</h3>
                                <div class="socials">
                                    <a href="#"><img src="/images/icons/facebook.svg" alt=""></a>
                                    <a href="#"><img src="/images/icons/youtube.svg" alt=""></a>
                                    <a href="#"><img src="/images/icons/linkedin.svg" alt=""></a>
                                </div>
                            </div>
                        </div>
                
                        <!-- Правая колонка -->
                        <div class="contact-right">
                            <h2 class="contact-title">Якщо є питання</h2>
                            <p class="contact-subtitle">
                                Ми виступаємо експертами у питаннях, пов'язаних з бізнес-кліматом, 
                                а також щодо специфічних індустріальних напрямків.
                            </p>
                
                            <form class="contact-form">
                                <input type="text" placeholder="Ваше ім'я">
                
                                <div class="form-row">
                                    <input type="email" placeholder="E-mail">
                                    <input type="text" placeholder="Мобільний">
                                </div>
                
                                <textarea placeholder="Повідомлення"></textarea>
                
                                <button type="submit" class="contact-btn">Відправити</button>
                            </form>
                        </div>
                
                    </div>
                </section>
                
            </div>
        </div>
    </div>
</div>


@endsection