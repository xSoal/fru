@extends('layouts.admin')


@section('content')

<section class="product_type main_section">
    <div class="title_h1">
        <h1>Посади</h1>
    </div>
    <div class="search_block">
        <div class="search_form">
            <form action="{{ route('admin.postPost') }}" method="POST" class="for_search">
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

        <div class="filter_categories">
            <div class="filter_results">
                <div class="form_block_items">
                    <div class="fb_input input_select">
                        <div class="fb_input_inside">
                            <input type="hidden" name="parrent_id" value="{{ $parrent_id ?? 0 }}">
                            <div class="select">
                                <div class="current_select">
                                    <span>{{ $parrent_id != '' ? $post[$parrent_id]->name : '  ' }}</span>
                                </div>
                                <div class="options">
                                    <div>
                                        <div class="option" data-id="0">всі</div>
                                        @foreach( $postP as $cat )
                                            <div class="option level_0" data-id="{{ $cat->id }}">{{ $cat->name }}</div>
                                            @if($cat->child->count() > 0)
                                                @include('admin.post.tree', ['post' => $cat->child, 'level' => 1 ])
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="add_new_item">
            <a href="{{ route('admin.addPost') }}" class="add_item">Додати</a>
        </div>
    </div>
    <div class="table">
        <div class="thead">
            <div class="tr tr_heading">
                <div class="th number">№</div>
                <div class="th name">Назва</div>
                <div class="th name">Відноситься до</div>
                <div class="th edit">Редагувати</div>
                <div class="th edit">Додати</div>
            </div>
        </div>
        <div class="tbody">
            @if( $items )
			    @foreach($items as  $k => $item)
                    <div class="tr_block">
                        <div class="tr tr_values">
                            <div class="td number">{{ $page + $k + 1 }}</div>
                            <div class="td name">{{ $item->name }}</div>
                            <div class="td parent_cat">
                                    {{ $item->parrent->name ?? ''; }}
                                    @if(isset($item->parrent_id) && $item->parrent_id !=0 ) 
                                        @include('admin.post.parrent', ['item' => $item->parrent])
                                    @endif
                                 
                            </div>
                            <div class="td edit">
                                <a href="{{ route('admin.viewPost', ['id' => $item->id]) }}" class="edit_link">
                                    <span>
                                    <object type="image/svg+xml" data="/images/admin/icons/edit.svg"></object>
                                    </span>
                                </a>
                            </div>
                            <div class="td edit">
                                <a href="{{ route('admin.addPost').'?pid='.$item->id }}" class="edit_link">
                                    <span>
                                    <object type="image/svg+xml" data="/images/admin/icons/v2/load_circle.svg"></object>
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