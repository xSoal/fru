@extends('layouts.company_admin')

@section('content')


  <div class="page-container neo-card">
    <header class="header">
        <div class="messageCont">
          <button class="messages-button neo-accent-btn">
              <span class="icon-indicator">4</span>
              MESSAGES
          </button>
        </div>
    </header>

    <section class="partner-info">
        <div class="logo-placeholder">
           <img src="{{ $user->photo }}">
        </div>
        <div class="partner-name-placeholder">
          <h1 class="page-title">{{ $user->name }}</h1>
          
        </div>
    </section>

    <section class="search-section">
        <div class="neo-input-group">
            <label for="search-input" class="search-label">
                <span class="label-text">SEARCH:</span>
            </label>
            <form action="#" method="get">
              @csrf
              <input
                type="text"
                id="search-input"
                class="search-input-field"
                placeholder=""
                value=""
              >
            </form>
        </div>
    </section>

    <section class="companies-section">
        <h2 class="section-title">UKRAINIAN COMPANIES</h2>
        <div class="companies-list">
          @foreach ($clients as $client)
            <div class="list-item">
              <a class="company" href="/companyAdmin/clients/{{ $client->id }}">
                <div class="company__name">Company {{ $client->name }} </div>
                <div class="company__logo">
                  <img src="{{ $client->photo }}">
                </div>
              </a>
            </div>
          @endforeach
        </div>
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