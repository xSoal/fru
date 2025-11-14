@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.project') }}" class="back_to">Назад</a>
        </div>
        
        <h1>Графік здачі випусків "{{ $item->name }}"</h1>

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

            <div class="projectSchedule">
                <div class="row">
                    <div class="count">№</div>
                    <div class="pre_master">
                        Перед майстер
                    </div>
                    <div class="master">
                        Майстер
                    </div>
                    <div class="ether">
                        Ефір
                    </div>
                </div>
                @if( count( $item->schedule ) !=0 )
                    @foreach($item->schedule as $k => $sch)
                    <div class="row">
                        <div class="count">{{ $k + 1 }}</div>
                        <div class="pre_master">
                            <input type="text" name="pre_master[]" value="{{ $sch->pre_master }}" class="datepickersmall" readonly>
                        </div>
                        <div class="master">
                            <input type="text" name="master[]" value="{{ $sch->master }}" class="datepickersmall" readonly>
                        </div>
                        <div class="ether">
                            <input type="text" name="ether[]" value="{{ $sch->ether }}" class="datepickersmall" readonly>
                        </div>
                    </div>
                    @endforeach
                @else
                    @for($i = 0; $i < $item->count_programs; $i++)
                    <div class="row">
                        <div class="count">{{ $i + 1 }}</div>
                        <div class="pre_master">
                            <input type="text" name="pre_master[]" value="" class="datepickersmall">
                        </div>
                        <div class="master">
                            <input type="text" name="master[]" value="" class="datepickersmall">
                        </div>
                        <div class="ether">
                            <input type="text" name="ether[]" value="" class="datepickersmall">
                        </div>
                    </div>
                    @endfor
                @endif
            </div>
            
            <div class="form_block active fb_submit">
                <div class="fb_inside">
                    <div class="fb_input">
                        <div class="fb_input_inside">
                            <button class="btn-save" name="updateSchedule" value="true" type="submit">Оновити</button>
                        </div>
                    </div>
                </div>
            </div>
           
        </form>
    </div>
</section>
@endsection