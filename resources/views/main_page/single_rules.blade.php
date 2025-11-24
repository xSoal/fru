@extends('layouts.main_page')

@section('content')



<div class="mainImage__cont mainImageNews">
  <div class="mainImage__background">
    <div class="mainImage__black"></div>
    <div class="mainImage__image" style="background: url( {{ $newsItem->image_path }} )"></div>
    <div class="mainImage__filter"></div>
  </div>
  <div class="mainImage__content">
    <div class="container">
      <div class="container-inner">
        <h1 class="h1">{{ str($newsItem->title) }}</h1>
        <div class="manImageText">
          <span class="mainImage__link" title="Категорія: Новини">
            <a href="{{ route('main_page.rules') }}">Правила регулювання</a>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <div class="searchContNews">
    @include('main_page.components.search')
  </div>

  <div class="content">
    <div class="singeNewsCont">
      <div class="singleNewsAside singleNewsAside--authNews">
        <h3 class="h3">Довідкова інформація</h3>
        <a class="authNewsAsideEl" href="{{ route('main_page.support') }}">
          <div class="authNewsAsideEl__text">
            Програма підтримки                    
          </div>
          <div class="authNewsAsideEl__imgCont">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
              
              <line x1="9" y1="12" x2="15" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M12.5 9.5L15 12L12.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
        <a class="authNewsAsideEl" href="{{ route('main_page.rules') }}">
          <div class="authNewsAsideEl__text">
            Правила регулювання                  
          </div>
          <div class="authNewsAsideEl__imgCont">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5"/>
              
              <line x1="9" y1="12" x2="15" y2="12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M12.5 9.5L15 12L12.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
        </a>
      </div>
      <article class="sibgleNewsContent">
        {!! $newsItem->content !!}
      </article>
    </div>
  </div>

</div>



@endsection