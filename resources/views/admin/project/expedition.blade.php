@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.project') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Експедиція/проживання "{{ $item->name }}"</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postProject') }}" method="POST">
            {{ csrf_field() }} 
            <input type="hidden" name="id" value="{{$item->id ?? 0}}">
            <div class="select_bg"></div>

            <div class="form_block active fb_submit fb_submit_top">
                <!-- button -->
                    @include('admin.project.nav')
                <!-- button -->
            </div>


            <div class="form_block table_list expedition">
                <div class="fb_inside">
                    
                    <div class="fb_input table_items">
                        <div class="fb_input_inside">
                            
                            <div class="table">
                                
                                <div class="thead">
                                    <div class="tr tr_heading">
                                        <div class="th number">№</div>
                                        <div class="th name two_col">Маршрут</div>
                                        <div class="th price four_col">Відстань</div>
                                        <div class="th price four_col">Кількість знімальних днів</div>
                                        <div class="th price four_col">Кількість календарних днів</div>
                                        <div class="th price four_col">Кількість ночей (проживання)</div>
                                    </div>
                                </div>

                                <div class="additional_row">
                                    <div class="add_new_item">
                                        <div class="add_item addProjectExpedition">Додати</div>
                                    </div>
                                </div>

                                <div class="tbody">
                                    @if( isset($item->expedition) )
                                        @foreach($item->expedition as $k => $exp)
                                        <div class="tr_block">
                                            <div class="tr tr_values">
                                                <div class="td number">{{ $k+1 }}</div>
                                                <div class="td photo two_col">
                                                    <input type="text" value="{{ $exp->route }}" name="route[]">
                                                </div>
                                                <div class="td four_col">
                                                    <input type="number" step="1" min="0" class="distance" name="distance[]" value="{{ $exp->distance }}">
                                                </div>
                                                <div class="td four_col">
                                                    <input type="number" step="1" min="0" class="count_work_days" name="count_work_days[]" value="{{ $exp->count_work_days }}">
                                                </div>
                                                <div class="td four_col">
                                                    <input type="number" step="1" min="0" class="count_days" name="count_days[]" value="{{ $exp->count_days }}">
                                                </div>
                                                <div class="td four_col">
                                                    <input type="number" step="1" min="0" class="count_nights" name="count_nights[]" value="{{ $exp->count_nights }}">
                                                </div>
                                                
                                                <div class="edit_link" onclick="this.closest('.tr_block').remove();recountRows();expeditionRows();">
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
                                                <input type="text" value="" name="route[]">
                                            </div>
                                            <div class="td four_col">
                                                <input type="number" step="1" min="0" value="0" class="distance" name="distance[]">
                                            </div>
                                            <div class="td four_col">
                                                <input type="number" step="1" min="0" value="0" class="count_work_days" name="count_work_days[]">
                                            </div>
                                            <div class="td four_col">
                                                <input type="number" step="1" min="0" value="0" class="count_days" name="count_days[]">
                                            </div>
                                            <div class="td four_col">
                                                <input type="number" step="1" min="0" value="0" class="count_nights" name="count_nights[]">
                                            </div>
                                            
                                            <div class="edit_link" onclick="this.closest('.tr_block').remove();recountRows();expeditionRows();">
                                                <object type="image/svg+xml" data="/images/admin/icons/delete.svg?1"></object>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tfood">
                                    <div class="tr tr_heading">
                                        <div class="th number"></div>
                                        <div class="th two_col route">Всього:</div>
                                        <div class="th four_col distance"></div>
                                        <div class="th four_col count_work_days"></div>
                                        <div class="th four_col count_days"></div>
                                        <div class="th four_col count_nights"></div>
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
                            <button class="btn-save" name="updateExpedition" value="true" type="submit">Зберегти</button>
                        </div>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</section>
@endsection