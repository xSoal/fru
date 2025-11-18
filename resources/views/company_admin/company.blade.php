@extends('layouts.company_admin')

@section('content')

<div class="page-container neo-card details-page">
  <header class="header">
      <h1 class="page-title details-title">
        <span class="neo-highlight">Name</span> {{ $company->name }}
      </h1>
  </header>

  <section class="partner-details-info">
      <div class="logo-placeholder neo-bg-accent">
          {{ $company->photo }}
      </div>
      <div class="partner-name-placeholder">
          
      </div>
  </section>
  
  <section class="company-description">
      <h2 class="section-subtitle">Description</h2>
      <div class="description-text">
        {{ $company->description }}
      </div>
  </section>

  <hr class="separator"/>

  <section class="request-table-section">
      <h2 class="section-subtitle">EQUIPMENT REQUEST</h2>
      <div class="responsive-table">
          <table>
              <thead>
                  <tr>
                      <th>N</th>
                      <th>NAME...</th>
                      <th>MODEL</th>
                      <th>MANUFACTURER</th>
                      <th>COUNTRY</th>
                      <th>QUANTITY</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td>1</td>
                      <td><input type="text" class="table-input" value="Агротехника X10"></td>
                      <td><input type="text" class="table-input" value="MDL-700"></td>
                      <td><input type="text" class="table-input"></td>
                      <td><input type="text" class="table-input"></td>
                      <td><input type="number" class="table-input" value="3"></td>
                  </tr>
              </tbody>
          </table>
      </div>
  </section>

  <hr class="separator"/>

  <section class="message-section">
      <h2 class="section-subtitle">New message:</h2>
      <div class="message-form-group">
        <form action="{{ route('admin.companyAddMessage') }}" method="post">
            @csrf
            <input hidden name="receiver_id" value="{{ $company->id }}"
          <label for="org-name" class="message-label">Organization name</label>
          <input type="text" id="org-name" class="message-input-field" placeholder="Введите название вашей организации">

          <label for="message-text" class="message-label">Message:</label>
          <textarea name="content" id="message-text" class="message-textarea" placeholder="Введите ваше сообщение или запрос"></textarea>
          
          <button class="submit-button neo-bg-accent" type="submit">Send</button>
        </form>
      </div>
  </section>

  <section class="message-section">
    <h2 class="section-subtitle">Messages:</h2>
    <div class="message-form-group">
      {{-- {{ $messages }} --}}
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