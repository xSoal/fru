@extends('layouts.main_page')

@section('content')

<div class="mainImage__cont">
  <div class="mainImage__background">
    <div class="mainImage__black"></div>
    <div class="mainImage__image" style="background-image: url( /images/1095814.jpg )"></div>
    <div class="mainImage__filter"></div>
  </div>
  <div class="mainImage__content">
    <div class="container">
      <div class="container-inner">
        <h2 class="h2">Policy</h2>
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
            <?php
              $route = 'main_page.single_rules';
              if($item->type === 'support'){
                $route = 'main_page.single_support';
              }
            ?>
            <a href="{{ route($route, ['slug' => $item->slug]) }}">
              <img src="{{ $item->image_path }}" alt="{{ $item->title }}">
            </a>
          </div>
          <div class="newsTextBlock">
            <div class="newsHrefDate">
              <?php
                $href_text = 'Legislation';
                $route = 'main_page.rules';
                if($item->type === 'support'){
                  $href_text = 'Financial Support Tools';
                  $route = 'main_page.support';
                }
              ?>
              <a href="{{ route($route) }}" class="newsHref">{{ $href_text }}</a>
            </div>
            <div class="newsTitle">
              <h5 class="h5">
                <a href="/{{ $item->type }}/{{ $item->slug }}">
                  {{ $item->title }}
                </a>
              </h5>
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
