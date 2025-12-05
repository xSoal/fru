@extends('layouts.admin')


@section('content')

<section class="product_type main_section">
    <div class="title_h1">
        <h1>Логіювання</h1>
    </div>
    <div class="search_block">
        <div class="search_form">
            <form action="{{ route('admin.logsSearch') }}" method="GET" class="for_search">
				{{-- {{ csrf_field() }} --}}
                <div class="form_block fb_query">
                    <div class="fb_inside">
                        <div class="fb_label">
                            <div class="fb_label_inside label_search">
                                <label for="search_blog_category">Пошук</label>
                            </div>
                        </div>
                        <div class="fb_input">
                            <div class="fb_input_inside">
                                <input type="text" name="search" value="{{ $search }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_block fb_submit">
                    <div class="fb_inside">
                        <div class="fb_input">
                            <div class="fb_input_inside">
                                <button class="btn-search" name="" value="true" type="submit">Пошук</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>



    </div>
    {{-- <div class="table news_table">
        <div class="thead">
            <div class="tr tr_heading">
                <div class="th number">№</div>
                <div class="th public_date">Дата публікації</div>
                <div class="th name">Назва</div>
                <div class="th status">Назва</div>
                <div class="th edit">Редагувати</div>
            </div>
        </div>
        <div class="tbody">
            @if( isset($items) && $items )
			    @foreach($items as  $k => $item)
                    <div class="tr_block" data-id="{{ $item->id }}" data-type="news">
                        <div class="tr tr_values">
                            <div class="td number">{{ $page + $k + 1 }} </div>
                            <div class="td public_date">{{ $item->public_date }}</div>
                            <div class="td name">{{ $item->title }}</div>
                            <div class="td status">
                                <div class="form_block_items">
                                    <div class="form_block active">
                                        <div class="fb_inside">
                                            <div class="fb_input input_toggle">
                                                <div class="fb_input_inside">
                                                    <div class="toggle toggle_news {{ $item->active == 1 ? 'active' : '' }}">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="td edit">
                                <a href="{{ route('admin.view_news', ['id' => $item->id]) }}" class="edit_link">
                                    <span>
                                        <object type="image/svg+xml" data="/images/admin/icons/edit.svg"></object>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div> --}}
    
    <br><br><br>

    <table class="custom-table">
        <thead class="">
            <tr class="">
                <td class="date">Тип запису</td>
                <td class="name">Запис</td>
            </tr>
        </thead>
        <tbody class="">
            @if( isset($items) && $items )
			    @foreach($items as  $k => $item)
                    <tr class="tr_block" data-id="{{ $item->id }}">
                        <div class="">
                            <td class="date">{{ $item->type === 'request' ? 'Запит на обладнання' : 'Повідомлення' }}</td>
                            <td class="name log__cont">
                                <div class="log__header">
                                    <b>{{ $item->type === 'request' ? 'Новий Запит' : 'Нове Повідомлення в Чаті' }}</b>  <div>{{ $item->created_at }}</div>
                                </div>
                                <div class="log__body">
                                    {!! $item->value !!}
                                </div>
                            </td>
                        </div>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </е>

    @if( isset($items) )
    {{ $items->appends( request()->input() )->links() }}
    @endif
</section>

@endsection