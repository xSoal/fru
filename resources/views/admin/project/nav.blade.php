<div class="good_tabs">
    <ul id="tabs-nav">
        <a href="{{ route('admin.viewProject', ['id' => $item->id]) }}">
            <li class="{{ Request::segment(3) == '' ?  'active' : '' }}">
                Головна
            </li>
        </a>
        <a href="{{ route('admin.projectKPP', ['id' => $item->id]) }}">
            <li class="{{ Request::segment(3) == 'kpp' ?  'active' : '' }}">
                КПП
            </li>
        </a>
        <a href="{{ route('admin.schedule', ['id' => $item->id]) }}">
            <li class="{{ Request::segment(3) == 'schedule' ?  'active' : '' }}">
                Графік здачі випусків
            </li>
        </a>
        <a href="{{ route('admin.limit', ['id' => $item->id]) }}">
            <li class="{{ Request::segment(3) == 'limit' ?  'active' : '' }}">
                Ліміт затрат
            </li>
        </a>

        <a href="{{ route('admin.expedition', ['id' => $item->id]) }}">
            <li class="{{ Request::segment(3) == 'expedition' ?  'active' : '' }}">
                Експедиція/проживання
            </li>
        </a>
        
    </ul>
</div>