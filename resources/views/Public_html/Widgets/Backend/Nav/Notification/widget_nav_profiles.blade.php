@if(isset($__is_logged_in) && !empty($__is_logged_in))
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
        <span class="badge badge-success navbar-badge">o</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        @if(isset($_menu_profiles) && !empty($_menu_profiles))
            @foreach($_menu_profiles AS $keyword => $value)
            <div class="dropdown-divider"></div>
            <a href="{{ $value->path }}" class="dropdown-item">
                <i class="fas fa-users mr-2"></i> {{ $value->title }}
                <span class="float-right text-muted text-sm"><small>{{ $value->info }}</small></span>
            </a>
            @endforeach
        @endif
       
        <div class="dropdown-divider"></div>
    </div>
</li>
@endif