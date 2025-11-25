@extends('layouts.company_admin')

@section('content')


  <div class="page-container neo-card">
    @include('company_admin.menu')
    <div class="buttonBackCont">
        <a href="/companyAdmin">< back</a>
    </div>
    <header class="header">

      <?php 
          $newMessages = Auth::user()->newMessagesCount();
      ?>
      @if($newMessages !== false)
      <div class="messageCont">
        <a href="{{ route('messenger', [ 'id' => Auth::user()->id ]) }}">
          <button class="messages-button neo-accent-btn">
              <span class="icon-indicator">{{ $newMessages }}</span>
              MESSAGES
          </button>
        </a>  

      </div>
      @endif
    </header>
    
    <section class="companies-section">
        <h2 class="section-title">Search results by country</h2>
        <div class="equipmentCont">
          <div class="equipmentFilter">
            <div class="equipmentFilterHeaderCont">
              <span>Country</span>
              <div class="equipmentFilter__reset">
                <button>reset</button>
              </div>
            </div>
            <div class="equipmentFilter__contryList">
              <?php
                $i = 1;
                
              ?>
              @foreach($countries as $item)
              <div class="equipment__country">
                <div class="equipment__countryLeft">
                  <input type="checkbox" id="{{ ++$i }}" value="{{ $item->country }}" {{ isset($allowedCountries) && in_array($item->country, $allowedCountries) ? 'checked' : '' }}>
                  <label for="{{ $i }}">
                    <div class="equipment__coutryName">{{ $item->country }}</div>
                  </label>
                </div>
                <div class="equipment__coutryight">
                  {{ $item->count }}
                </div>
              </div>
              @endforeach

            </div>
          </div>
          @if( count($resultSearch) )
            <table class="equipment__searchTable">
              <thead>
                  <tr>
                      <th>Participant name</th>
                      <th class="company__searchTableCode">N</th>
                      <th>NAME </th>
                      <th>MODEL</th>
                      <th>MANUFACTURER</th>
                      <th>COUNTRY</th>
                      <th>QUANTITY</th>
                      <th>Link</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultSearch as $e)
                <tr>
                  <td>{{ $e->user->name }}</td>
                  <td class="code company__searchTableCode">{{ $e->code }}</td>
                  <td class="name">{{ $e->name }}</td>
                  <td class="model">{{ $e->model }}</td>
                  <td class="manufacturer">{{ $e->manufacturer }}</td>
                  <td class="country">{{ $e->country }}</td>
                  <td class="quantity">{{ $e->quantity }}</td>
                  <td class="company__searchTableLink">
                    <a class="section-subtitle" href="{{ route('admin.companyAdminClient', $e->id) }}">
                      link
                    </a>
                  </td>
                </tr>  
                @endforeach
                
              </tbody>
          </table>
          @endif

        </div>
        @if( isset($resultSearch) )
        {{ $resultSearch->appends( request()->input() )->links() }}
        @endif
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
        </div>
    </section>


</div>



@endsection