<nav class="admin_menu ">
    <div class="in_admin_menu">

        {{-- <div class="admin_menu_section">
            <div class="admin_menu_title">
                <a href="{{ route('admin.ats') }}" class="menu_title_item menu_single">Довідник</a>
            </div>
        </div> --}}

        <div class="admin_menu_section">
            <div class="admin_menu_title">
                <a href="{{ route('admin.news') }}" class="menu_title_item menu_single">Новини</a>
            </div>
        </div>

        <div class="admin_menu_section user_icon">
            <div class="admin_menu_title">
                <a href="{{ route('admin.companies') }}" class="menu_title_item menu_single">Компанії</a>
            </div>
        </div>

        <div class="admin_menu_section user_icon">
            <div class="admin_menu_title">
                <a href="{{ route('admin.clients') }}" class="menu_title_item menu_single">Клієнти</a>
            </div>

        {{-- <div class="admin_menu_section">
            <div class="admin_menu_title">
                <a href="{{ route('admin.project') }}" class="menu_title_item menu_single">Проекти</a>
            </div>
        </div> --}}

        {{-- <div class="admin_menu_section">
            <div class="admin_menu_title">
                <a href="{{ route('admin.questionnaire') }}" class="menu_title_item menu_single">Акнети користувачів</a>
            </div>
        </div> --}}
        

    </div>

    <div class="admin_menu_section">
        <div class="admin_menu_title">
            <div class="menu_title_item settings_menu_item menu_parent">Системні налаштування</div>
        </div>
        <div class="admin_menu_links">
            
            <div class="admin_menu_link">
                <a href="{{ route('admin.users') }}" class="menu_link_item users_list">Користувачі</a>
            </div>
{{-- 
            <div class="admin_menu_link">
                <a href="{{ route('admin.post') }}" class="menu_link_item users_list">Посади</a>
            </div> --}}


            <form method="POST" action="{{ route('logout') }}">
            @csrf
            <div class="admin_menu_link">
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="menu_link_item">Вихід</a>
            </div>
            </form>
            
        </div>
    </div>
</nav>