<div class="header-menu-bar">
    <div class="header__left">
        <nav class="navigation-menu">
            <ul>
                <li class="{{ Request::routeIs('admin.clientAdmin') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdmin') }}">Partipiant</a>
                </li>
                <li class="{{ Request::routeIs('admin.clientAdminPartners') || Request::routeIs('admin.clientAdminPartnerSingle') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientAdminPartners') }}">Partners</a>
                </li>
            </ul>
        </nav>
        <header class="">
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
          </header>
    </div>

    <div class="header__right">
        <div class="partner-info">
            <div class="logo-placeholder">
               <img src="{{ $user->photo }}">
            </div>
            <div class="partner-name-placeholder">
              <h1 class="page-title">{{ $user->name }}</h1>
              
            </div>
        </div>
    </div>

</div>