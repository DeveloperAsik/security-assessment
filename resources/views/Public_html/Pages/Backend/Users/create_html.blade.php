<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Create new User</h5>

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
                                            <label for="url" class="col-sm-2 control-label">User Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="user_name" class="form-control" id="user_name" placeholder="user_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="route" class="col-sm-2 control-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="class" class="col-sm-2 control-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="method" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="email" class="form-control" id="email" placeholder="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="method" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="password" class="form-control" id="password" placeholder="password">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="group_id" class="col-sm-2 control-label">Group User</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="group_id" name="group_id">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($groups) && !empty($groups))
                                                        @foreach($groups AS $keyword => $value)
                                                            <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="1" name="is_active"> Is Active 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_form_add_user" class="btn btn-info">Submit</button>
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