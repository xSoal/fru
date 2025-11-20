@extends('layouts.company_admin')

@section('content')
 <div class="page-container neo-card details-page">
  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Name</span> {{ $partner->name }}
      </h1>
  </header>

  <section class="partner-details-info">
      <div class="logo-placeholder logoClientSingle__cont">
        <img src="{{ $partner->photo }}">
      </div>
      <div class="partner-name-placeholder">
          
      </div>
  </section>
  
  <section class="company-description">
      <h2 class="section-subtitle">Description</h2>
      <div class="description-text">
        {{ $partner->description }}
      </div>
  </section>

  <hr class="separator"/>


  <section class="message-section">
      <h2 class="section-subtitle">New message:</h2>
      <div class="message-form-group">
        <form action="{{ route('admin.clientAddMessage') }}" method="post">
          @csrf
          <input hidden name="receiver_id" value="{{ $partner->id }}"

          <label for="message-text" class="message-label">Message:</label>
          <textarea name="content" id="message-text" class="message-textarea" placeholder="Enter message..."></textarea>
          
          <button class="submit-button neo-bg-accent" type="submit">Send</button>
        </form>
      </div>
  </section>

  <section class="message-section">
    <h2 class="section-subtitle">Messages:</h2>
    <div class="message-form-group">
      @foreach ($messages as $item)
          <div class="message {{ $item->is_sender ? 'message-sender' : '' }}">
            <div class="message__text">{{ $item->content }}</div>
            <div class="message__date">{{ $item->created_at }}</div>
            <div class="message__isRead">{{ $item->is_read ? 'readed' : 'udreaded' }}</div>
          </div>
      @endforeach
    </div>
</section> 


</div>


@endsection