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
                                            <label for="user_name" class="col-sm-2 control-label">User</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="user_name" value="{{($group_permission->user_name) ? $group_permission->user_name : '-'}}" class="form-control" id="user_name" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="first_name" class="col-sm-2 control-label">first_name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="first_name" value="{{($group_permission->first_name) ? $group_permission->first_name : '-'}}" class="form-control" id="first_name" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="last_name" class="col-sm-2 control-label">last_name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="last_name" value="{{($group_permission->last_name) ? $group_permission->last_name : '-'}}" class="form-control" id="last_name" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="user_email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="user_email" value="{{($group_permission->email) ? $group_permission->email : '-'}}" class="form-control" id="user_email" readonly>
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

                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <input type="text" name="user_id" value="{{($group_permission->user_id) ? $group_permission->user_id : 0}}" id="user_id" hidden>
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