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
        <h1 class="h1">{{ str($newsItem->title)->limit(155) }}</h1>
        <div class="manImageText">
          <span class="mainImage__link" title="Категорія: Новини">
            <a href="/news">Новини</a>
          </span>
          <span class="mainImage__date" title="{{ $newsItem->updated_at }}">
            <time datetime="{{ $newsItem->updated_at }}" itemprop="datePublished"> {{ $newsItem->updated_at }} </time>
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
      <div class="singleNewsAside">
        <a href="#" class="mainInfo__el" style="background-image: url('/images/main_page_info/equipment.jpg')">
          <div class="mainInfo__elText">
            <h3 class="h3">Обладнання</h3>
          </div>
        </a>
        <a href="#" class="mainInfo__el" style="background-image: url('/images/main_page_info/more-information.jpg')">
          <div class="mainInfo__elText">
            <h3 class="h3">Сервісне обслуговування</h3>
          </div>
        </a>
        <a href="#" class="mainInfo__el" style="background-image: url('/images/main_page_info/more-information.jpg')">
          <div class="mainInfo__elText">
            <h3 class="h3">Довідкова інформація</h3>
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