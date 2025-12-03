@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section news_admin">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="/admin" class="back_to">Назад</a>
        </div>
        
        <h1>Seo</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.seoEdit') }}" method="POST">
            {{ csrf_field() }} 
            <input type="hidden" name="type" value="news">
            <div class="select_bg"></div>

            
            <div class="project_doube_row">

                <div class="project_left">

                    
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="meta_title">Meta title</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="meta_title" value="{{ $seo->meta_title ?? '' }}" required>
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
                                    <input type="text" name="meta_description" value="{{ $seo->meta_description ?? '' }}" required>
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
                                    <input type="text" name="meta_keywords" value="{{ $seo->meta_keywords ?? '' }}" required>
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
                                    <input type="text" name="og_title" value="{{ $seo->og_title ?? '' }}" required>
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
                                    <input type="text" name="og_description" value="{{ $seo->og_description ?? '' }}" required>
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
                                            <img src="{{ $seo->og_img }}">
                                            <div class="btn btn_del del_elem" onClick="this.parentNode.remove()"></div>
                                            <input type="hidden" name="og_img" value="{{ $seo->og_img }}">
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
                                <button class="btn-save" name="save" value="true" type="submit">Зберегти</button>
                        </div>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</section>
@endsection