<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<link href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
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
                                <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="team_id" class="col-sm-2 control-label">Photo</label>
                                            <div class="col-sm-10">
                                                <span class="label label-danger">
                                                    NOTE: 
												</span>
                                                &nbsp; This plugins works only on Latest Chrome, Firefox, Safari, Opera & Internet Explorer 10.
												 <div class="dropzone" id="my-dropzone"></div>
											</div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="team_id" class="col-sm-2 control-label">Project Team</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="team_id">
                                                    <option value="0">-- select one --</option>
                                                    @if(isset($teams['data']) && !empty($teams['data']))
                                                    @foreach($teams['data'] AS $keyword => $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="code" class="col-sm-2 control-label">Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="code" class="form-control" id="code" placeholder="code">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="user_name" class="col-sm-2 control-label">User Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="user_name" class="form-control" id="user_name" placeholder="user_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="first_name" class="col-sm-2 control-label">First Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last_name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email_address" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="email_address" class="form-control" id="email_address" placeholder="email_address">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone_number" class="col-sm-2 control-label">Phone Number</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="phone_number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" ></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_generate" class="col-sm-2 control-label">Generate user login</label>
                                            <div class="col-sm-10">
                                                <input type="checkbox" name="check" value="is_generate"> 
                                            </div>
                                        </div>

                                        <div class="form-group row group_list" style="display:none">
                                            <label for="group_id" class="col-sm-2 control-label">User Groups</label>
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
                                        <div class="form-group row group_list" style="display:none">
                                            <label for="permission_id" class="col-sm-2 control-label">Permission</label>
                                            <div class="col-sm-10">
                                                <select class="form-control permissions_multiselect" name="permission_id" multiple="multiple">
                                                    @if(isset($permissions['data']) && !empty($permissions['data']))
                                                    @foreach($permissions['data'] AS $keyword => $value)
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