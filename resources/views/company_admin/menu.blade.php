<div class="header-menu-bar">
    <div class="header__left">
        <nav class="navigation-menu">
            <ul>
                <li class="{{ Request::routeIs('admin.companyEquipment') || Request::routeIs('admin.companyEquipmentSearch') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyEquipment', $companyId) }}">Equipment Request</a>
                </li>
                <li class="{{ Request::routeIs('admin.companyAdmin') || Request::routeIs('admin.companyAdminClient') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyAdmin', $companyId) }}">Participant</a>
                </li>
                <li class="{{  Request::routeIs('admin.companyAdminPartners') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyAdminPartners', $companyId) }}" >Partners</a>
                </li>
                <li class="{{  Request::routeIs('admin.companyAdminReference') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyAdminReference', $companyId) }}" >Financial Support Tools</a>
                </li>
                <li class="{{  Request::routeIs('admin.companyAdminService') || Request::routeIs('admin.companyAdminServiceSingle') ? 'active' : '' }}">
                    <a href="{{ route('admin.companyAdminService', $companyId) }}" >Dealers and Service</a>
                </li>
            </ul>
        </nav>
        <header class="">
            <?php 
                $newMessages = \App\Models\User::where('id', $companyId)->first()->newMessagesCount();
            ?>
          @if($newMessages !== false)
          <div class="messageCont">
            <a href="{{ route('messenger', [ 'id' => $companyId ]) }}">
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