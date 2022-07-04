<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Update Permission form page</h5>
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
                                                <input type="text" name="id" class="form-control" id="id" placeholder="id" value="{{$permission->id}}" readonly="" disabled>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="module" class="col-sm-2 control-label">Module</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="module" name="module_id">
                                                    @if(isset($modules) && !empty($modules))
                                                        @foreach($modules AS $keyword => $value)
                                                            @if($permission->module_id == $value->id) 
                                                                <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                                            @else
                                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="title" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="title" class="form-control" id="title" placeholder="title" value="{{$permission->title}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="path" class="col-sm-2 control-label">Path</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="path" class="form-control" id="path" placeholder="path" value="{{$permission->path}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="controller" class="col-sm-2 control-label">Controller</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="controller" class="form-control" id="controller" placeholder="class" value="{{$permission->controller}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="method" class="col-sm-2 control-label">Method</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="method" class="form-control" id="method" placeholder="method" value="{{$permission->method}}">
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" >{{$permission->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_active = ''; $is_active_value = 0;@endphp
                                                    @if ($permission->is_active == 1) 
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
                                        <input type="text" value="{{$permission->id}}" name="id" hidden />
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