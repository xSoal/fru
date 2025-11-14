@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        <div class="top_block">
            <a href="{{ route('admin.post') }}" class="back_to">Назад</a>
        </div>
        <h1>Редагувати</h1>
    </div>
    
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postPost') }}@if( isset($pid) ){{ '?pid='.$pid }} @endif" method="POST">
            {{ csrf_field() }} 
            <input type="hidden" name="id" value="{{$item->id ?? 0}}">
            <div class="select_bg"></div>

            <div class="form_block active fb_submit fb_submit_top">
                <!-- button -->
                    @include('admin.buttons')
                <!-- button -->
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Назва</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="name" value="{{ $item->name ?? '' }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="url">Slug</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="slug" id="url" value="{{ $item->slug ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block active">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label>Активний</label>
                        </div>
                    </div>
                    <div class="fb_input input_toggle">
                        <div class="fb_input_inside">
                            <input type="hidden" name="active" value="{{ $item->active ?? 0 }}">
                            <div class="toggle {{ isset($item) && $item->active == 1 ? 'active' : '' }}">
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="sorting">Сортування</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="order" value="{{ $item->order ?? 999 }}" id="sorting">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="parent_category">Відноситься до</label>
                        </div>
                    </div>
                    <div class="fb_input input_select">
                        <div class="fb_input_inside">
                            <input type="hidden" name="parrent_id" value="@if( isset($item) ){{ $item->parrent_id }}@elseif( isset($pid) && $pid != '' ){{ $pid }}@else 0 @endif">
                            <div class="select">
                                <div class="current_select">
                                    <span>
                                        {{ isset($item) && isset($post[$item->parrent_id]) ? $post[$item->parrent_id]->name : '' }}
                                        {{ isset($pid) && isset($post[$pid]) ? $post[$pid]->name : '' }}
                                    </span>
                                </div>
                                <div class="options">
                                    <div>
                                        <div class="option" data-id="0"></div>
                                        @if( $postP )
                                            @foreach($postP as $cat)
                                                @if( (isset($item) && $cat->id != $item->id) || !isset($item) )
                                                    <div class="option level_0" data-id="{{ $cat->id }}">{{ $cat->name }}</div>
                                                    @if($cat->child->count() > 0)
                                                        @include('admin.post.tree', ['post' => $cat->child, 'level' => 1 ])
                                                    @endif
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block active fb_submit">
                <!-- button -->
                    @include('admin.buttons')
                <!-- button -->
            </div>
           
        </form>
    </div>
</section>
@endsection