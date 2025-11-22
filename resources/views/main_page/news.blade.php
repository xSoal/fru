@extends('layouts.main_page')

@section('content')

<div class="mainImage__cont">
  <div class="mainImage__background">
    <div class="mainImage__black"></div>
    <div class="mainImage__image" style="background-image: url( /images/pexels-rezwan-1145434.jpg )"></div>
    <div class="mainImage__filter"></div>
  </div>
  <div class="mainImage__content">
    <div class="container">
      <div class="container-inner">
        <h2 class="h2">Новини</h2>
      </div>
    </div>
  </div>
</div>

<div class="content">

</div>


<div class="container">
  <div class="container-inner">
    <div class="row">

      <div class="searchContNews">
        @include('main_page.components.search')
      </div>

      <div class="mainNews allNews">
        @foreach ($news as $item)
        <div class="news">
          <div class="newsImage">
            <a href="/news/{{ $item->slug }}">
              <img src="{{ $item->image_path }}" alt="{{ $item->title }}">
            </a>
          </div>
          <div class="newsTextBlock">
            <div class="newsHrefDate">
              <a href="/news" class="newsHref">Новини</a>
              <span class="newsDate">{{ $item->public_date_format }}</span>
            </div>
            <div class="newsTitle">
              <h5 class="h5">
                <a>
                  {{ $item->title }}
                </a>
              </h5>
            </div>
            <div class="newsContent">
              {{ Str::words(strip_tags($item->content), 30, '...') }}
            </div>
          </div>
          
        </div>
        @endforeach
      </div>

      <div class="allNews__navCont">
        {{ $news->links() }}
      </div>
    </div>
  </div>
</div>


@endsection

