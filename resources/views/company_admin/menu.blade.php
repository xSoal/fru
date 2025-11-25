<div class="header-menu-bar">
    <nav class="navigation-menu">
        <ul>
            <li class="{{ Request::routeIs('admin.companyEquipment') ? 'active' : '' }}">
                <a href="{{ route('admin.companyEquipment') }}">Обладнання</a>
            </li>
            <li class="{{ Request::routeIs('admin.companyAdmin') ? 'active' : '' }}">
                <a href="{{ route('admin.companyAdmin') }}">Participant</a>
            </li>
            <li class="{{ Request::routeIs('messengers') ? 'active' : '' }}">
                <a href="{{ route('messenger', ['id' => Auth::user()->id]) }}">Message</a>
            </li>
        </ul>
    </nav>
</div>