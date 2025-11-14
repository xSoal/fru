{{ $item->parrent->name ?? ''; }}
@if(isset($item->parrent_id) && $item->parrent_id !=0 ) 
    @include('admin.post.parrent', ['item' => $item->parrent, 'level' => 1])
@endif