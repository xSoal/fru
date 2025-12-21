@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">
  @include('super_admin.menu')
  <div class="buttonBackCont">
      <a href="/companyAdmin">< back</a>
  </div>
    <section class="partner-info">
      <div class="logo-placeholder">
        <img src="{{ $client->photo }}">
      </div>
      <div class="partner-name-placeholder">
        <h1 class="page-title">{{ $client->name }}</h1>
        
      </div>
  </section>
  
  <section class="company-description">
      <h2 class="section-subtitle">Description</h2>
      <div class="description-text">
        {{ $client->description }}
      </div>
  </section>

  <hr class="separator"/>
  @if( $client->companies )
  <div class="">
      <h2 class="">Participat member companies</h2>
      <div class="partnersCompanies">
        {!! $client->companies !!}
      </div>
  </div>
  <br>
  @endif

  <section class="request-table-section">
      <h2 class="section-subtitle">EQUIPMENT REQUEST</h2>
      <div class="responsive-table">
          <table>
              <thead>
                  <tr>
                      <th>№</th>
                      <th>NAME </th>
                      <th>MODEL</th>
                      <th>MANUFACTURER</th>
                      <th>COUNTRY</th>
                      <th>QUANTITY</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($equipmentsRequests as $e )
                  <tr>
                    <td >{{ $e->code }}</td>
                    <td >{{ $e->name }}</td>
                    <td >{{ $e->model }}</td>
                    <td >{{ $e->manufacturer }}</td>
                    <td >{{ $e->country }}</td>
                    <td >{{ $e->quantity }}</td>
                  </tr>
                @endforeach

              </tbody>
          </table>
      </div>
  </section>

  <hr class="separator"/>

</div>


@endsection