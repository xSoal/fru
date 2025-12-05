@extends('layouts.admin')


@section('content')

<section class="product_type main_section active">
    <div class="title_h1">
        <h1>Правила регулювання</h1>
    </div>
    <div class="search_block">
        <div class="search_form">
            <form action="{{ route('admin.rules') }}" method="GET" class="for_search">
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


        <div class="add_new_item">
            <a href="{{ route('admin.add_rules') }}" class="add_item">Додати</a>
        </div>

    </div>

    <br><br><br>

    <table class="custom-table">
        <thead class="">
            <tr class="">
                <td>№</td>
                <td class="date">Дата публікації</td>
                <td class="name">Назва</td>
                <td class="status">Статус</td>
                <td class="edit">Редагувати</td>
            </tr>
        </thead>
        <tbody class="">
            @if( isset($items) && $items )
			    @foreach($items as  $k => $item)
                    <tr class="tr_block" data-id="{{ $item->id }}" data-type="news">
                        <div class="">
                            <td class="number">{{ $page + $k + 1 }} </td>
                            <td class="date">{{ $item->public_date }}</td>
                            <td class="name">{{ $item->title }}</td>
                            <td class="status">
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
                            </td>
                            <td class="edit">
                                <a href="{{ route('admin.view_rules', ['id' => $item->id]) }}" class="edit_link">
                                    <span>
                                        <object type="image/svg+xml" data="/images/admin/icons/edit.svg"></object>
                                    </span>
                                </a>
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