<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Edit Teams</h5>

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
                                        @if(isset($project_teams) && !empty($project_teams))
                                        <div class="form-group row">
                                            <label for="code" class="col-sm-2 control-label">Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="code" class="form-control" value="{{$project_teams->code}}" id="code" placeholder="code">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" value="{{$project_teams->name}}" id="name" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" value="{{$project_teams->email}}" id="email" placeholder="email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="phone_number" class="form-control" value="{{$project_teams->phone_number}}" id="phone_number" placeholder="phone_number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" >{{$project_teams->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_active" class="col-sm-2 control-label">Is Active</label>
                                            <div class="col-sm-10">
                                                @if($project_teams->is_active == 1)
                                                @php $checked = ' checked'; @endphp
                                                @else
                                                @php $checked = '';@endphp
                                                @endif
                                                <input type="checkbox" name="check" data-id="{{ base64_encode($project_teams->id)}}" value="is_active"{{$checked}}> 
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <input type="text" name="id" value="{{ base64_encode($project_teams->id)}}" hidden/>
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