@extends('layouts.company_admin')

@section('content')

    <div class="page-container neo-card details-page">
        @if( (int)Auth::user()->role === 1 )
            @include('company_admin.menu')
        @endif

        <?php 
            $newMessages = Auth::user()->newMessagesCount();
        ?>
        @if($newMessages !== false)
        <div class="messageCont">
          <a href="{{ route('messenger', [ 'id' => Auth::user()->id ]) }}">
            <button class="messages-button neo-accent-btn">
                <span class="icon-indicator">{{ $newMessages }}</span>
                MESSAGES
            </button>
          </a>  

        </div>
        @endif
      
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
                        <?php
                            $messageFromUserRole = 'userOne';
                            if((int)$user_for_chat_view->role === 1){
                                $messageFromUserRole = 'userTwo';
                            }
                        ?>
                        @foreach ($chats as $e )
                          <tr>
                            <td>{{ $e[$messageFromUserRole]->name }}</td>
                            <td>
                                {{ $e->messages[0]->content }}
                                {{ (int)$e->messages[0]->is_read === 0 
                                    && (int)$e->messages[0]->sender_id !== Auth::user()->id 
                                    ? '(new)' : '' }}
                            </td>
                            <td class="messenger__openChatTd">
                                <a href="{{ route('messenger.single', [
                                    'id' => $user_for_chat_view->id,
                                    'chatId' => $e->id
                                ]) }}">
                                    <p class=" "><i class="fa-solid fa-comment"></i></p>
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