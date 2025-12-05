@extends('layouts.company_admin')

@section('content')


  <div class="page-container neo-card">
    @include('company_admin.menu')
    <div class="buttonBackCont">
        <a href="/companyAdmin">< back</a>
    </div>

    <section class="search-section">
        <div class="neo-input-group">
            <label for="search-input" class="search-label">
                <span class="label-text">SEARCH:</span>
            </label>
            <form action="{{ route('admin.companySearch', $companyId) }}" method="get">
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
          @if( count($resultSearch) )
            <table class="equipment__searchTable">
              <thead>
                  <tr>
                      <th class="company__searchTableCode">№</th>
                      <th>NAME </th>
                      <th>MODEL</th>
                      <th>MANUFACTURER</th>
                      <th>COUNTRY</th>
                      <th>QUANTITY</th>
                      <th>>Participant</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($resultSearch as $e)
                <tr>
                  <td class="code company__searchTableCode">{{ $e->code }}</td>
                  <td class="name">{{ $e->name }}</td>
                  <td class="model">{{ $e->model }}</td>
                  <td class="manufacturer">{{ $e->manufacturer }}</td>
                  <td class="country">{{ $e->country }}</td>
                  <td class="quantity">{{ $e->quantity }}</td>
                  <td class="company__searchTableLink">
                    <a class="section-subtitle" href="{{ route('admin.companyAdminClient', ['id' => $e->user->id, 'companyId' => $companyId]) }}">
                      {{ $e->user->name }}
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



</div>



@endsection