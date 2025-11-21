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

    <section class="search-section">
        <div class="neo-input-group">
            <label for="search-input" class="search-label">
                <span class="label-text">SEARCH:</span>
            </label>
            <form action="{{ route('admin.companySearch') }}" method="post">
              @csrf
              <input
                type="text"
                id="search-input"
                name="search"
                class="search-input-field"
                placeholder=""
                value="{{ $search ?? '' }}"
              >
            </form>
        </div>
    </section>

    <section class="companies-section">
        <h2 class="section-title">Search results</h2>
         {{ $search }} йцу {{ $resultSearch }}
        <div class="">
          {{ $resultSearch }}   йцу
          @foreach ($resultSearch as $item)
              {{ $item }}
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