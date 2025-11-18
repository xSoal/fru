@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">
  <div class="messageCont">
    <button class="messages-button neo-accent-btn">
        <span class="icon-indicator">4</span>
        MESSAGES
    </button>
  </div>

  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Partners</span> 
      </h1>
  </header>


  

  <hr class="separator"/>
  <section class="partnersList__cont">
    @foreach ( $partners as $partner )
      <div class="partners__el">
        <a href="{{ route('admin.clientAdminPartnerSingle', ['id' => $partner->id]) }}">
          <div class="partner__name">
            <h3>{{ $partner->name }}</h3>
          </div>
          <div class="partner__logo">
            <img src="{{ $partner->photo }}" alt="">
          </div>
        </a>

      </div>
    @endforeach

  </section>

  <hr class="separator"/>

  <section class="support-section">
      <div class="text-area">
          <h3 class="subsection-title">
            <a href="#">Financial Support Tools</a>
          </h3>
          <h3 class="subsection-title">
            <a href="#">Dealers and Service</a>
          </h3>
          <h3 class="subsection-title">
            <a href="#">Partners</a>
          </h3>
      </div>
  </section>


</div>


@endsection