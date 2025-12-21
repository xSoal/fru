@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">

  <div class="buttonBackCont">
      <a href="/">< to site</a>
  </div>
  @include('company_admin.menu')


  <h2 class="section-title">Services</h2>
  <div class="companies-list">
    @foreach ( $services as $service )
      <div class="list-item">
        <a class="company" href="{{ route('admin.companyAdminServiceSingle', ['id' => $service->id, 'companyId' => $companyId]) }}">
          <div class="company__name">
            {{ $service->name }}
          </div>
          <div class="company__logo">
            <img src="{{ $service->photo }}" alt="">
          </div>
        </a>

      </div>
    @endforeach
  </div>

</div>


@endsection