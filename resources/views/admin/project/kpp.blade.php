@extends('layouts.admin')


@section('content')

<section class="add_category edit_category main_section">
    <div class="title_h1">
        
        <div class="top_block">
            <a href="{{ route('admin.project') }}" class="back_to">Назад</a>
        </div>
        
        <h1>КПП "{{ $item->name }}"</h1>

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

            <div class="projectKPP">
                <div class="workList">
                        <div class="row big">
                            Виробництво
                        </div>
                        <div class="row">
                           
                        </div>
                        <div class="row">
                           
                        </div>
                        @foreach($item->calendar as $k => $cal)
                        <div class="row"  data-row="{{ $k+1 }}" data-limit="0">
                            <textarea readonly>{{ $cal->production_periods }}</textarea>
                           <div class="add_new_item">
                                <div class="add_item addKPPRow"></div>
                            </div>
                        </div>
                            @if( isset($projectKPPitems[$k+1]) )
                                @foreach($projectKPPitems[$k+1] as $pitem)
                                    @if( $pitem->count_id !=0 )
                                    <div class="row" data-row-{{ $pitem->row_id }}="{{ $pitem->count_id }}" data-row-id="{{ $pitem->row_id }}" data-count-id="{{ $pitem->count_id }}">
                                            <textarea class="block_name">{{ $pitem->title }}</textarea>
                                            <div class="edit_link removeBlock" onclick="removeKPPRow({{ $pitem->row_id }},{{ $pitem->count_id }})">
                                                <object type="image/svg+xml" data="/images/admin/icons/delete.svg"></object>
                                            </div>
                                    </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        <div class="row">
                           
                        </div>
                        <div class="row">
                            Ефір
                        </div>
                        <div class="row">
                           
                        </div>
                        <div class="row">
                            <div class="colorset" id="color_49">1</div>
                            <div class="colorset" id="color_50">2</div>
                            <div class="colorset" id="color_51">3</div>
                            <div class="colorset" id="color_52">4</div>
                            <div class="colorset" id="color_53">5</div>
                            <div class="colorset" id="color_54">6</div>
                            <div class="colorset" id="color_55">7</div>
                            <div class="colorset" id="color_56">8</div>
                            <div class="colorset" id="color_57">9</div>
                            <div class="colorset" id="color_48">0</div>
                            <div class="colorset" >esc</div>
                        </div>

                </div>
                <div class="dayList">
                    <div class="owerflow">
                       
                        <div class="row middle">
                            @foreach($dateList as $day)
                            <div class="day {{ $hol[$day] }}" data-day="{{ $day }}">
                                <div class="rot">
                                    <span>{{ $day }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="row">
                        @foreach($dateList as $day)
                            <div class="day {{ $hol[$day] }}" data-day="{{ $day }}">
                                {{ $dayOfWeek[$day] }} 
                            </div>
                        @endforeach
                        </div>
                        <div class="row">
                           
                        </div>
                        @foreach($item->calendar as $k => $cal)
                            <div class="row" data-row="{{ $k+1 }}" data-row-id="{{ $k+1 }}" data-count-id="0">
                                @foreach($dateList as $d => $day)
                                    <div class="day {{ $hol[$day] }}" 
                                        
                                        @if( $cal->start_production <= $d && $d <= $cal->end_production )
                                            id="color_0"
                                        @endif
                                        >
                                    
                                    </div>
                                @endforeach
                            </div>
                            @if( isset($projectKPPitems[$k+1]) )
                                @foreach($projectKPPitems[$k+1] as $pitem)
                                    @if( $pitem->count_id !=0 )
                                        <div class="row" data-row-{{ $pitem->row_id }}="{{ $pitem->count_id }}" data-row-id="{{ $pitem->row_id }}" data-count-id="{{ $pitem->count_id }}">

                                            @foreach($dateList as $day)
                                            <div class="day {{ $hol[$day] }}" 
                                                    @if( isset($pitem->json[$day]) )
                                                    id="color_{{ $pitem->json[$day] }}"
                                                    @endif
                                                    data-day="{{ $day }}" 
                                                    data-row-id="{{ $pitem->row_id }}" 
                                                    data-count-id="{{ $pitem->count_id }}">
                                            
                                            </div>
                                            @endforeach

                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            
                        @endforeach
                        <div class="row">
                           
                        </div>
                        <div class="row">
                            @foreach($dateList as $day)
                                <div class="day {{ $hol[$day] }} @if( isset($efir[$day]) ) active @endif" data-day="{{ $day }}">
                                    @if( isset($efir[$day]) ) {{ $efir[$day] }} @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="row">
                           
                        </div>
                        
                        <div class="hide rowTPL">
                            <div class="row" REP>
                                @foreach($dateList as $day)
                                    <div class="day {{ $hol[$day] }}" data-day="{{ $day }}" data-row-id="row_id" data-count-id="count_id">
                                    
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</section>

@endsection