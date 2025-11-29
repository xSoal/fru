<header class="mobHeader heder">
    <div class="site-container mobHeader__wrapper">
        <a href="/" class="siteLogo">
            <div class="headerLogo">
					<img src="/images/logo.svg" alt="Logo">
			</div>
        </a>

        <button class="navToggleBtn" aria-expanded="false" aria-controls="mobileNavOverlay">
            <span class="btnLine"></span>
            <span class="btnLine"></span>
            <span class="btnLine"></span>
        </button>
        
        <nav class="mobileNavOverlay" id="mobileNavOverlay">
            <ul class="menuList">
                @if(auth()->user())
                <li><a href="{{ route('main_page.support') }}">Програма підтримки</a></li>
                <li><a href="{{ route('main_page.rules') }}">Правила регулювання</a></li>

                @endif
                <li><a href="/news">Новини</a></li>
                <li><a href="/contacts">Контакти</a></li>
            </ul>

            <div class="">
				<?php
					$login_url = "/login";
					$user = auth()->user();

					if($user){
						switch ($user->role) {
							case '2':
								$login_url = '/admin';
								break;
							case '1':
								$login_url = '/companyAdmin';
								break;
							case '0':
								$login_url = '/clientAdmin';
								break;
							default:
								# code...
								break;
						}
					}
				?>
				@if( auth()->user() )
					<ul class="headerMenuLinks loginHref">
						<li class="headerSubmenuCont">
							<img src="/images/icons/userAuth.svg">
							<div class="headerSubmenu">
								<a href="{{ $login_url }}" target="_blank">Кабінет</a>
								<a href="#" class="exitBtn">Вийти</a>
								<form action="{{ route('logout') }}" method="POST">@csrf</form>
							</div>

						</li>
					</ul>
				@else
					<a class="loginHref" href="{{ $login_url }}" >
						<img src="/images/icons/user.svg">
					</a>
				@endif
            </div>
        </nav>
    </div>
</header>