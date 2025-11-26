@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">

  <div class="buttonBackCont">
      <a href="/">< to site</a>
  </div>
  @include('company_admin.menu')



  <hr class="separator"/>
  <h1>Financial Support Tools</h1>
  @foreach ($news as $item)
      <div class="reference__Cont">
        <h3 class="reference__Title">
          <a href="/{{ $item->type }}/{{ $item->slug }}" target="_blank">
            {{ $item->title }}
          </a>
        </h3>
        <div>
          @if( $item->type === 'support' )
            Програма підтримки
          @endif
          @if( $item->type === 'rules' )
            Правила регулювання
          @endif
        </div>
      </div>
  @endforeach

  <hr class="separator"/>

</div>


@endsection