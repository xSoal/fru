@extends('layouts.admin')


@section('content')

<section class="add_user edit_user main_section ">
    <div class="title_h1">
        <div class="top_block">
            <a href="{{ route('admin.users') }}" class="back_to">Назад</a>
        </div>
        <h1>Редактирование</h1> 
    </div>
    
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postUsers') }}" method="POST">
            {{ csrf_field() }}
            <div class="select_bg"></div>

            <div class="form_block active fb_submit fb_submit_top">
                <!-- button -->
                @include('admin.buttons')
                <!-- button -->
            </div>

            <input type="hidden" name="id" value="{{$item->id ?? 0}}">
            <div class="form_block active">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="fio">ПІБ</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="name" value="{{ $item->name ?? '' }}" id="fio" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="parent_category">Посада</label>
                        </div>
                    </div>
                    <div class="fb_input input_select">
                        @if( isset($postList[0]->id) )
                            @foreach($postList as $c)
                                <div class="fb_input_inside postList">
                                    <input type="hidden" name="post_id" value="{{ $c->id }}">
                                    <div class="select">
                                        <div class="current_select">
                                            <span>
                                                {{ $c->name }}
                                            </span>
                                        </div>
                                        <div class="options">
                                            <div>
                                                @if( $postP )
                                                    @foreach($postP as $cat)
                                                        <div class="option" data-id="{{ $cat->id }}">{{ $cat->name }}</div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                        <div class="fb_input_inside postList">
                            <input type="hidden" name="post_id" value="0">
                            <div class="select">
                                <div class="current_select">
                                    <span>
                                        Оберіть дані
                                    </span>
                                </div>
                                <div class="options ">
                                    <div>
                                       @if( $postP )
                                            @foreach($postP as $cat)
                                                <div class="option" data-id="{{ $cat->id }}">{{ $cat->name }}</div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form_block active">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="fio">Телефон</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="phone" value="{{ $item->phone ?? '' }}" id="phone" required>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="form_block active">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="product">Активний</label>
                        </div>
                    </div>
                    <div class="fb_input input_toggle">
                        <div class="fb_input_inside">
                            <input type="hidden" name="active" id="active" value="{{ $item->active ?? 0 }}">
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
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="email" value="{{ $item->email ?? '' }}" id="email" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="image">Фото</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <button type="button" class="addPhotoBtn"></button>
                            <input type="file" class="addPhoto" data-name="photo">
                            <div class="photoPreview">
                                @if( isset($item) && $item->photo !='' )
                                <div class="preview">
                                    <img src="{{ $item->photo }}">
                                    <div class="btn btn_del del_elem" onClick="this.parentNode.remove()"></div>
                                    <input type="hidden" name="photo" value="{{ $item->photo }}">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="parent_category">Форма зайнятості</label>
                        </div>
                    </div>
                    <div class="fb_input input_select">
                        <div class="fb_input_inside">
                            <input type="hidden" name="employment" value="{{ $item->employment ?? 0 }}">
                            <div class="select">
                                <div class="current_select">
                                    <span>
                                        @if( isset($item) )
                                            @switch( $item->employment )
                                                @case (0) Штат @break
                                                @case (1) ЦПХ @break
                                                @case (2) ФОП @break
                                            @endswitch
                                        @endif
                                    </span>
                                </div>
                                <div class="options">
                                    <div>
                                        <div class="option" data-id="0">Штат</div>
                                        <div class="option" data-id="1">ЦПХ</div>
                                        <div class="option" data-id="2">ФОП</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="percent">ПДВ %</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="number" min="0" step="0.01" name="percent" value="{{ $item->percent ?? 0 }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="password">Пароль</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="password" name="password" value="" id="password" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="repeat-pass">Повторіть пароль</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="password" name="password_confirmation" value="" id="repeat-pass" autocomplete="off">
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