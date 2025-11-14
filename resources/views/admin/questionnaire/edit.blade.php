@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.questionnaire') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Редагувати</h1>

    </div>
    <div class="form_block_items form_add form_edit">
        <form action="{{ route('admin.postQuestionnaire') }}" method="POST">
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
                            <label for="name">Прізвище, ім'я, по батькові</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="name" value="{{ $item->name ?? '' }}" autocomplete="off" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="parent_category">Стать</label>
                        </div>
                    </div>
                    <div class="fb_input input_select">
                        <div class="fb_input_inside">
                            <input type="hidden" name="sex" value="{{ $item->sex ?? 0 }}">
                            <div class="select">
                                <div class="current_select">
                                    <span>
                                        @if( isset($item) )
                                            @switch( $item->sex )
                                                @case (0) Чоловічий @break
                                                @case (1) Жіночий @break
                                            @endswitch
                                        @endif
                                    </span>
                                </div>
                                <div class="options">
                                    <div>
                                        <div class="option" data-id="0">Чоловічий</div>
                                        <div class="option" data-id="1">Жіночий</div>
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
                            <label for="parent_category">Посада</label>
                        </div>
                    </div>
                    <div class="fb_input input_select">
                        @if( count($postList) !=0 )
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

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Назва проекту</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="project" value="{{ $item->project ?? '' }}" autocomplete="off"  >
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Паспорт, ID-картка: коли та ким видано (орган, що видав)</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <textarea type="text" name="pasport" >{{ $item->pasport ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Реєстраційна картка платника податків (номер ідентифікаційного коду)</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="inn" value="{{ $item->inn ?? '' }}" autocomplete="off" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Закордонний паспорт</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <textarea type="text" name="zagran_pasport" value="">{{ $item->zagran_pasport ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Дата народження</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="birthday" value="{{ $item->birthday ?? '' }}" readonly class="datepicker">
                        </div>
                    </div>
                </div>
            </div>


            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Ваш Е-mail</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="email" value="{{ $item->email ?? '' }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Контактний телефон (прив'язаний до telegram)</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="phone" value="{{ $item->phone ?? '' }}" >
                        </div>
                    </div>
                </div>
            </div>


            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Освіта</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <textarea type="text" name="education" >{{ $item->education ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Адреса місця проживання за реєстрацією</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="address" value="{{ $item->address ?? '' }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Адреса місця фактичного проживання</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="residential_addresses" value="{{ $item->residential_addresses ?? '' }}" >
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Сімейний стан</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="family_status" value="{{ $item->family_status ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Діти до 15 років (ПІБ дитини, дата народження)</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <textarea type="text" name="children" >{{ $item->children ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="name">Наявність будь яких пільгових документів (МСЕК про встановлення інвалідності, пенсійне посвідчення, інше)</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <textarea type="text" name="preferential_documents" >{{ $item->preferential_documents ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form_block">
                <div class="fb_inside">
                    <div class="fb_label">
                        <div class="fb_label_inside">
                            <label for="parent_category">Відношення до військового обліку</label>
                        </div>
                    </div>
                    <div class="fb_input input_select">
                        <div class="fb_input_inside">
                            <input type="hidden" name="reservist" value="{{ $item->reservist ?? 0 }}">
                            <div class="select">
                                <div class="current_select">
                                    <span>
                                        @if( isset($item) )
                                            @switch( $item->reservist )
                                                @case (0) Не військовозобов'язаний @break
                                                @case (1) Військовозобов’язаний @break
                                                @case (2) Призовник @break
                                            @endswitch
                                        @endif
                                    </span>
                                </div>
                                <div class="options">
                                    <div>
                                        <div class="option" data-id="0">Не військовозобов'язаний</div>
                                        <div class="option" data-id="1">Військовозобов’язаний</div>
                                        <div class="option" data-id="2">Призовник</div>
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
                            <label for="name">Реквізити банківського рахунку – IBAN</label>
                        </div>
                    </div>
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <input type="text" name="iban" value="{{ $item->iban ?? '' }}" >
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

            <div class="form_block active fb_submit">
                <!-- button -->
                    @include('admin.buttons')
                <!-- button -->
            </div>
           
        </form>
    </div>
</section>
@endsection