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
              {{ str(strip_tags($item->content))->limit(250) }}
            </div>
          </div>
          
        </div>
        @endforeach
      </div>



      {{-- <div class="sppb-row-column  " id="column-wrap-id-qCmls4dMU-mLechCMP-NG">
        <div id="column-id-qCmls4dMU-mLechCMP-NG" class="sppb-column ">
          <div class="sppb-column-addons">
            <div id="sppb-addon-wrapper-3ZjBFfYXJGOuuWor4CUZi" class="sppb-addon-wrapper  addon-root-articles">
              <div id="sppb-addon-3ZjBFfYXJGOuuWor4CUZi" class="clearfix  ">
                <div class="sppb-addon sppb-addon-articles latest-fru">
                  <div class="sppb-addon-content">
                    <style>
                      .sppb-addon-articles .sppb-addon-article-layout-editorial-row {
                        display: grid;
                        grid-template-columns: repeat(3, 1fr);
                      }

                      @media (max-width: 1200px) {
                        .sppb-addon-articles .sppb-addon-article-layout-editorial-row {
                          grid-template-columns: repeat(3, 1fr);
                        }
                      }

                      @media (max-width: 992px) {
                        .sppb-addon-articles .sppb-addon-article-layout-editorial-row {
                          grid-template-columns: repeat(3, 1fr);
                        }
                      }

                      @media (max-width: 768px) {
                        .sppb-addon-articles .sppb-addon-article-layout-editorial-row {
                          grid-template-columns: repeat(2, 1fr);
                        }
                      }

                      @media (max-width: 575px) {
                        .sppb-addon-articles .sppb-addon-article-layout-editorial-row {
                          grid-template-columns: repeat(1, 1fr);
                        }
                      }
                    </style>
                    <div class="sppb-row sppb-addon-article-layout-editorial-row ">
                      @foreach ($news as $item)
                      <div class="sppb-addon-article-layout  sppb-addon-article-layout-editorial-wrapper">
                        <div class="sppb-addon-article sppb-addon-article-layout-content  sppb-addon-article-layout-editorial-content">
                          <a class="sppb-article-img-wrap" href="/news/{{ $item->slug }}" itemprop="url">
                            <img class="sppb-img-responsive" src="{{ $item->image_path }}" alt="Промисловий Рамштайн: зустріч з європейськими асоціаціями виробників верстатів на виставці ЕМО Hannover 2025" itemprop="thumbnailUrl" loading="lazy">
                          </a>
                          <div class="sppb-article-info-wrap" role="article">
                            <div class="sppb-article-meta">
                              <span class="sppb-meta-category">
                                <a href="/news" itemprop="genre">Новини</a>
                              </span>
                              <time datetime="{{ $item->created_at }}" class="sppb-meta-date sppb-meta-date-unmodified">{{ $item->created_at }}</time>
                            </div>
                            <h5>
                              <a href="/news/{{ $item->slug }}" itemprop="url">{{ $item->title }}</a>
                            </h5>
                          </div>
                        </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> --}}
      <div class="allNews__navCont">
        {{ $news->links() }}
      </div>
    </div>
  </div>
</div>


@endsection

