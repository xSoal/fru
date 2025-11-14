@extends('layouts.admin')


@section('content')

<section class="product_type main_section">
    <div class="title_h1">
        <h1>Акнети користувачів</h1>
    </div>
    <div class="search_block">
        <div class="search_form">
            <form action="{{ route('admin.postQuestionnaire') }}" method="POST" class="for_search">
				{{ csrf_field() }}
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
    <div class="table">
        <div class="thead">
            <div class="tr tr_heading">
                <div class="th number">№</div>
                <div class="th name">ПІБ</div>
                <div class="th name">Проект</div>
                <div class="th edit">Редагувати</div>
            </div>
        </div>
        <div class="tbody">
            @if( $items )
			    @foreach($items as  $k => $item)
                    <div class="tr_block">
                        <div class="tr tr_values">
                            <div class="td number">{{ $page + $k + 1 }}</div>
                            <div class="td name">{{ $item->name }}</div>
                            <div class="td name">{{ $item->project }}</div>
                            <div class="td edit">
                                <a href="{{ route('admin.viewQuestionnaire', ['id' => $item->id]) }}" class="edit_link">
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

    {{ $items->appends( request()->input() )->links() }}

</section>

@endsection