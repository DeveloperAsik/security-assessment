<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Create new User</h5>

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
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-sm-3">
                                    <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                        <a class="nav-link active" id="vert-tabs-home-tab" data-toggle="pill" href="#vert-tabs-home" role="tab" aria-controls="vert-tabs-home" aria-selected="true">Detail</a>
                                        <a class="nav-link" id="vert-tabs-profile-tab" data-toggle="pill" href="#vert-tabs-profile" role="tab" aria-controls="vert-tabs-profile" aria-selected="false">Profile</a>
                                        <a class="nav-link" id="vert-tabs-messages-tab" data-toggle="pill" href="#vert-tabs-messages" role="tab" aria-controls="vert-tabs-messages" aria-selected="false">Group & Permission</a>
                                        <a class="nav-link" id="vert-tabs-settings-tab" data-toggle="pill" href="#vert-tabs-settings" role="tab" aria-controls="vert-tabs-settings" aria-selected="false">Menu & Permission</a>
                                    </div>
                                </div>
                                <div class="col-7 col-sm-9">
                                    <div class="tab-content" id="vert-tabs-tabContent">
                                        <div class="tab-pane text-left fade show active" id="vert-tabs-home" role="tabpanel" aria-labelledby="vert-tabs-home-tab">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="user_name" class="col-sm-2 control-label">User name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="user_name" class="form-control" id="user_name" placeholder="user_name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="first_name" class="col-sm-2 control-label">First name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="first_name" class="form-control" id="first_name" placeholder="first_name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="last_name" class="col-sm-2 control-label">Last name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="last_name" class="form-control" id="last_name" placeholder="last_name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="email" class="form-control" id="email" placeholder="email">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" id="description" name="description" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" value="1" name="is_active"> Is Active 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="vert-tabs-profile" role="tabpanel" aria-labelledby="vert-tabs-profile-tab">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="address" class="col-sm-2 control-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="address" id="address" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="lat" class="col-sm-2 control-label">Latitude</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="lat" class="form-control" id="lat" placeholder="Latitude">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="lng" class="col-sm-2 control-label">Longitude</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="lng" class="form-control" id="lng" placeholder="Longitude">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="zoom" class="col-sm-2 control-label">Zoom</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="zoom" class="form-control" id="zoom" placeholder="zoom">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="facebook" class="col-sm-2 control-label">Facebook</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="facebook" class="form-control" id="facebook" placeholder="facebook">
                                                    </div>
                                                </div>    
                                                <div class="form-group row">
                                                    <label for="twitter" class="col-sm-2 control-label">Twitter</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="twitter" class="form-control" id="twitter" placeholder="twitter">
                                                    </div>
                                                </div>    
                                                <div class="form-group row">
                                                    <label for="instagram" class="col-sm-2 control-label">Instagram</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="instagram" class="form-control" id="instagram" placeholder="instagram">
                                                    </div>
                                                </div>    
                                                <div class="form-group row">
                                                    <label for="linkedin" class="col-sm-2 control-label">Linkedin</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="linkedin" class="form-control" id="linkedin" placeholder="linkedin">
                                                    </div>
                                                </div>    
                                                <div class="form-group row">
                                                    <label for="last_education" class="col-sm-2 control-label">Last Education level</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="last_education" class="form-control" id="last_education" placeholder="last_education">
                                                    </div>
                                                </div>  
                                                <div class="form-group row">
                                                    <label for="last_education_institution" class="col-sm-2 control-label">Last Education Instutition</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" name="last_education_institution" class="form-control" id="last_education_institution" placeholder="last_education_institution">
                                                    </div>
                                                </div>  
                                                <div class="form-group row">
                                                    <label for="skill" class="col-sm-2 control-label">Skill</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="skill" id="skill" ></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="notes" class="col-sm-2 control-label">Notes</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="notes" id="notes" ></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="vert-tabs-messages" role="tabpanel" aria-labelledby="vert-tabs-messages-tab">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="group" class="col-sm-2 control-label">Group</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control group_multiselect" name="group_id" multiple="multiple">
                                                            @if(isset($groups) && !empty($groups))
                                                            @foreach($groups AS $keyword => $value)
                                                            <option value="{{$value->id}}">{{$value->title}}</option>
                                                            @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="permission_id" class="col-sm-2 control-label">Permissions</label>
                                                    <div class="form-group col-sm-10">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permission_option" value="all">
                                                            <label class="form-check-label">Select all</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permission_option" value="basic">
                                                            <label class="form-check-label">Basic Permission</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="permission_option" value="manual">
                                                            <label class="form-check-label">Select Manual</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <div class="table-responsive-sm" id="select_basic_permission" style="display:none">
                                                        <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="tbl_basic_permission">
                                                            <thead>
                                                                <tr role="row" class="heading">
                                                                    <th>ID</th>
                                                                    <th>Title</th>
                                                                    <th>Path</th>
                                                                    <th>Controller</th>
                                                                    <th>Method</th>
                                                                    <th>Module</th>
                                                                    <th>Allow</th>
                                                                </tr>		
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive-sm p-3" id="select_manual_permission" style="display:none">
                                                        <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="permission_select">
                                                            <thead>
                                                                <tr role="row" class="heading">
                                                                    <th>ID</th>
                                                                    <th>Title</th>
                                                                    <th>Path</th>
                                                                    <th>Controller</th>
                                                                    <th>Method</th>
                                                                    <th>Module</th>
                                                                    <th>Allow</th>
                                                                </tr>		
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="vert-tabs-settings" role="tabpanel" aria-labelledby="vert-tabs-settings-tab">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="menu_id" class="col-sm-3 control-label">Menu Permission</label>
                                                    <div class="form-group col-sm-9">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="menu_option" value="all">
                                                            <label class="form-check-label">Select all</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="menu_option" value="basic">
                                                            <label class="form-check-label">Basic Permission</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="menu_option" value="manual">
                                                            <label class="form-check-label">Select Manual</label>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="form-group col-sm-12">
                                                    <div class="table-responsive-sm" id="select_basic_menu" style="display:none">
                                                        <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="menu_select_basic">
                                                            <thead>
                                                                <tr role="row" class="heading">
                                                                    <th>ID</th>
                                                                    <th>Name</th>
                                                                    <th>Path</th>
                                                                    <th>Level</th>
                                                                    <th>Rank</th>
                                                                    <th>Module Name</th>
                                                                    <th>Allow</th>
                                                                </tr>		
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="table-responsive-sm" id="select_manual_menu" style="display:none">
                                                        <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="menu_select">
                                                            <thead>
                                                                <tr role="row" class="heading">
                                                                    <th>ID</th>
                                                                    <th>Name</th>
                                                                    <th>Path</th>
                                                                    <th>Level</th>
                                                                    <th>Rank</th>
                                                                    <th>Module Name</th>
                                                                    <th>Allow</th>
                                                                </tr>							
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" id="submit_form" class="btn btn-info">Submit</button>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </form>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>