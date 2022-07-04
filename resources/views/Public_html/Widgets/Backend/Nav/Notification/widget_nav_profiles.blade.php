@if(isset($__is_logged_in) && !empty($__is_logged_in))
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-user"></i>
        <span class="badge badge-success navbar-badge">o</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="dropdown-divider"></div>
        <a href="/extraweb/profile/update" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Update Profile
            <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> Logs
            <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="/extraweb/logout" class="dropdown-item">
            <i class="fa fa-close mr-2"></i> Logout
        </a>
        <div class="dropdown-divider"></div>
    </div>
</li>
@endif