@extends('layouts.admin')


@section('content')

<section class="add_user edit_user main_section ">
    <div class="title_h1">
        <div class="top_block">
            <a href="{{ route('admin.companies') }}" class="back_to">Назад</a>
        </div>
        <h1>Редактирование 123</h1> 
    </div>
    
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postCompany') }}" method="POST">
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
                            <label for="fio">Название</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="name" value="{{ $item->name ?? '' }}" id="fio" required>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form_block active">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="fio">Описание</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <textarea name="description">{{ $item->description ?? '' }}</textarea>
                        </div>
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