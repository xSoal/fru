@extends('layouts.admin')


@section('content')

<section class="product_type main_section">
    <div class="title_h1">
        <h1>Equipment requests</h1>
    </div>
    
    <div class="search_block">
        <div class="search_form">
            <form action="{{ route('admin.equipment_request_search') }}" method="GET" class="for_search">
                <div class="form_block fb_query">
                    <div class="fb_inside">
                        <div class="fb_label">
                            <div class="fb_label_inside label_search">
                                <label for="search_blog_category">Пошук</label>
                            </div>
                        </div>
                        <div class="fb_input">
                            <div class="fb_input_inside">
                                <input type="text" name="search" value="{{ $search ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form_block fb_submit">
                    <div class="fb_inside">
                        <div class="fb_input">
                            <div class="fb_input_inside">
                                <button class="btn-search" name="" value="true" type="submit">Пошук</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>


    </div>

    <br><br><br>

    <table class="custom-table custom-table-requests">
        <thead class="">
            <tr class="">
                <td>№</td>
                <td class="date">Дата публікації</td>
                <td class="">Назва</td>
                <td class="">Компанія</td>
                <td class="status">Статус</td>
            </tr>
        </thead>
        <tbody class="">
            @if( isset($items) && $items )
			    @foreach($items as  $k => $item)
                    <tr class="tr_block" data-id="{{ $item->id }}" data-type="equipment_request">
                        <div class="">
                            <td class="">{{ $item->code }}</td>
                            <td class="">{{ $item->created_at }}</td>
                            <td class="">{{ $item->name }} </td>
                            <td class="">{{ $item->user->name }}</td>
                            <td class="status">
                                <div class="form_block_items">
                                    <div class="form_block active">
                                        <div class="fb_inside">
                                            <div class="fb_input input_toggle">
                                                <div class="fb_input_inside">
                                                    <div class="toggle toggle_news {{ $item->active == 1 ? 'active' : '' }}">
                                                        <span></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </div>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </е>
    @if( isset($items) )
    {{ $items->appends(request()->query())->links() }}
    @endif
</section>

@endsection