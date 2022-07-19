<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="text-center">
            <img class="profile-user-img img-fluid img-circle" src="{{(isset($user->user_profile->photo) && !empty($user->user_profile->photo) && $user->user_profile->photo != "-") ? $user->user_profile->photo : config('app.base_media_uri') . '/images/user_profiles/avatar' . rand(1,5) . '.png' }}" alt="User profile picture">
            <a href="#" class="btn" style="margin:0px;position: absolute;right: 0px" title="Change photo" data-toggle="modal" data-target="#modal_change_picture">
                <i class="fas fa-edit"></i> 
            </a>
        </div>
        <h3 class="profile-username text-center">{{($user->user_profile->user_name) ? $user->user_profile->user_name : ''}}</h3>
        <p class="text-muted text-center">{{($user->user_profile->email) ? $user->user_profile->email : ''}}</p>
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>FB</b> <a class="float-right">{{($user->user_profile->facebook) ? $user->user_profile->facebook : ''}}</a>
            </li>
            <li class="list-group-item">
                <b>Twit</b> <a class="float-right">{{($user->user_profile->twitter) ? $user->user_profile->twitter : ''}}</a>
            </li>
            <li class="list-group-item">
                <b>Ins</b> <a class="float-right">{{($user->user_profile->instagram) ? $user->user_profile->instagram : ''}}</a>
            </li>
            <li class="list-group-item">
                <b>Link</b> <a class="float-right">{{($user->user_profile->linkedin) ? $user->user_profile->linkedin : ''}}</a>
            </li>
        </ul>
        <a href="{{config('app.base_extraweb_uri') . '/profile/update'}}" class="btn btn-primary btn-block"><b>update profile</b></a>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

<!-- About Me Box -->
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">About Me</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <strong><i class="fas fa-book mr-1"></i> Education</strong>
        <p class="text-muted">
            {{($user->user_profile->last_education) ? $user->user_profile->last_education : ''}}<br/>
            {{($user->user_profile->last_education_institution) ? $user->user_profile->last_education_institution : ''}}
        </p>
        <hr>
        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
        <p class="text-muted">{{($user->user_profile->address) ? $user->user_profile->address : ''}}</p>
        <hr>
        <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>
        <p class="text-muted">
            {!! ($user->user_profile->skill) ? html_entity_decode($user->user_profile->skill) : '' !!}
        </p>
        <hr>
        <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>
        <p class="text-muted">{!! ($user->user_profile->notes) ? html_entity_decode($user->user_profile->notes) : '' !!}</p>
    </div>
    <!-- /.card-body -->
</div>