<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Monthly Recap Report</h5>

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
                                            <label for="url" class="col-sm-2 control-label">url</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="url" class="form-control" id="url" placeholder="url">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="module" class="col-sm-2 control-label">module</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="module" name="module">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($modules) && !empty($modules))
                                                    @foreach($modules AS $keyword => $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="route" class="col-sm-2 control-label">route</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="route" class="form-control" id="route" placeholder="route">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="class" class="col-sm-2 control-label">class</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="class" class="form-control" id="class" placeholder="class">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="method" class="col-sm-2 control-label">method</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="method" class="form-control" id="method" placeholder="method">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" ></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="is_generated_view" value="1"> Is Generated View
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="is_allowed" value="1"> Is Allowed
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="is_public" value="1"> Is Public 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_form_add_permission" class="btn btn-info">Submit</button>
                                        <button type="submit" id="close_form_add_permission" class="btn btn-default float-right">Cancel</button>
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