<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        @if(isset($_menu_navigation) && !empty($_menu_navigation))
            @foreach($_menu_navigation AS $key => $value)
                @php  $active = ''; @endphp
                @if(isset($_default_views['method']) && $_default_views['method'] == $value->key)
                    @php  $active = ' active'; @endphp
                @endif
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{$value->path}}" class="nav-link{{$active}}">{{$value->title}}</a>
                </li>
            @endforeach
        @endif
    </ul>
    @include('Public_html.Widgets.Backend.Nav.Search.widget_nav_search')
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        @include('Public_html.Widgets.Backend.Nav.Messages.widget_nav_message')
        @include('Public_html.Widgets.Backend.Nav.Notification.widget_nav_notification')
        @include('Public_html.Widgets.Backend.Nav.Notification.widget_nav_profiles')
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>