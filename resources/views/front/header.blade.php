{{-- <header class="header">
    <div class="container">
        <div class="header_wrapper">
            <div class="header_side left">
                <a href="">
                    <div class="header_logo">
                        
                    </div>
                </a>
            </div>

            <div class="header_side right">
                <div class="header_auth">
                    <ul class="auth_list">
                        <a href="{{ route('front.questionary') }}" class="questionnaire_link">
                            <span class="auth_link_item">Анкета</span>
                        </a>
                        <li class="auth_link">
                            <span class="auth_link_item">Вхід</span>
                        </li>
                    </ul>
                </div>

                <div class="header_burger">
                    <span></span>
                </div>
            </div>

           
        </div>
    </div>
</header> --}}

{{-- <header id="sp-header" class="">
	<div class="container">
		<div class="container-inner">
			<div class="row" style="position: relative;">
				<!-- Logo -->
				<div id="sp-logo" class="col-auto">
					<div class="sp-column">
						<div class="logo"><a href="/">
				<img class="logo-image  d-none d-lg-inline-block" srcset="https://industrial-ramstein.fru.ua/images/logo.svg 1x" src="https://industrial-ramstein.fru.ua/images/logo.svg" height="65px" alt="Платформа &quot;Промисловий Рамштайн&quot;">
				<img class="logo-image-phone d-inline-block d-lg-none" src="https://industrial-ramstein.fru.ua/images/logo.svg" alt="Платформа " Промисловий="" Рамштайн""=""></a></div>						
					</div>
				</div>

				<!-- Menu -->
				<div id="sp-menu" class="col-auto flex-auto" style="position: static;">
					<div class="sp-column d-flex justify-content-end align-items-center">
						<nav class="sp-megamenu-wrapper d-flex" role="navigation"><a id="offcanvas-toggler" aria-label="Menu" class="offcanvas-toggler-right d-flex d-lg-none" href="#"><div class="burger-icon" aria-hidden="true"><span></span><span></span><span></span></div></a><ul class="sp-megamenu-parent menu-animation-fade-up d-none d-lg-block"><li class="sp-menu-item current-item active"><a aria-current="page" href="/ua/news">Новини</a></li><li class="sp-menu-item"><a href="/ua/contact">Контакти</a></li></ul></nav>						

						<!-- Related Modules -->
						<div class="d-none d-lg-flex header-modules align-items-center">
							
															<div class="sp-module">
<a class="sp-sign-in" href="/ua/login"><span class="far fa-user me-1" aria-hidden="true"></span><span class="signin-text d-none d-lg-inline-block">Авторизація</span></a>
</div>													</div>

						<!-- if offcanvas position right -->
													<a id="offcanvas-toggler" aria-label="Menu" title="Menu" class="mega offcanvas-toggler-secondary offcanvas-toggler-right d-flex align-items-center" href="#">
							<div class="burger-icon"><span></span><span></span><span></span></div>
							</a>
											</div>
				</div>
			</div>
		</div>
	</div>
</header> --}}



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
						<li><a href="/news">Новини</a></li>
						<li><a href="/contacts">Контакти</a></li>
					</ul>
				</nav>
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
				<a class="loginHref" href="{{ $login_url }}" >
					<img src="/images/icons/user.svg">
					{{-- <span class="far fa-user me-1"></span> --}}
				</a>
			</div>
		</div>
	</div>
</header>
<div class="paddingHeader"></div>