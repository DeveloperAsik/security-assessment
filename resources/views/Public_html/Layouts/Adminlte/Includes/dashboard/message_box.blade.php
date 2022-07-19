@if(\Session::has('alert-msg'))
    @php $session = \Session::get('alert-msg'); @endphp
    @if($session && is_array($session))
        @foreach($session AS $keyword => $value)
            @if ($value['type'] == 'status_error_message_box')
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                {!! $value['message'] !!}
            </div>
            @endif
            @if ($value['type'] == 'status_warning_message_box')
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                {!! $value['message'] !!}
            </div>
            @endif
            @if ($value['type'] == 'status_info_message_box')
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                {!! $value['message'] !!}
            </div>
            @endif
            @if ($value['type'] ==  'status_success_message_box')
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                {!! $value['message'] !!}
            </div>
            @endif
        @endforeach
    @endif
@endif
@if(Session::get('warning-msg'))
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! Session::get('warning-msg') !!}
    </div>
@endif