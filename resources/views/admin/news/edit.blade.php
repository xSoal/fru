@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section news_admin">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.news') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Редагувати</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postNews') }}" method="POST">
            {{ csrf_field() }} 
            <input type="hidden" name="id" value="{{$item->id ?? 0}}">
            <div class="select_bg"></div>

            
            <div class="project_doube_row">

                <div class="project_left">
                    
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Назва</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="title" value="{{ $item->title ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Зміст</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <textarea class="textarea_item" name="content" cols="30"
                                    rows="10">{{ $item->content ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if( isset($item) )
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Slug</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input name="slug" value="{{ $item->slug }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

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
                                    <input type="file" class="addPhoto" data-name="image_path">
                                    <div class="photoPreview">
                                        @if( isset($item) && $item->image_path !='' )
                                        <div class="preview">
                                            <img src="{{ $item->image_path }}">
                                            <div class="btn btn_del del_elem" onClick="this.parentNode.remove()"></div>
                                            <input type="hidden" name="image_path" value="{{ $item->image_path }}">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            </div>



            <div class="form_block active fb_submit">
                <div class="fb_inside">
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            @if( isset($item) )
                                <button class="btn-remove" name="dell" value="true" type="submit" onClick="return confirm('Dell?');">Видалити</button>
                                <button class="btn-save" name="update" value="true" type="submit">Оновити</button>
                                <button class="btn-save-close" name="close" value="true" type="submit">Закрити</button>
                            @else
                                <button class="btn-save" name="save" value="true" type="submit">Зберегти</button>
                                <button class="btn-save-quit" name="save_and_exit" value="true" type="submit">Зберегти та вийти</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</section>
@endsection