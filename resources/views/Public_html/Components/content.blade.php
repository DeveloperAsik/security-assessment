@if(isset($_default_views) && !empty($_default_views))
    @foreach($_default_views AS $keyword => $value)
        @if($keyword == 'html')
            @include($value)   
        @endif
    @endforeach
@endif