
<header class="header">
	<div class="container">
		<div class="headerInner">
			<div class="headerLogo">
				<a href="/">
					<img src="/images/logo.svg" alt="Logo">
				</a>
			</div>
			<div class="headerMenu">
				<nav class="nav" role="navigation" aria-label="Головна навігація сайту">
					<ul class="headerMenuLinks">
						@if(auth()->user())
						<li class="headerSubmenuCont">
							<a href="{{ route('main_page.reference') }}">
								Довідкова інформація 
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M7 10L12 15L17 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
								<div class="headerSubmenu">
									<a href="{{ route('main_page.support') }}">
										Програма підтримки
									</a>
									<a href="{{ route('main_page.rules') }}">
										Правила регулювання
									</a>
								</div>
							</a>
						</li>
						@endif
						<li><a href="/news">Новини</a></li>
						<li><a href="/contacts">Контакти</a></li>
					</ul>
				</nav>
				<?php
					$login_url = "/login";
					$user = auth()->user();

					if($user){
						switch ($user->role) {
							case '3':
								$login_url = '/admin';
								break;
							case '2':
								$login_url = '/admin';
								break;
							case '1':
								$login_url = '/companyAdmin/' . $user->id;
								break;
							case '0':
								$login_url = '/clientAdmin/' . $user->id;
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
		</div>
	</div>
</header>
<div class="paddingHeader"></div>