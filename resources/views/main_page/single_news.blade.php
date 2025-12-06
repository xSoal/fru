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
            <a href="/news">Новини</a>
          </span>
          <span class="mainImage__date" title="{{ $newsItem->public_date_format }}">
            <time datetime="{{ $newsItem->public_date }}" itemprop="datePublished"> {{ $newsItem->public_date_format }} </time>
          </span>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container single">
  <div class="searchContNews">
    @include('main_page.components.search')
  </div>

  <div class="content">
    <div class="singeNewsCont">
      <div class="singleNewsAside">
        <a 
          @if( auth()->user() && auth()->user()->role == 1 )
            href="/companyAdmin/equipment/{{ auth()->user()->id }}"
          @elseif( auth()->user() && auth()->user()->role == 0)
            href="/clientAdmin/{{ auth()->user()->id }}"
          @elseif( auth()->user() && auth()->user()->role == 3)
            href="/superAdmin/equipment"
          @else
            href="{{ route('login') }}"
          @endif
          class="mainInfo__el" style="background-image: url('/images/main_page_info/equipment.jpg')">
            <div class="mainInfo__elText">
            <h3 class="h3">Обладнання</h3>
          </div>
        </a>
        <a 
          @if( auth()->user() && auth()->user()->role == 1 )
            href="/companyAdmin/{{ auth()->user()->id }}"
          @elseif( auth()->user() && auth()->user()->role == 0)
            href="/clientAdmin/{{ auth()->user()->id }}"
          @elseif( auth()->user() && auth()->user()->role == 3)
            href="#"
          @else
            href="{{ route('login') }}"
          @endif
          class="mainInfo__el" style="background-image: url('/images/main_page_info/more-information.jpg')">
          <div class="mainInfo__elText">
            <h3 class="h3">Дилери та сервіс</h3>
          </div>
        </a>
        <a href="{{ route('main_page.reference') }}" class="mainInfo__el" style="background-image: url('/images/main_page_info/more-information.jpg')">
          <div class="mainInfo__elText">
            <h3 class="h3">Фінансові інструменти підтримки</h3>
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