<!-- Select2 -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update Group Permission form page</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">Something else here</a>
                                    <a class="dropdown-divider"></a>
                                    <a href="#" class="dropdown-item">Separated link</a>
                                </div>
                            </div>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="id" class="col-sm-2 control-label">ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="id" class="form-control" id="id" placeholder="id" value="{{$group_permission->id}}" readonly="" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="group" class="col-sm-2 control-label">Group</label>
                                            <div class="col-sm-10">
                                                <select class="form-control group_multiselect" name="group_id" multiple="multiple">
                                                    @if(isset($groups) && !empty($groups))
                                                        @foreach($groups AS $keyword => $value)
                                                            @if($group_permission->group_id == $value->id) 
                                                                <option value="{{$value->id}}" selected>{{$value->title}}</option>
                                                            @else
                                                                <option value="{{$value->id}}">{{$value->title}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="module" class="col-sm-2 control-label">Permission</label>
                                            <div class="col-sm-10">
                                                <select class="form-control permission_multiselect" id="permission_id" name="permission_id" multiple="multiple">
                                                    @if(isset($permissions) && !empty($permissions))
                                                        @foreach($permissions AS $keyword => $value)
                                                            @if($group_permission->group_id == $value->id) 
                                                                <option value="{{$value->id}}" selected>{!! $value->id . " - " . $value->controller . " - " . $value->method . " <small>( " . $value->path . " )</small>" !!}</option>
                                                            @else
                                                                 <option value="{{$value->id}}">{!! $value->id . " - " . $value->controller . " - " . $value->method . " <small>( " . $value->path . " )</small>" !!}</option>
                                                            @endif
                                                           
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div> 
                                        
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_public = ''; $is_public_value = 0;@endphp
                                                    @if ($group_permission->is_public == 1) 
                                                        @php $is_public = ' checked'; $is_public_value = 1;@endphp
                                                    @endif
                                                    <label>
                                                        <input type="checkbox"{{$is_public}} value="{{$is_public_value}}" name="is_active"> Is Public 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_allowed = ''; $is_allowed_value = 0;@endphp
                                                    @if ($group_permission->is_allowed == 1) 
                                                        @php $is_allowed = ' checked'; $is_allowed_value = 1;@endphp
                                                    @endif
                                                    <label>
                                                        <input type="checkbox"{{$is_allowed}} value="{{$is_allowed_value}}" name="is_allowed"> Is Allowed 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_active = ''; $is_active_value = 0;@endphp
                                                    @if ($group_permission->is_active == 1) 
                                                        @php $is_active = ' checked'; $is_active_value = 1;@endphp
                                                    @endif
                                                    <label>
                                                        <input type="checkbox"{{$is_active}} value="{{$is_active_value}}" name="is_active"> Is Active 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_form_add_permission" class="btn btn-info">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </form>
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- ./card-body -->
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>