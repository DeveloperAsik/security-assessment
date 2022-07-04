@if(isset($_modal_data) && !empty($_modal_data))
    @foreach($_modal_data AS $keyword => $value)
        @include($value['path'])
    @endforeach
@endif