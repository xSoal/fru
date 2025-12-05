@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">

  @include('super_admin.menu')

  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Partners:</span> 
      </h1>
  </header>


  

  <hr class="separator"/>
  <section class="partnersList__cont">
    @foreach ( $partners as $partner )
      <div class="partners__el">
        <a href="{{ route('admin.superAdminPartnerSingle', ['id' => $partner->id]) }}">
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


</div>


@endsection