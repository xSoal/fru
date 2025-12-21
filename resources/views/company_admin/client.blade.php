@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">
  @include('company_admin.menu')
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

  @if( (int)Auth::user()->role === 1 )
  <section class="message-section">
      <h2 class="section-subtitle">New message:</h2>
      <div class="message-form-group">
        <form action="{{ route('admin.companyAddMessage') }}" method="post">
          @csrf
          <input hidden name="receiver_id" value="{{ $client->id }}">
          <input hidden name="company_id" value="{{ $companyId }}">

          <label for="message-text" class="message-label">Message:</label>
          <textarea name="content" id="message-text" class="message-textarea" placeholder="Enter message..."></textarea>
          
          <button class="submit-button neo-bg-accent" type="submit">Send</button>
        </form>
      </div>
  </section>
  @endif

  <section class="message-section message__company">
    <h2 class="section-subtitle">Messages:</h2>
    <div class="message-form-group">
      <?php
        $is_admin_looked = false;
        
        if( (int)Auth::user()->role === 2 && count($messages) ){
          $is_admin_looked = true;
          $user_one = $chat->userOne->id;
          $user_two = $chat->userTwo->id;
        }

      ?>
      @foreach ($messages as $item)
        <?php
          if(!$is_admin_looked){
            $message_has_is_sender_css_class = $item->is_sender;
          } else {
            $message_has_is_sender_css_class = (int)$item->sender->id === (int)$user_one; 
          }
        ?>
        <div class="message {{ $message_has_is_sender_css_class ? 'message-sender' : '' }}">
          <div class="message__company"> {{ $item->sender->name }} </div>
          <div class="message__text">{{ $item->content }}</div>
          <div class="message__date">{{ $item->created_at }}</div>
          <div class="message__isRead">{{ $item->is_read ? 'read' : 'unread' }}</div>
        </div>
        <?php
          if(!$item->is_sender && Auth::user()->role === 1 ){
                $item->setMessageReadStatus();
            }
        ?>
      @endforeach
    </div>
</section>


</div>


@endsection