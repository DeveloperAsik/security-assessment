<!-- Select2 -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<style>
    .select2-container {
        box-sizing: border-box;
        margin: 0px 0px 0px 6px;
        position: relative;
        width: 82% !important;
    }
</style>
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
                                            <label for="parent_menu" class="col-sm-2 control-label">Parent Menu</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="parent_menu">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($parents['data']) && !empty($parents['data']))
                                                        @foreach($parents['data'] AS $keyword => $value)
                                                            <option value="{{$value->id}}" data-level="{{$value->level}}">{{$value->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div> 
                                        <div id="result_menu" style="display:none"></div>
                                        <div class="form-group row">
                                            <label for="module_id" class="col-sm-2 control-label">Module</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="module_id" name="module_id">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($modules) && !empty($modules))
                                                        @foreach($modules['data'] AS $keyword => $value)
                                                        <option value="{{$value->id}}">{{$value->name}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="path" class="col-sm-2 control-label">Path</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="path" class="form-control" id="path" placeholder="path">
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label for="content_path" class="col-sm-2 control-label">Content Path</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="content_path" class="form-control" id="content_path" placeholder="content_path">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 control-label">Icon</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="icon" name="icon">
                                                    @if(isset($icons) && !empty($icons))
                                                        @foreach($icons['data'] AS $keyword => $value)
                                                            <option value="{{$value->class}}"> {{ $value->class }} </i></option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_badge" class="col-sm-2 control-label">Is Badge</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_badge"> 
                                            </div>
                                        </div>
                                        <div id="badgeID" style="display:none">
                                            
                                            <div class="form-group row">
                                                <label for="badge" class="col-sm-2 control-label">Badge</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="badge" class="form-control" id="badge" placeholder="badge">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="badge_id" class="col-sm-2 control-label">Badge class</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="badge_id" class="form-control" id="badge_id" placeholder="badge css class e.g : badge badge-info right">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="badge_value" class="col-sm-2 control-label">Badge Value</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="badge_value" class="form-control" id="badge_value" placeholder="badge_value">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_basic" class="col-sm-2 control-label">Is Basic</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_basic"> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_open" class="col-sm-2 control-label">Is Open</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_open"> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_active" class="col-sm-2 control-label">Is Active</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_active"> 
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_form_add_menu" class="btn btn-info">Submit</button>
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