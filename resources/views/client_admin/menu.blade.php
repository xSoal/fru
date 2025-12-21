<div class="header-menu-bar">
    <div class="header__left">
        <nav class="navigation-menu">
            <ul>
                <li class="{{ Request::routeIs('admin.clientAdmin') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdmin', $clientId) }}">Partipiant</a>
                </li>
                <li class="{{ Request::routeIs('admin.clientAdminPartners') || Request::routeIs('admin.clientAdminPartnerSingle') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdminPartners', $clientId) }}">Partners</a>
                </li>
                <li class="{{  Request::routeIs('admin.clientAdminReference') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdminReference', $clientId) }}" >Financial Support Tools</a>
                </li>
                <li class="{{  Request::routeIs('admin.clientAdminService') || Request::routeIs('admin.clientAdminServiceSingle') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdminService', $clientId) }}" >Dealers and Service</a>
                </li>
            </ul>
        </nav>
        <header class="">
            <?php 
                $newMessages = $client->newMessagesCount();
            ?>
          <div class="messageCont">
            <a href="{{ route('messenger', [ 'id' => $clientId ]) }}">
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
               <img src="{{ $client->photo }}">
            </div>
            <div class="partner-name-placeholder">
              <h1 class="page-title">{{ $client->name }}</h1>
              
            </div>
        </div>
    </div>

</div>