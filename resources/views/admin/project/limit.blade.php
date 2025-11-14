@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.project') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Ліміт-затрат виробництва програми "{{ $item->name }}"</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        
            <div class="select_bg"></div>

            <div class="form_block active fb_submit fb_submit_top">
                <!-- button -->
                    @include('admin.project.nav')
                <!-- button -->
            </div>

            <div class="projectLimit">

                <div class="form_block table_list limit">
                    <div class="fb_inside">
                        
                        <div class="fb_input table_items">
                            <div class="fb_input_inside">
                                
                                <div class="table">
                                    
                                    <div class="thead">
                                        <div class="tr tr_heading">
                                            <div class="th four_col"></div>
                                            <div class="th one_col">Стаття</div>
                                            <div class="th five_col">Кіл-сть</div>
                                            <div class="th four_col">Од. виміру</div>
                                            <div class="th five_col">Кіл-сть</div>
                                            <div class="th three_col">Од. виміру</div>
                                            <div class="th three_col">Ціна</div>
                                            <div class="th three_col">Вартість</div>
                                            <div class="th two_col">Податки</div>
                                            <div class="th three_col">Разом з податками</div>
                                            <div class="th four_col">Форма</div>
                                            <div class="th two_col">ПІБ</div>
                                            <div class="th two_col">Період роботи</div>
                                            <div class="th one_col">Коментар</div>
                                        </div>
                                    </div>

                                    <div class="additional_row">
                                        <div class="add_new_item">
                                            <div class="add_item addLimitRowBlock">Додати</div>
                                        </div>
                                    </div>

                                    <!-- ------------------------ -->
                                    <div class="tbody blocks">
                                            @php $k = 1; @endphp
                                            @foreach($limits as $limit)
                                                <div class="tr_block">
                                                    <form action="{{ route('admin.postProject') }}" method="POST">
                                                        {{ csrf_field() }} 
                                                        <input type="hidden" name="id" value="{{$item->id ?? 0}}">
                                                        <div class="tr tr_values limitRowBlock">
                                                            <div class="additional_row">
                                                                <div class="add_new_item">
                                                                    <div class="add_item addLimitRow" data-count="{{ $k }}">Додати</div>
                                                                </div>
                                                            </div>

                                                            <div class="tbody rows">
                                                                <div class="tr tr_heading">
                                                                    <div class="th one_col">
                                                                        <input type="text" class="blockName" data-name="blockName[{{ $k }}]" name="blockName[{{ $k }}]" value="{{ $limit['title'] }}" readonly>
                                                                    </div>
                                                                    <div class="th five_col"></div>
                                                                    <div class="th four_col"></div>
                                                                    <div class="th five_col"></div>
                                                                    <div class="th three_col"></div>
                                                                    <div class="th three_col"></div>
                                                                    <div class="th three_col"></div>
                                                                    <div class="th two_col"></div>
                                                                    <div class="th three_col"></div>
                                                                    <div class="th four_col"></div>
                                                                    <div class="th two_col"></div>
                                                                    <div class="th two_col"></div>
                                                                    <div class="th one_col"></div>
                                                                </div>
                                                                
                                                                @foreach($limit['json']['block_v1'] as $j => $v)
                                                                    
                                                                    <div class="tr_block">
                                                                        <input type="hidden" data-name="block_v15[{{ $k }}][]" name="block_v15[{{ $k }}][]" value="{{ $limit['json']['block_v15'][$j] }}">
                                                                        <div class="tr tr_values">
                                                                            <div class="td one_col">
                                                                                <input type="text" data-name="block_v1[{{ $k }}][]" name="block_v1[{{ $k }}][]" value="{{ $limit['json']['block_v1'][$j] }}" {{ $limit['json']['block_v15'][$j] == 0 ? 'readonly' : '' }}>
                                                                            </div>
                                                                            <div class="td five_col">
                                                                                <input type="text" class="block_v2" data-name="block_v2[{{ $k }}][]" name="block_v2[{{ $k }}][]" value="{{ $limit['json']['block_v2'][$j] }}">
                                                                            </div>
                                                                            <div class="td four_col">
                                                                                <input type="text" data-name="block_v3[{{ $k }}][]" name="block_v3[{{ $k }}][]" value="{{ $limit['json']['block_v3'][$j] }}" {{ $limit['json']['block_v15'][$j] == 0 ? 'readonly' : '' }}>
                                                                            </div>
                                                                            <div class="td five_col">
                                                                                <input type="text" class="block_v4" data-name="block_v4[{{ $k }}][]" name="block_v4[{{ $k }}][]" value="{{ $limit['json']['block_v4'][$j] }}">
                                                                            </div>
                                                                            <div class="td three_col">
                                                                                <input type="text" data-name="block_v5[{{ $k }}][]" name="block_v5[{{ $k }}][]" value="{{ $limit['json']['block_v5'][$j] }}" {{ $limit['json']['block_v15'][$j] == 0 ? 'readonly' : '' }}>
                                                                            </div>
                                                                            <div class="td three_col">
                                                                                <input type="text" class="block_v6" data-name="block_v6[{{ $k }}][]" name="block_v6[{{ $k }}][]" value="{{ $limit['json']['block_v6'][$j] }}">
                                                                            </div>
                                                                            <div class="td three_col">
                                                                                <input type="text" class="block_v7" readonly data-name="block_v7[{{ $k }}][]" name="block_v7[{{ $k }}][]" value="{{ $limit['json']['block_v7'][$j] }}">
                                                                            </div>
                                                                            <div class="td two_col">
                                                                                <input type="text" class="block_v8" readonly data-name="block_v8[{{ $k }}][]" name="block_v8[{{ $k }}][]" value="{{ $limit['json']['block_v8'][$j] }}">
                                                                                <input type="text" class="block_v14" data-name="block_v14[{{ $k }}][]" name="block_v14[{{ $k }}][]" value="{{ $limit['json']['block_v14'][$j] }}">
                                                                            </div>
                                                                            <div class="td three_col">
                                                                                <input type="text" class="block_v9" readonly data-name="block_v9[{{ $k }}][]" name="block_v9[{{ $k }}][]" value="{{ $limit['json']['block_v9'][$j] }}">
                                                                            </div>
                                                                            <div class="td four_col">
                                                                                <input type="text" class="block_v10" data-name="block_v10[{{ $k }}][]" name="block_v10[{{ $k }}][]" value="{{ $limit['json']['block_v10'][$j] }}">
                                                                            </div>
                                                                            <div class="td two_col">
                                                                                <input type="text" class="block_v11" autocomplete="off" data-name="block_v11[{{ $k }}][]" name="block_v11[{{ $k }}][]" value="{{ $limit['json']['block_v11'][$j] }}">
                                                                            </div>
                                                                            <div class="td two_col">
                                                                                <input type="text" data-name="block_v12[{{ $k }}][]" name="block_v12[{{ $k }}][]" value="{{ $limit['json']['block_v12'][$j] }}">
                                                                            </div>
                                                                            <div class="td one_col">
                                                                                <input type="text" data-name="block_v13[{{ $k }}][]" name="block_v13[{{ $k }}][]" value="{{ $limit['json']['block_v13'][$j] }}">
                                                                            </div>
                                                                            @if( $limit['json']['block_v15'][$j] == 1 )
                                                                            <div class="edit_link" onclick="this.closest('.tr_block').remove();recountBlockRows();">
                                                                                <object type="image/svg+xml" data="/images/admin/icons/delete.svg?1"></object>
                                                                            </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                                <div class="tr tr_foot">
                                                                    <div class="td one_col">
                                                                        <div class="form_block active fb_submit">
                                                                            <div class="fb_inside">
                                                                                <div class="fb_input">
                                                                                    <div class="fb_input_inside">
                                                                                        <button class="btn-save" name="updateLimit" value="true" type="submit">Зберегти</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="td five_col"></div>
                                                                    <div class="td four_col"></div>
                                                                    <div class="td five_col"></div>
                                                                    <div class="td three_col"></div>
                                                                    <div class="td three_col"></div>
                                                                    <div class="td three_col block_v7"></div>
                                                                    <div class="td two_col block_v8"></div>
                                                                    <div class="td three_col block_v9"></div>
                                                                    <div class="td four_col"></div>
                                                                    <div class="td two_col"></div>
                                                                    <div class="td two_col"></div>
                                                                    <div class="td one_col"></div>
                                                                </div>
                                                            </div>
                                                            
                                                        </div>
                                                        </form>
                                                </div>
                                                @php $k++; @endphp
                                            @endforeach
                                        
                                    </div>
                                    <div class="tr tr_foot row_1">
                                        <div class="th four_col"></div>
                                        <div class="td one_col">Разом витрати на виробництво ({{ $item->count_programs }} програм). БЕЗ ПОДАТКІВ</div>
                                        <div class="td five_col"></div>
                                        <div class="td four_col"></div>
                                        <div class="td five_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col block_v7"></div>
                                        <div class="td two_col block_v8"></div>
                                        <div class="td three_col block_v9"></div>
                                        <div class="td four_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td one_col"></div>
                                    </div>
                                    <div class="tr tr_foot row_2">
                                        <div class="th four_col"></div>
                                        <div class="td one_col">Разом податки ЗП штатних працівників</div>
                                        <div class="td five_col"></div>
                                        <div class="td four_col"></div>
                                        <div class="td five_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col block_v7"></div>
                                        <div class="td two_col block_v8"></div>
                                        <div class="td three_col block_v9"></div>
                                        <div class="td four_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td one_col"></div>
                                    </div>
                                    <div class="tr tr_foot row_3">
                                        <div class="th four_col"></div>
                                        <div class="td one_col">Разом податки ФОП</div>
                                        <div class="td five_col"></div>
                                        <div class="td four_col"></div>
                                        <div class="td five_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col block_v7"></div>
                                        <div class="td two_col block_v8"></div>
                                        <div class="td three_col block_v9"></div>
                                        <div class="td four_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td one_col"></div>
                                    </div>
                                    <div class="tr tr_foot row_4">
                                        <div class="th four_col"></div>
                                        <div class="td one_col">Разом податки ПДВ</div>
                                        <div class="td five_col"></div>
                                        <div class="td four_col"></div>
                                        <div class="td five_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col block_v7"></div>
                                        <div class="td two_col block_v8"></div>
                                        <div class="td three_col block_v9"></div>
                                        <div class="td four_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td one_col"></div>
                                    </div>
                                    <div class="tr tr_foot row_5">
                                        <input type="hidden" name="total_amount" value="">
                                        <div class="th four_col"></div>
                                        <div class="td one_col">Разом витрати НА ВИРОБНИЦТВО СЕЗОНУ ({{ $item->count_programs }} програм)</div>
                                        <div class="td five_col"></div>
                                        <div class="td four_col"></div>
                                        <div class="td five_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col block_v7"></div>
                                        <div class="td two_col block_v8"></div>
                                        <div class="td three_col block_v9"></div>
                                        <div class="td four_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td one_col"></div>
                                    </div>
                                    <div class="tr tr_foot row_6" data-count="{{ $item->count_programs }}">
                                        <div class="th four_col"></div>
                                        <div class="td one_col">Витрати на виробництво одного випуску</div>
                                        <div class="td five_col"></div>
                                        <div class="td four_col"></div>
                                        <div class="td five_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col"></div>
                                        <div class="td three_col block_v7"></div>
                                        <div class="td two_col block_v8"></div>
                                        <div class="td three_col block_v9"></div>
                                        <div class="td four_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td two_col"></div>
                                        <div class="td one_col"></div>
                                    </div>
                                    <!-- ------------------------ -->




                                    <!-- ------------------------ -->
                                    <div class="tpl_row hidden addLimitRowBlockTPL">
                                        <div class="tr_block">
                                            <div class="tr tr_values limitRowBlock">
                                                <div class="additional_row">
                                                    <div class="add_new_item">
                                                        <div class="add_item addLimitRow" data-count="">Додати</div>
                                                    </div>
                                                </div>

                                                <div class="tbody rows">
                                                    <form action="{{ route('admin.postProject') }}" method="POST">
                                                        {{ csrf_field() }} 
                                                        <div class="tr tr_heading">
                                                            <div class="th one_col">
                                                                <input type="text" class="blockName" data-name="blockName[REP]" value="">
                                                            </div>
                                                            <div class="th five_col"></div>
                                                            <div class="th four_col"></div>
                                                            <div class="th five_col"></div>
                                                            <div class="th three_col"></div>
                                                            <div class="th three_col"></div>
                                                            <div class="th three_col"></div>
                                                            <div class="th two_col"></div>
                                                            <div class="th three_col"></div>
                                                            <div class="th four_col"></div>
                                                            <div class="th two_col"></div>
                                                            <div class="th two_col"></div>
                                                            <div class="th one_col"></div>
                                                        </div>
                                                        <div class="tr tr_foot">
                                                            <div class="td one_col">
                                                                <div class="form_block active fb_submit">
                                                                    <div class="fb_inside">
                                                                        <div class="fb_input">
                                                                            <div class="fb_input_inside">
                                                                                <button class="btn-save" name="updateLimit" value="true" type="submit">Зберегти</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="td five_col"></div>
                                                            <div class="td four_col"></div>
                                                            <div class="td five_col"></div>
                                                            <div class="td three_col"></div>
                                                            <div class="td three_col"></div>
                                                            <div class="td three_col"></div>
                                                            <div class="td two_col"></div>
                                                            <div class="td three_col"></div>
                                                            <div class="td four_col"></div>
                                                            <div class="td two_col"></div>
                                                            <div class="td two_col"></div>
                                                            <div class="td one_col"></div>
                                                        </div>
                                                        <div class="hidden limitRowTPL">
                                                            <div class="tr_block">
                                                                <input type="hidden" data-name="block_v15[REP][]" value="1">
                                                                <div class="tr tr_values">
                                                                    <div class="td one_col">
                                                                        <input type="text" data-name="block_v1[REP][]">
                                                                    </div>
                                                                    <div class="td five_col">
                                                                        <input type="text" class="block_v2" data-name="block_v2[REP][]">
                                                                    </div>
                                                                    <div class="td four_col">
                                                                        <input type="text" data-name="block_v3[REP][]">
                                                                    </div>
                                                                    <div class="td five_col">
                                                                        <input type="text" class="block_v4"  data-name="block_v4[REP][]">
                                                                    </div>
                                                                    <div class="td three_col">
                                                                        <input type="text" data-name="block_v5[REP][]">
                                                                    </div>
                                                                    <div class="td three_col">
                                                                        <input type="text" class="block_v6" data-name="block_v6[REP][]">
                                                                    </div>
                                                                    <div class="td three_col">
                                                                        <input type="text" class="block_v7" readonly data-name="block_v7[REP][]">
                                                                    </div>
                                                                    <div class="td two_col">
                                                                        <input type="text" class="block_v8" readonly data-name="block_v8[REP][]">
                                                                        <input type="text" class="block_v14" data-name="block_v14[REP][]">
                                                                    </div>
                                                                    <div class="td three_col">
                                                                        <input type="text" class="block_v9" readonly data-name="block_v9[REP][]">
                                                                    </div>
                                                                    <div class="td four_col">
                                                                        <input type="text" class="block_v10" data-name="block_v10[REP][]">
                                                                    </div>
                                                                    <div class="td two_col">
                                                                        <input type="text" class="block_v11" autocomplete="off" data-name="block_v11[REP][]">
                                                                    </div>
                                                                    <div class="td two_col">
                                                                        <input type="text" data-name="block_v12[REP][]">
                                                                    </div>
                                                                    <div class="td one_col">
                                                                        <input type="text" data-name="block_v13[REP][]">
                                                                    </div>
                                                                    
                                                                    <div class="edit_link" onclick="this.closest('.tr_block').remove();recountBlockRows();">
                                                                        <object type="image/svg+xml" data="/images/admin/icons/delete.svg?1"></object>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </div>

                                                <div class="edit_link removeBlock" onclick="this.closest('.tr_block').remove();recountBlock();recountBlockRows()">
                                                    <object type="image/svg+xml" data="/images/admin/icons/delete.svg?1"></object>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ------------------------ -->



                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            
    </div>
</section>
@endsection