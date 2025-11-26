@extends('layouts.company_admin')

@section('content')

    <div class="page-container neo-card details-page">
        @if( (int)Auth::user()->role === 1 )
          @include('company_admin.menu')
        @endif

        <header class="header">
            <h1 class="page-title details-title">
              <p class="neo-highlight">{{ $user_for_chat_view->name }}</p> 
              <p>with</p>
              <p class="neo-highlight">{{ $dialog_with_user->name }}</p>
            </h1>
        </header>
      
        <hr class="separator"/>

        @if((int)$current_user->role !== 2)
            <section class="message-section">
                <div class="message-form-group">
                  <form action="{{ route('messenger.add_message') }}" method="post">
                    @csrf

                    <input name="conversation_id" value="{{ $chat->id }}"  type="text" hidden>
                    
                    <label for="message-text" class="message-label">Message:</label>
                    <textarea name="content" id="message-text" class="message-textarea" placeholder="Enter message..."></textarea>
                    
                    <button class="submit-button neo-bg-accent" type="submit">Send</button>
                  </form>
                </div>
            </section>
        @endif

      
        <section class="message-section">
          <h2 class="section-subtitle">Messages:</h2>
          <div class="message-form-group">
 
            @foreach ($chat->messages as $item)
                <?php
                    $message_sender = $user_for_chat_view->id === $item->sender_id;

                ?>
                <div class="message {{ $message_sender ? 'message-sender' : '' }}">
                  @if($message_sender)
                    <div class="message__header">Your message</div>
                  @endif
                  <div class="message__company"> {{ $item->sender->name }} </div>
                  <div class="message__text">{{ $item->content }}</div>
                  <div class="message__date">{{ $item->created_at }}</div>
                  <div class="message__isRead">{{ $item->is_read ? 'readed' : 'udreaded' }}</div>
                </div>
                <?php
                    if(!$message_sender && (int)Auth::user()->role !== 2){
                        $item->setMessageReadStatus();
                    }
                ?>
            @endforeach
          </div>
        </section>
      
      </div>

@endsection