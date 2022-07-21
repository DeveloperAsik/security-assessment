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
                                <form class="form-horizontal">
                                    <div class="card-body">
                                        
                                        <div class="form-group row">
                                            <label for="group_id" class="col-sm-2 control-label">Group</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="group_id">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($groups['data']) && !empty($groups['data']))
                                                    @foreach($groups['data'] AS $keyword => $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="permission_id" class="col-sm-2 control-label">Menu</label>
                                            <div class="col-sm-10" id="selPermission"></div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="module_id" class="col-sm-2 control-label">Modules</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="module_id" name="module_id">
                                                    @if(isset($modules['data']) && !empty($modules['data']))
                                                    @foreach($modules['data'] AS $keyword => $value)
                                                    <option value="{{$value->id}}">{{ $value->name }}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="is_allowed" class="col-sm-2 control-label">Is Allowed </label>
                                            <div class="col-sm-10">
                                                 <input type="checkbox" class="checkbox" value="1" name="is_allowed">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="module_id" class="col-sm-2 control-label">Is Active </label>
                                            <div class="col-sm-10">
                                                 <input type="checkbox" class="checkbox" value="1" name="is_active">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_form_add" class="btn btn-info">Submit</button>
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