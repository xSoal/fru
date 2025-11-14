@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.project') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Редагувати</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postProject') }}" method="POST">
            {{ csrf_field() }} 
            <input type="hidden" name="id" value="{{$item->id ?? 0}}">
            <div class="select_bg"></div>

            @if( isset($item) )
            <div class="form_block active fb_submit fb_submit_top">
                <!-- button -->
                    @include('admin.project.nav')
                <!-- button -->
            </div>
            @endif

            
            <div class="project_doube_row">

                <div class="project_left">
                    
                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Назва проекту</label>
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
                                    <label for="name">Жанр</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="genre" value="{{ $item->genre ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Формат</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="format" value="{{ $item->format ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Хронометраж однієї програми (хв.)</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="number" step="1" min="0" name="timing" value="{{ $item->timing ?? '0' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Загальна кількість програм (сезон)</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="number" step="1" min="0" name="count_programs" value="{{ $item->count_programs ?? '0' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Загальна кількість знімальних змін (сезон)</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="number" step="1" min="0" name="count_changes" value="{{ $item->count_changes ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Кількість монтажних змін (програма)</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="number" step="1" min="0" name="count_montaj" value="{{ $item->count_montaj ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Загальна кількість монтажних змін (сезон)</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" class="total_count_changes" value="{{ isset($item) ? ( $item->count_montaj * $item->count_programs ) : '' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Періодичність виходу в ефір</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" name="frequency_airing" value="{{ $item->frequency_airing ?? '' }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Загальний кошторис виробництва</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" value="{{ $item->total_amount ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form_block">
                        <div class="fb_inside">
                            <div class="fb_label">
                                <div class="fb_label_inside">
                                    <label for="name">Виробничий кошторис одного випуску</label>
                                </div>
                            </div>
                            <div class="fb_input">
                                <div class="fb_input_inside">
                                    <input type="text" value="{{ $item->single ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="project_right">

                    <div class="form_block table_list">
                        <div class="fb_inside">
                            
                            <div class="fb_input table_items">
                                <div class="fb_input_inside">
                                    Календар проекту
                                    <div class="table">
                                        
                                        <div class="thead">
                                            <div class="tr tr_heading">
                                                <div class="th number">№</div>
                                                <div class="th name two_col">Періоди виробництва</div>
                                                <div class="th price four_col">Початок</div>
                                                <div class="th price four_col">Закінчення</div>
                                                <div class="th price four_col">Загальний період (дн.)</div>
                                            </div>
                                        </div>

                                        <div class="additional_row">
                                            <div class="add_new_item">
                                                <div class="add_item addProjectCalendar">Додати</div>
                                            </div>
                                        </div>

                                        <div class="tbody">
                                            @if( isset($item->calendar) )
                                                @foreach($item->calendar as $k => $cal)
                                                <div class="tr_block">
                                                    <div class="tr tr_values">
                                                        <div class="td number">{{ $k + 1 }}</div>
                                                        <div class="td photo two_col">
                                                            <textarea name="production_periods[]">{{ $cal->production_periods }}</textarea>
                                                        </div>
                                                        <div class="td price four_col">
                                                            <input type="text" class="datepickersmall start_production" value="{{ $cal->start_production }}" name="start_production[]" readonly>
                                                        </div>
                                                        <div class="td price four_col">
                                                            <input type="text" class="datepickersmall end_production" value="{{ $cal->end_production }}" name="end_production[]" readonly>
                                                        </div>
                                                        <div class="td price four_col">
                                                            <input type="text" class="day_count" value="{{ $cal->day_count }}" readonly>
                                                        </div>
                                                        
                                                        <div class="edit_link" onclick="this.closest('.tr_block').remove();recountRows();">
                                                            <object type="image/svg+xml" data="/images/admin/icons/delete.svg?1"></object>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="tpl_row hidden">
                                            <div class="tr_block">
                                                <div class="tr tr_values">
                                                    <div class="td number"></div>
                                                    <div class="td photo two_col">
                                                        <textarea name="production_periods[]"></textarea>
                                                    </div>
                                                    <div class="td price four_col">
                                                        <input type="text" class="datepickersmall start_production" value="" name="start_production[]" readonly>
                                                    </div>
                                                    <div class="td price four_col">
                                                        <input type="text" class="datepickersmall end_production" value="" name="end_production[]" readonly>
                                                    </div>
                                                    <div class="td price four_col">
                                                        <input type="text" class="day_count" value="" readonly>
                                                    </div>
                                                    
                                                    <div class="edit_link" onclick="this.closest('.tr_block').remove();recountRows();">
                                                        <object type="image/svg+xml" data="/images/admin/icons/delete.svg?1"></object>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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