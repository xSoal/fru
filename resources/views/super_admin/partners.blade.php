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
  <section class="companies-list">
    @foreach ( $partners as $partner )
      <div class="list-item">
        <a class="company" href="{{ route('admin.superAdminPartnerSingle', ['id' => $partner->id]) }}">
          <div class="company__name">
            {{ $partner->name }}
          </div>
          <div class="company__logo">
            <img src="{{ $partner->photo }}" alt="">
          </div>
        </a>
      </div>
    @endforeach

  </section>

  <hr class="separator"/>


</div>


@endsection