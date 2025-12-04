<div class="header-menu-bar">
    <div class="header__left">
        <nav class="navigation-menu">
            <ul>
                <?php
                    $user_role = (int) Auth::user()->role;
                ?>
                @if( $user_owner_chats->role === 1 )
                <li class="{{ Request::routeIs('admin.companyEquipment') || Request::routeIs('admin.companyEquipmentSearch') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyEquipment', $user_owner_chats->id) }}">Equipment Request</a>
                </li>
                <li class="{{ Request::routeIs('admin.companyAdmin') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyAdmin', $user_owner_chats->id) }}">Participant</a>
                </li>
                <li class="{{  Request::routeIs('admin.clientAdminReference') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyAdminReference', $user_owner_chats->id) }}" >Financial Support Tools</a>
                </li>
                <li class="">
                    <a href="#"> Dealers and Service</a>
                </li>
                @endif
                @if( $user_owner_chats->role === 0 )
                <li class="{{ Request::routeIs('admin.clientAdmin') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdmin', $user_owner_chats->id) }}">Partipiant</a>
                </li>
                <li class="{{ Request::routeIs('admin.clientAdminPartners') || Request::routeIs('admin.clientAdminPartnerSingle') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdminPartners', $user_owner_chats->id) }}">Partners</a>
                </li>
                <li class="{{  Request::routeIs('admin.companyAdminReference') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdminReference', $user_owner_chats->id) }}" >Financial Support Tools</a>
                </li>
                <li class="">
                    <a href="#"> Dealers and Service</a>
                </li>
                @endif

            </ul>
        </nav>
        <header class="">
            <?php 
                $newMessages = $user_owner_chats->newMessagesCount();
            ?>
            <div class="messageCont">
                <a href="{{ route('messenger', [ 'id' => $user_owner_chats->id ]) }}">
                <button class="messages-button neo-accent-btn">
                    <span class="icon-indicator">{{ $newMessages }}</span>
                    MESSAGES 
                </button>
                </a>  
            </div>
          </header>
    </div>

    <div class="header__right">
        <div class="partner-info">
            <div class="logo-placeholder">
               <img src="{{ $user_owner_chats->photo }}">
            </div>
            <div class="partner-name-placeholder">
              <h1 class="page-title">{{ $user_owner_chats->name }}</h1>
              
            </div>
        </div>
    </div>

</div>