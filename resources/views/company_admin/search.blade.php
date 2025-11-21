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
            <form action="{{ route('admin.companySearch') }}" method="get">
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
        <h2 class="section-title">Search results by country</h2>
        <div class="">

          <table>
            <thead>
                <tr>
                    <th>Participant name</th>
                    <th>N</th>
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
                <td class="code">{{ $e->code }}</td>
                <td class="name">{{ $e->name }}</td>
                <td class="model">{{ $e->model }}</td>
                <td class="manufacturer">{{ $e->manufacturer }}</td>
                <td class="country">{{ $e->country }}</td>
                <td class="quantity">{{ $e->quantity }}</td>
                <td><a class="section-subtitle" href="{{ route('admin.companyAdminClient', $e->id) }}">Go to page</a></td>
              </tr>  
              @endforeach
              
            </tbody>
        </table>
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