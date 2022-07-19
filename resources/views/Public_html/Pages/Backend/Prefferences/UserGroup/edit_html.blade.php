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
                                                            @if($userGroup->user_id == $value->id) 
                                                                <option value="{{$value->id}}" selected>{{$value->title}}</option>
                                                            @else
                                                                <option value="{{$value->id}}">{{$value->title}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="group" class="col-sm-2 control-label">Group</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="group">
                                                    @if(isset($groups) && !empty($groups))
                                                        @foreach($groups AS $keyword => $value)
                                                            @if($userGroup->group_id == $value->id) 
                                                                <option value="{{$value->id}}" selected>{{$value->title}}</option>
                                                            @else
                                                                <option value="{{$value->id}}">{{$value->title}}</option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_active" class="col-sm-2 control-label">Is Active</label>
                                            <div class="col-sm-10">
                                                @if($controller['data']->is_active == 1)
                                                    @php $checked = ' checked'; @endphp
                                                @else
                                                    @php $checked = '';@endphp
                                                @endif
                                                <input type="checkbox" name="check" data-id="{{ base64_encode($controller['data']->id)}}" value="is_active"{{$checked}}> 
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <input type="text" name="id" value="{{ base64_encode($controller['data']->id)}}" hidden/>
                                        <button type="submit" id="submit_form_edit" class="btn btn-info">Submit</button>
                                        <button type="submit" id="close_form_edit" class="btn btn-default float-right">Cancel</button>
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