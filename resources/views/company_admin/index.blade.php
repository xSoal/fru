@extends('layouts.company_admin')

@section('content')


  <div class="page-container neo-card">
    @include('company_admin.menu')

    <div class="buttonBackCont">
        <a href="/">< to site</a>
    </div>
    <section class="search-section">
        <div class="neo-input-group">
            <label for="search-input" class="search-label">
                <span class="label-text">SEARCH:</span>
            </label>
            <form action="{{ route('admin.companySearch') }}" method="get">
              @csrf
              <input
                type="text"
                id="search-input"
                name="search"
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
                <div class="company__name">{{ $client->name }} </div>
                <div class="company__logo">
                  <img src="{{ $client->photo }}">
                </div>
              </a>
            </div>
          @endforeach
        </div>
    </section>

    <hr class="separator"/>




</div>



@endsection