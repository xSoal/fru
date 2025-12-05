@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section news_admin active">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.news') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Редагувати</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.post_news') }}" method="POST">
            {{ csrf_field() }} 
            <input type="hidden" name="id" value="{{$item->id ?? 0}}">
            <input type="hidden" name="type" value="news">
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
                                    <label for="name">Дата публікації</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input class="datepicker_node" name="public_date" value="{{ $item->public_date ?? '' }}">
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

                    <hr>
                    <h2>Seo</h2>
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="meta_title">Meta title</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="meta_title" value="{{ $seo->meta_title ?? '' }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="meta_description">Meta description</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="meta_description" value="{{ $seo->meta_description ?? '' }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="meta_keywords">Meta Keywords</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="meta_keywords" value="{{ $seo->meta_keywords ?? '' }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="og_title">Og title</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="og_title" value="{{ $seo->og_title ?? '' }}" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="og_description">Og description</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="og_description" value="{{ $seo->og_description ?? '' }}" >
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="image">Og img</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <button type="button" class="addPhotoBtn"></button>
                                    <input type="file" class="addPhoto" data-name="og_img">
                                    <div class="photoPreview">
                                        <div class="preview">
                                            <img src="{{ isset($seo) && $seo && $seo->og_img ? $seo->og_img : '' }}">
                                            <div class="btn btn_del del_elem" onClick="this.parentNode.remove()"></div>
                                            <input type="hidden" name="og_img" value="{{ isset($seo) && $seo && $seo->og_img ? $seo->og_img : '' }}">
                                        </div>
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