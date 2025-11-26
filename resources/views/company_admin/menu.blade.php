<div class="header-menu-bar">
    <nav class="navigation-menu">
        <ul>
            <li class="{{ Request::routeIs('admin.companyEquipment') || Request::routeIs('admin.companyEquipmentSearch') ? 'active' : '' }}">
                <a href="{{ route('admin.companyEquipment') }}">Equipment</a>
            </li>
            <li class="{{ Request::routeIs('admin.companyAdmin') ? 'active' : '' }}">
                <a href="{{ route('admin.companyAdmin') }}">Participant</a>
            </li>
            <li class="{{ Request::routeIs('messenger') || Request::routeIs('messenger.single')  ? 'active' : '' }}">
                <a href="{{ route('messenger', ['id' => Auth::user()->id]) }}">Messages</a>
            </li>
        </ul>
    </nav>
</div>