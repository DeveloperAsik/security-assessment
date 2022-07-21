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
                                                <select class="form-control" name="group_id" disabled>
                                                    @if(isset($groups['data']) && !empty($groups['data']))
                                                        @foreach($groups['data'] AS $keyword => $value) 
                                                            @if($userMenu['data']->group_id == $value->id) 
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
                                            <label for="menu_id" class="col-sm-2 control-label">Menu</label>
                                            <div class="col-sm-10" >
                                               @if(isset($userMenu['data']->menu_name) && !empty($userMenu['data']->menu_name))
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <button type="button" class="btn btn-danger" id="changeInToSel">Click to change value</button>
                                                    </div>
                                                    <!-- /btn-group -->
                                                    @php $parent_name = isset($userMenu['data']->parent_menu_name) ? $userMenu['data']->parent_menu_name : 'root'; @endphp
                                                    <input name="menu_id" type="text" class="form-control" value="{{$parent_name .' - '.$userMenu['data']->menu_name}}" title="click to change" readonly />
                                                </div>
                                                <input value="{{$userMenu['data']->id}}" name="menu_id" hidden>
                                                </select>
                                               @endif
                                               <div id="selPermission"></div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="module_id" class="col-sm-2 control-label">Modules</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="module_id" name="module_id">
                                                    @if(isset($modules['data']) && !empty($modules['data']))
                                                        @foreach($modules['data'] AS $keyword => $value)
                                                            @if($userMenu['data']->module_id == $value->id) 
                                                                <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                                            @else
                                                                <option value="{{$value->id}}">{{$value->name}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_allowed = ''; $is_active_value = 0;@endphp
                                                    @if ($userMenu['data']->is_allowed == 1) 
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
                                                    @if ($userMenu['data']->is_active == 1) 
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