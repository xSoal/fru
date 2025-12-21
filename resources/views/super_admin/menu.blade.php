<div class="header-menu-bar">
    <div class="header__left">
        <nav class="navigation-menu">
            <ul>
                <li class="{{ Request::routeIs('admin.superEquipment') || Request::routeIs('admin.superEquipmentSearch') ? 'active' : '' }}">
                    <a href="{{ route('admin.superEquipment') }}">Equipment Request</a>
                </li>
                <li class="{{ Request::routeIs('admin.superAdminParticipant') || Request::routeIs('admin.superAdminClient') ? 'active' : '' }}">
                    <a href="{{ route('admin.superAdminParticipant') }}">Participant</a>
                </li>
                <li class="{{  Request::routeIs('admin.superAdminPartners') || Request::routeIs('admin.superAdminPartnerSingle') ? 'active' : '' }}">
                    <a href="{{ route('admin.superAdminPartners') }}" >Partners</a>
                </li>
                <li class="{{  Request::routeIs('admin.superAdminReference') ? 'active' : '' }}">
                    <a href="{{ route('admin.superAdminReference') }}" >Financial Support Tools</a>
                </li>
                <li class="{{  Request::routeIs('admin.superAdminService') || Request::routeIs('admin.superAdminServiceSingle')  ? 'active' : ''  }}">
                    <a href="{{ route('admin.superAdminService') }}" >Dealers and Service</a>
                </li>
            </ul>
        </nav>
        <header class="">

          @if( isset($user_target) )
          <?php 
                $newMessages = \App\Models\User::where('id', $user_target->id)->first()->newMessagesCount();
          ?>
          <div class="messageCont">
            <a href="{{ route('messenger', [ 'id' => $user_target->id ]) }}">
              <button class="messages-button neo-accent-btn">
                  <span class="icon-indicator">{{ $newMessages }}</span>
                  MESSAGES 
              </button>
            </a>  
          </div>
          @endif
          </header>
    </div>
    <?php
        $sp_user = Auth::user();
    ?>
    <div class="header__right">
        <div class="partner-info">
            <div class="logo-placeholder">
               <img src="{{ $sp_user->photo }}">
            </div>
            <div class="partner-name-placeholder">
              <h1 class="page-title">{{ $sp_user->name }}</h1>
              
            </div>
        </div>
    </div>
</div>