<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{!! $_config['title_for_header'] !!}</h5>
                        <div class="card-tools">
                            <a href="{!! $_config['create_page']['link'] !!}" class="btn btn-tool" title="{!! $_config['create_page']['title'] !!}">
                                {!! $_config['create_page']['icon'] !!}
                            </a>
                            <a type="button" class="btn btn-tool" data-card-widget="collapse" title="minimize window">
                                <i class="fas fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-horizontal" id="form_update">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{$permission['data']->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="path" class="col-sm-2 control-label">Path</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="path" class="form-control" id="path" placeholder="path" value="{{$permission['data']->path}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="controller" class="col-sm-2 control-label">Controller</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="controller" class="form-control" id="controller" placeholder="class" value="{{$permission['data']->controller}}">
                                            </div>
                                        </div>
                                       
                                        <div class="form-group row">
                                            <label for="method" class="col-sm-2 control-label">Method</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="method" class="form-control" id="method" placeholder="method" value="{{$permission['data']->method}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" >{{$permission['data']->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_basic = ''; $is_basic_value = 0;@endphp
                                                    @if ($permission['data']->is_basic == 1) 
                                                        @php $is_basic = ' checked'; $is_basic_value = 1;@endphp
                                                    @endif
                                                    <label>
                                                        <input type="checkbox"{{$is_basic}} value="{{$is_basic_value}}" name="is_basic"> Is Basic
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_public = ''; $is_public_value = 0;@endphp
                                                    @if ($permission['data']->is_public == 1) 
                                                        @php $is_public = ' checked'; $is_public_value = 1;@endphp
                                                    @endif
                                                    <label>
                                                        <input type="checkbox"{{$is_public}} value="{{$is_public_value}}" name="is_public"> Is Public 
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_active = ''; $is_active_value = 0;@endphp
                                                    @if ($permission['data']->is_active == 1) 
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
                                        <input type="text" value="{{$permission['data']->id}}" name="id" hidden />
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