<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Developer teams user  list</h5>

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
                                        @if(isset($project_team_user) && !empty($project_team_user))
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label" for="photo">Photo Profile</label>
                                            <div class="col-sm-10 input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="photo" name="photo">
                                                    <label class="custom-file-label" for="photo">Choose file</label>
                                                </div>
                                                <div class="input-group-append">
                                                    <span class="input-group-text" id="">Upload</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="code" class="col-sm-2 control-label">Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="code" class="form-control" id="code" placeholder="Code">
                                            </div>
                                        </div> <div class="form-group row">
                                            <label for="first_name" class="col-sm-2 control-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first_name">
                                            </div>
                                        </div> <div class="form-group row">
                                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last_name">
                                            </div>
                                        </div> <div class="form-group row">
                                            <label for="email_address" class="col-sm-2 control-label">Email Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="email_address" class="form-control" id="email_address" placeholder="email_address">
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="mobile_phone_number" class="col-sm-2 control-label">Mobile Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="mobile_phone_number" class="form-control" id="mobile_phone_number" placeholder="mobile_phone_number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_active" class="col-sm-2 control-label">Is Active</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_active"> 
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <input type="text" name="id" value="{{ base64_encode($project_types->id)}}" hidden/>
                                        <button type="submit" id="submit_form_edit" class="btn btn-info">Submit</button>
                                        <button type="submit" id="close_form_edit" class="btn btn-default float-right">Cancel</button>
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