@extends('layouts.company_admin')

@section('content')
 <div class="page-container neo-card details-page">
  <div class="buttonBackCont">
      <a href="/clientAdmin/partners">< back</a>
  </div>
  @include('super_admin.menu')
  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Name</span> {{ $partner->name }}
      </h1>
  </header>

  <section class="partner-details-info">
      <div class="logo-placeholder logoClientSingle__cont">
        <img src="{{ $partner->photo }}">
      </div>
      <div class="partner-name-placeholder">
          
      </div>
  </section>
  
  <section class="company-description">
      <h2 class="section-subtitle">Description</h2>
      <div class="description-text">
        {{ $partner->description }}
      </div>
  </section>

  <hr class="separator"/>
  @if( $partner->companies )
  <div class="">
      <h2 class="">Partner member companies</h2>
      <div class="partnersCompanies">
        {!! $partner->companies !!}
      </div>
  </div>
  @endif



</div>


@endsection