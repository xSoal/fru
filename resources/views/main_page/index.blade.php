@extends('layouts.main_page')

@section('content')


<div class="container main_page">
  <div class="container-inner">

    <div class="mainInfo">
      <div class="mainInfo__left">
        <div class="mainInfo__leftFullRow">
          <a class="mainInfo__el" style="background-image: url('/images/main_page_info/equipment.jpg')">
            <div class="mainInfo__elText">
              <h3 class="h3 mainInfo__leftFullRowHeader">Обладнання</h3>
              <p>Перелік техніки і обладнання іноземного виробництва, якого потребують українські підприємства</p>
            </div>
          </a>
        </div>
        <div class="mainInfo__leftDoubleRow">
          <a href="#" class="mainInfo__el" style="background-image: url('/images/main_page_info/service-discussion.jpg')">
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
      </div>
      <div class="mainInfo__right">
        <div class="mainInfo__el" >
          <video class="mainInfo__rightVideo" autoplay muted playsinline loop poster='/images/main_page_info/ir.jpg' >
            <source src="/images/main_page_info/clip-01.mp4" type="video/mp4">
          </video>
          <div class="mainInfo__elText">
            <h3 class="h3">Роль ФРУ</h3>
            <div class="mainInfo__elRightText">
              Допомога в отриманні підприємствами втраченого обладнання на вигідних умовах
            </div>
            <a class="mainInfo__button" target="_blank" href="https://helpdesk.fru.ua/promyslovyy-ramshtain" >Детальніше</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<section>
  <div class="mainSecondBlock">
    <div class="container">
      <div class="container-inner">
        <div class="maindSecondBlockHeader">
          <h2 class="h2">Новини</h2>
          <a class="buttonGreenArrow" href="/news" >
            Всі новини 
            <i class="fas fa-arrow-right" aria-hidden="true"></i>
          </a>
        </div>
        <div class="mainNews">
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
                <span class="newsDate">{{ $item->created_at }}</span>
              </div>
              <div class="newsTitle">
                <h5 class="h5">
                  <a>
                    {{ $item->title }}
                  </a>
                </h5>
              </div>
            </div>
            
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>




<section class="ramstein">
  <div class="ramstein__container">

      <div class="ramstein__left">
          <h2 class="ramstein__title">Промисловий<br>Рамштайн</h2>

          <p class="ramstein__desc">
              Ідея – об’єднати іноземних партнерів у коаліцію, яка за прикладом Ukraine
              Defense Contact Group (Ramstein) допомагатиме Україні долати наслідки
              російської агресії на виробничому фронті.
          </p>

          <p class="ramstein__desc">
              Мета – отримання постраждалими підприємствами України критично необхідного
              для їхньої виробничої діяльності обладнання на вигідних умовах – з дисконтом
              або у вигляді матеріально-технічної допомоги, з частковою або повною
              компенсацією коштами донорських організацій, урядових програм та інших джерел.
          </p>

          <div class="ramstein__cards">
              <div class="ramstein-card">
                  <img src="/images/info_favicon.svg" class="ramstein-card__logo" alt="">
                  <div class="ramstein-card__text">
                      <h4>ФРУ</h4>
                      <span>Федерація роботодавців України</span>
                  </div>
                  <a href="#" class="ramstein-card__link">Перейти →</a>
              </div>

              <div class="ramstein-card">
                  <img src="/images/info_favicon.svg" class="ramstein-card__logo" alt="">
                  <div class="ramstein-card__text">
                      <h4>Help Desk</h4>
                      <span>Сервіси для бізнесу</span>
                  </div>
                  <a href="#" class="ramstein-card__link">Перейти →</a>
              </div>
          </div>
      </div>

      <div class="ramstein__right">
          <img src="/images/metal-gears.jpg" alt="">
      </div>

  </div>
</section>


{{-- <section id="section-id-hXbc2ksHo84OfFaa4ZDox" class="sppb-section">
    <div class="sppb-row-container">
      <div class="sppb-row">
        <div class="sppb-row-column  " id="column-wrap-id-Q8gFKnKC8aB8PH0MJZKHA">
          <div id="column-id-Q8gFKnKC8aB8PH0MJZKHA" class="sppb-column ">
            <div class="sppb-column-addons">
              <div id="sppb-addon-wrapper-bjyp9KlxNsWXF4nutJqMA" class="sppb-addon-wrapper  addon-root-heading">
                <div id="sppb-addon-bjyp9KlxNsWXF4nutJqMA" class="clearfix  ">
                  <div class="sppb-addon sppb-addon-header">
                    <h2 class="sppb-addon-title">Новини</h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="sppb-row-column  " id="column-wrap-id-iWk_FtiDfjhj2adJ00qQy">
          <div id="column-id-iWk_FtiDfjhj2adJ00qQy" class="sppb-column ">
            <div class="sppb-column-addons">
              <div id="sppb-addon-wrapper-5mTWtBDyXme6aIsqOi-Yl" class="sppb-addon-wrapper  addon-root-button">
                <div id="sppb-addon-5mTWtBDyXme6aIsqOi-Yl" class="clearfix  ">
                  <div class="sppb-button-wrapper">
                    <a href="/news" id="btn-5mTWtBDyXme6aIsqOi-Yl" class="sppb-btn  sppb-btn-primary sppb-btn-rounded">Всі новини <i class="fas fa-arrow-right" aria-hidden="true"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="sppb-row-column  " id="column-wrap-id-qCmls4dMU-mLechCMP-NG">
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
        </div>
      </div>
    </div>
  </section> --}}

  
@endsection