<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{config('app.base_extraweb_uri') .'/dashboard'}}" class="brand-link">
        <span class="brand-text font-weight-light" style="padding-left:15px">{{'  SA Extraweb '}}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{config('app.base_assets_uri')}}/templates/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{config('app.base_extraweb_uri') .'/profile/view'}}" class="d-block">{{isset($__user_name) ? $__user_name : '-'}}</a>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if(isset($_sidebar_menu) && !empty($_sidebar_menu))
                    @foreach($_sidebar_menu AS $key1 => $val1)
                        <li class="nav-item{{ (isset($val1->is_open) && $val1->is_open == 1 ? ' menu-is-opening menu-open' : '') }}">
                            <a href="{{config('app.base_extraweb_uri') . $val1->path}}" class="nav-link">
                                {!! (isset($val1->icon) ? $val1->icon : '<i class="nav-icon fas fa-th"></i>') !!}
                                <p>
                                    {{$val1->name}}
                                    @if(isset($val1->child) && !empty($val1->child))
                                        <i class="fas fa-angle-left right"></i>
                                    @endif
                                    @if(isset($val1->is_badge) && $val1->is_badge )
                                        <span class="{{$val1->badge}}"{{($val1->badge_id) ? ' id="'.$val1->badge_id.'"' : ''}}>{{$val1->badge_value}}</span>
                                    @endif
                                </p>
                            </a>
                            @if(isset($val1->child) && !empty($val1->child))
                                @foreach($val1->child AS $key2 => $val2)
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item{{ (isset($val2->is_open) && $val2->is_open == 1 ? ' menu-is-opening menu-open' : '') }}">
                                            <a href="{{config('app.base_extraweb_uri') . $val2->path}}" class="nav-link" style="width:93%;margin-left:15px;">
                                                {!! (isset($val2->icon) ? $val2->icon : '<i class="nav-icon fas fa-th"></i>') !!}
                                                <p>
                                                    {{$val2->name}}
                                                    @if(isset($val2->child) && !empty($val2->child))
                                                        <i class="fas fa-angle-left right"></i>
                                                    @endif
                                                    @if(isset($val2->is_badge) && $val2->is_badge )
                                                        <span class="{{$val2->badge}}"{{($val2->badge_id) ? ' id="'.$val2->badge_id.'"' : ''}}>{{$val2->badge_value}}</span>
                                                    @endif
                                                </p>
                                            </a>
                                            @if(isset($val2->child) && !empty($val2->child))
                                                @foreach($val2->child AS $key3 => $val3)
                                                    <ul class="nav nav-treeview">
                                                        <li class="nav-item{{ (isset($val3->is_open) && $val3->is_open == 1 ? ' menu-is-opening menu-open' : '') }}">
                                                            <a href="{{config('app.base_extraweb_uri') . $val3->path}}" class="nav-link" style="width:87%;margin-left:30px;">
                                                                {!! (isset($val3->icon) ? $val3->icon : '<i class="nav-icon fas fa-th"></i>') !!}
                                                                <p>
                                                                    {{$val3->name}}
                                                                    @if(isset($val3->child) && !empty($val3->child))
                                                                        <i class="fas fa-angle-left right"></i>
                                                                    @endif
                                                                    @if(isset($val3->is_badge) && $val3->is_badge )
                                                                        <span class="{{$val3->badge}}"{{($val3->badge_id) ? ' id="'.$val3->badge_id.'"' : ''}}>{{$val3->badge_value}}</span>
                                                                    @endif
                                                                </p>
                                                            </a>
                                                             @if(isset($val3->child) && !empty($val3->child))
                                                                @foreach($val3->child AS $key4 => $val4)
                                                                    <ul class="nav nav-treeview">
                                                                        <li class="nav-item{{ (isset($val4->is_open) && $val4->is_open == 1 ? ' menu-is-opening menu-open' : '') }}">
                                                                            <a href="{{config('app.base_extraweb_uri') . $val4->path}}" class="nav-link" style="width:84%;margin-left:45px;">
                                                                                {!! (isset($val4->icon) ? $val4->icon : '<i class="nav-icon fas fa-th"></i>') !!}
                                                                                <p>
                                                                                    {{$val4->name}}
                                                                                    @if(isset($val4->child) && !empty($val4->child))
                                                                                        <i class="fas fa-angle-left right"></i>
                                                                                    @endif
                                                                                    @if(isset($val4->is_badge) && $val4->is_badge )
                                                                                        <span class="{{$val4->badge}}"{{($val4->badge_id) ? ' id="'.$val4->badge_id.'"' : ''}}>{{$val4->badge_value}}</span>
                                                                                    @endif
                                                                                </p>
                                                                            </a>
                                                                            @if(isset($val4->child) && !empty($val4->child))
                                                                                @foreach($val4->child AS $key5 => $val5)
                                                                                    <ul class="nav nav-treeview">
                                                                                        <li class="nav-item{{ (isset($val5->is_open) && $val5->is_open == 1 ? ' menu-is-opening menu-open' : '') }}">
                                                                                            <a href="{{config('app.base_extraweb_uri') . $val5->path}}" class="nav-link" style="width:84%;margin-left:45px;">
                                                                                                {!! (isset($val5->icon) ? $val5->icon : '<i class="nav-icon fas fa-th"></i>') !!}
                                                                                                <p>
                                                                                                    {{$val5->name}}
                                                                                                    @if(isset($val5->child) && !empty($val5->child))
                                                                                                        <i class="fas fa-angle-left right"></i>
                                                                                                    @endif
                                                                                                    @if(isset($val5->is_badge) && $val5->is_badge )
                                                                                                        <span class="{{$val5->badge}}"{{($val5->badge_id) ? ' id="'.$val5->badge_id.'"' : ''}}>{{$val5->badge_value}}</span>
                                                                                                    @endif
                                                                                                </p>
                                                                                            </a>
                                                                                        </li>
                                                                                    </ul>
                                                                                @endforeach
                                                                            @endif
                                                                        </li>
                                                                    </ul>
                                                                @endforeach
                                                            @endif
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </li>
                                    </ul>
                                @endforeach
                            @endif
                        </li>
                    @endforeach
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>