@extends('layouts.front')

@section('content')

<div class="page_wrapper">
    


    <div class="container">    
        <div class="page_wrapper_inner">
            <div class="page_content_wrap">
            

            <div class="page_content">
                <h1 class="h2">Анкета</h1>

                    

                    <div class="form_block_items form_add form_edit">
                        <form action="{{ route('front.postQuestionary') }}" method="POST">
                            {{ csrf_field() }} 
                            <input type="hidden" name="id" value="0">
                            <div class="select_bg"></div>

                            <div class="form_block">
                                <div class="fb_inside">
                                    <div class="fb_label">
                                        <div class="fb_label_inside">
                                            <label for="name">Прізвище, ім'я, по батькові</label>
                                        </div>
                                    </div>
                                    <div class="fb_input">
                                        <div class="fb_input_inside">
                                            <input type="text" name="name" value="{{ old('name') }}" autocomplete="off" required>
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
                                            <input type="hidden" name="sex" value="0">
                                            <div class="select">
                                                <div class="current_select">
                                                    <span></span>
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
                                        <div class="fb_input_inside postList">
                                            <input type="hidden" name="post_id" value="0">
                                            <div class="select">
                                                <div class="current_select">
                                                    <span>
                                                        
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
                                            <input type="text" name="project" value="{{ old('project') }}" autocomplete="off"  >
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
                                            <textarea type="text" name="pasport" >{{ old('pasport') }}</textarea>
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
                                            <input type="text" name="inn" value="{{ old('inn') }}" autocomplete="off" >
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
                                            <textarea type="text" name="zagran_pasport" >{{ old('zagran_pasport') }}</textarea>
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
                                            <input type="text" name="birthday" value="{{ old('birthday') }}" readonly class="datepicker">
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
                                            <input type="email" name="email" value="{{ old('email') }}" >
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
                                            <input type="text" name="phone" value="{{ old('phone') }}" >
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
                                            <textarea type="text" name="education" >{{ old('education') }}</textarea>
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
                                            <input type="text" name="address" value="{{ old('address') }}" >
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
                                            <input type="text" name="residential_addresses" value="{{ old('residential_addresses') }}" >
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
                                            <input type="text" name="family_status" value="{{ old('family_status') }}">
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
                                            <textarea type="text" name="children" >{{ old('children') }}</textarea>
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
                                            <textarea type="text" name="preferential_documents" >{{ old('preferential_documents') }}</textarea>
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
                                            <input type="hidden" name="reservist" value="0">
                                            <div class="select">
                                                <div class="current_select">
                                                    <span></span>
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
                                            <input type="text" name="iban" value="{{ old('iban') }}" >
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
                                            <input type="hidden" name="employment" value="0">
                                            <div class="select">
                                                <div class="current_select">
                                                    <span></span>
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


                    
        </div>
    </div>
</div>
@endsection
