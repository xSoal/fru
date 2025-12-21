@extends('layouts.company_admin')

@section('content')
 <div class="page-container neo-card details-page">
  <div class="buttonBackCont">
      <a href="/clientAdmin/services">< back</a>
  </div>
  @include('client_admin.menu')
  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Name</span> {{ $service->name }}
      </h1>
  </header>

  <section class="partner-details-info">
      <div class="logo-placeholder logoClientSingle__cont">
        <img src="{{ $service->photo }}">
      </div>
      <div class="partner-name-placeholder">
          
      </div>
  </section>
  
  <section class="company-description">
      <h2 class="section-subtitle">Description</h2>
      <div class="description-text">
        {{ $service->description }}
      </div>
  </section>

  <hr class="separator"/>
  {{-- @if( $service->companies )
  <div class="">
      <h2 class="">Partner member companies</h2>
      <div class="partnersCompanies">
        {!! $service->companies !!}
      </div>
  </div>
  @endif --}}



</section> 


</div>


@endsection