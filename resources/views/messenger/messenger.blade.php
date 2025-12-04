@extends('layouts.company_admin')

@section('content')

    <div class="page-container neo-card details-page">
        @include('messenger.menu')
      

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
                            if((int)$user_owner_chats->role === 1){
                                $messageFromUserRole = 'userTwo';
                            }
                        ?>
                        @foreach ($chats as $e )
                          <tr>
                            <td>{{ $e[$messageFromUserRole]->name }}</td>
                            <td>
                                @if( isset($e->messages[0]->content) )
                                    {{ $e->messages[0]->content }}
                                    {{ (int)$e->messages[0]->is_read === 0  && (int)$e->messages[0]->sender_id !== $user_owner_chats->id ? '(new)' : '' }}
                                @endif
                            </td>
                            <td class="messenger__openChatTd">
                                <a href="{{ route('messenger.single', [
                                    'id' => $user_owner_chats->id,
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