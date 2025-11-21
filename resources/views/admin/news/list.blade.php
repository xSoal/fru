@extends('layouts.admin')


@section('content')

<section class="product_type main_section">
    <div class="title_h1">
        <h1>Новини</h1>
    </div>
    <div class="search_block">
        <div class="search_form">
            <form action="{{ route('admin.news') }}" method="GET" class="for_search">
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
            <a href="{{ route('admin.addNews') }}" class="add_item">Додати</a>
        </div>

    </div>
    <div class="table news_table">
        <div class="thead">
            <div class="tr tr_heading">
                <div class="th number">№</div>
                {{-- <div class="th public_date">Дата публікації</div> --}}
                <div class="th name">Назва</div>
                <div class="th edit">Редагувати</div>
            </div>
        </div>
        <div class="tbody">
            @if( isset($items) && $items )
			    @foreach($items as  $k => $item)
                    <div class="tr_block">
                        <div class="tr tr_values">
                            <div class="td number">{{ $page + $k + 1 }} </div>
                            {{-- <div class="td public_date">{{ $item->public_date }}</div> --}}
                            <div class="td name">{{ $item->title }}</div>
                            <div class="td edit">
                                <a href="{{ route('admin.viewNews', ['id' => $item->id]) }}" class="edit_link">
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
    </div>

    @if( isset($items) )
    {{ $items->appends( request()->input() )->links() }}
    @endif
</section>

@endsection