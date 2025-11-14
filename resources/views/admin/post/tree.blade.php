@foreach( $post as $cat )
    <div class="option level_{{ $level }}" data-id="{{ $cat->id }}">
        @for($i = 0; $i < $level; $i++ )
            -
        @endfor

        {{ $cat->name }}
    </div>
    @if($cat->child->count() > 0)
        @php $tmp_l = $level+1; @endphp
        @include('admin.post.tree', ['post' => $cat->child, 'level' => $tmp_l ])
    @endif
@endforeach