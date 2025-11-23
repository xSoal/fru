@extends('layouts.company_admin')

@section('content')

    {{ $chats[0]->messages }}

    <div class="page-container neo-card details-page">
        <div class="messageCont">
          <button class="messages-button neo-accent-btn">
              <span class="icon-indicator">4</span>
              MESSAGES
          </button>
        </div>
      
        <header class="header">
            <h1 class="page-title details-title">
              <span class="neo-highlight">Chats of</span> {{ $user_for_chat_view->name }}
            </h1>
        </header>
      
        
      
        <hr class="separator"/>
        <section class="request-table-section">
            <h2 class="section-subtitle">Chats</h2>
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Last message</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($chats as $e )
                          <tr>
                            <td>{{ $e->userOne->name }}</td>
                            <td>
                                {{ $e->messages[0]->content }}
                                {{ $e->messages[0]->is_read === 0 ? '(new)' : '' }}
                            </td>
                            <td class="">
                                <a href="">
                                    <p class="editButton neo-bg-accent submit-button">open chat</p>
                                </a>
                            </td>
                          </tr>  
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
      
        <hr class="separator"/>
      

      
      
      </div>

@endsection