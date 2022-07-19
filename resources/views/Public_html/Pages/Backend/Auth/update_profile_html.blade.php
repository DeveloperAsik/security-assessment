<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" type="text/css" href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"/>
<link rel="stylesheet" type="text/css" href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">

<style>
    .change_password{
        display:none;
    }
    .table-responsive-sm{
        overflow: auto;
    }
    .form-check-input {
        position: absolute;
        margin-top: .3rem;
        margin-left: 0rem;
    }
    table.dataTable thead th, table.dataTable thead td{
        padding: 0px;
        text-align:center;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <!-- Profile Image -->
                @include('Public_html.Widgets.Backend.sidebar.sidebar_profile')
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#details" data-toggle="tab">Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="#prefferences" data-toggle="tab">Location & Social Media</a></li>
                            <li class="nav-item"><a class="nav-link" href="#group_permission" data-toggle="tab">Group & Permission</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="details">
                                <form class="form-horizontal" id="form-detail">
                                    <div class="form-group">
                                        <label for="inputName" class="col-sm-2 control-label">Nick Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="user_name" value="{{$user->user_profile->user_name}}" class="form-control" id="inputName" placeholder="Nick Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="first_name" class="col-sm-2 control-label">First Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="first_name" value="{{$user->user_profile->first_name}}" class="form-control" id="first_name" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name" class="col-sm-2 control-label">Last Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="last_name" value="{{$user->user_profile->last_name}}" class="form-control" id="last_name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" name="email" disabled value="{{$user->user_profile->email}}" class="form-control" id="inputEmail" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="change_password" value="1"> Change Password
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group change_password">
                                        <label for="old_password" class="col-sm-3 control-label">Old Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="old_password" id="old_password" placeholder="Old Password">
                                        </div>
                                    </div>
                                    <div class="form-group change_password">
                                        <label for="new_password" class="col-sm-3 control-label">New Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control"  name="new_password"id="new_password" placeholder="New Password">
                                        </div>
                                    </div>
                                    <div class="form-group change_password">
                                        <label for="new_password2" class="col-sm-3 control-label">Re Type Password</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="new_password2" id="new_password2" placeholder="Re Type new Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="prefferences">
                                <form class="form-horizontal" id="form-prefferences">
                                    <div class="form-group">
                                        <label for="address" class="col-sm-4 control-label">Address</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="address" name="address" >{{ ($user->user_profile->address) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="zoom" class="col-sm-4 control-label">Zoom</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->zoom}}" name="zoom" id="Facebook" placeholder="zoom">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lat" class="col-sm-4 control-label">Latitude</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->lat}}" name="lat" id="Facebook" placeholder="lat">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lng" class="col-sm-4 control-label">Longitude</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->lng}}" name="lng" id="Facebook" placeholder="lng">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Facebook" class="col-sm-4 control-label">Facebook</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->facebook}}" name="facebook" id="Facebook" placeholder="Facebook">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Twitter" class="col-sm-4 control-label">Twitter</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->twitter}}" name="twitter" id="Twitter" placeholder="Twitter">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Instagram" class="col-sm-4 control-label">Instagram</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->instagram}}" name="instagram" id="Instagram" placeholder="Instagram">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="Linkedin" class="col-sm-4 control-label">Linkedin</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->linkedin}}" name="linkedin" id="Linkedin" placeholder="Linkedin">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_education" class="col-sm-4 control-label">Last Education</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->last_education}}" name="last_education" id="last_education" placeholder="Last Education">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="last_education_institution" class="col-sm-4 control-label">Last Education Institution</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$user->user_profile->last_education_institution}}" name="last_education_institution" id="last_education_institution" placeholder="Last Education Institution">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="skill" class="col-sm-4 control-label">Skill</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="skill" name="skill" >{{ ($user->user_profile->skill) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="notes" class="col-sm-4 control-label">Notes</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" id="notes" name="notes" >{{ ($user->user_profile->notes) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-8">
                                            <button type="submit" class="btn btn-danger">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="group_permission">
                                <div class="col-sm-12">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="Group" class="col-sm-3 control-label">Group</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" readonly="" value="{{$user->user_profile->group_name}}" name="group" id="Group" placeholder="Group">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="add_permission" class="col-sm-3 control-label">Add permission</label>
                                            <div class="col-sm-9">
                                                <input type="checkbox" name="add_permission" class="form-check-input">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card card-info" id="form_new_permission" style="display:none">
                                        <!-- /.card-header -->
                                        <!-- form start -->
                                        <form class="form-horizontal">
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label for="module" class="col-sm-2 control-label">Module</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control" id="module" name="module">
                                                            <option value="0">-- select one --</option>
                                                            @if(isset($modules['data']) && !empty($modules['data']))
                                                                @foreach($modules['data'] AS $keyword => $value)
                                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="group" class="col-sm-2 control-label">Permissions</label>
                                                    <div class="col-sm-10">
                                                        <select class="form-control permissions_multiselect" name="permissions" multiple="multiple">
                                                            @if(isset($permissions['data']) && !empty($permissions['data']))
                                                                @foreach($permissions['data'] AS $keyword => $value)
                                                                    <option style="font-size:10px" value="{{$value->id}}">{{'#'.$value->id .' - '.$value->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="description" class="col-sm-2 control-label">Description</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" name="description" id="description" name="description" ></textarea>
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
                                                                <input type="checkbox" name="is_active" value="1"> Is Active 
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <button type="submit" id="submit_form_add_permission" class="btn btn-info">Submit</button>
                                            </div>
                                            <!-- /.card-footer -->
                                        </form>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="card" style="background-color:#fff; color:#000">
                                        <div class="card-header">
                                            <h5>Group Permission</h5>
                                        </div>
                                        <div class="card-divider"></div>
                                        <div class="card-table">
                                            <div class="table-responsive-sm p-3">
                                                <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="group_permissions">
                                                    <thead>
                                                        <tr role="row" class="heading">
                                                            <th>ID</th>
                                                            <th>Route</th>
                                                            <th>Url</th>
                                                            <th>Class</th>
                                                            <th>Method</th>
                                                            <th>Public</th>
                                                            <th>Allowed</th>
                                                            <th>Active</th>
                                                        </tr>							
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>