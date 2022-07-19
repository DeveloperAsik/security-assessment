<!-- Select2 -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2/css/select2.min.css">
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
                                            <label for="user" class="col-sm-2 control-label">User</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="user" name="user">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($users['data']) && !empty($users['data']))
                                                        @foreach($users['data'] AS $keyword => $value)
                                                            <option value="{{$value->id}}">{{'#'. $value->id .' - '. $value->user_name .' - ' . $value->email}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="group" class="col-sm-2 control-label">Group</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" id="group" name="group">
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
                                            <label for="is_active" class="col-sm-2 control-label">Is Active</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_active"> 
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <div class="col-md-12" style="text-align: center">
                                            <code id="eMsg"></code>
                                        </div>
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