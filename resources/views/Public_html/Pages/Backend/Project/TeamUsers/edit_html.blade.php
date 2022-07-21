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
                                            <label for="group" class="col-sm-2 control-label">Parent Group</label>
                                            <div class="col-sm-10">
                                                <select class="form-control" name="group_id">
                                                    @if(isset($group_exist['data']) && !empty($group_exist['data']))
                                                        @foreach($group_exist['data'] AS $keyword => $value)
                                                            @if($group['data']->parent_id == $value->id)
                                                                <option value="{{$value->id}}" selected>{{$value->name}}</option>
                                                            @else
                                                                @if($value->parent_id == 0)
                                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                                @elseif($value->parent_id > $value->id)
                                                                    <option value="{{$value->id}}">-{{$value->name}}</option>
                                                                @elseif($value->parent_id >= 0)
                                                                    <option value="{{$value->id}}"> -- {{$value->parent_name . ' -- #' . $value->id . ' ' . $value->name}}</option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$group['data']->name}}" name="name" class="form-control" id="name" placeholder="title">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" >{{$group['data']->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rank" class="col-sm-2 control-label">Rank</label>
                                            <div class="col-sm-10">
                                                <input type="text" value="{{$group['data']->rank}}" name="rank" class="form-control" id="rank" placeholder="rank">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_menu" class="col-sm-2 control-label">Is Menu</label>
                                            <div class="col-sm-10">
                                                @if($group['data']->is_menu == 1)
                                                    @php $checked_menu = ' checked'; @endphp
                                                @else
                                                    @php $checked_menu = '';@endphp
                                                @endif
                                                <input type="checkbox" name="check" data-id="{{ base64_encode($group['data']->id)}}" value="is_menu"{{$checked_menu}}> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="is_active" class="col-sm-2 control-label">Is Active</label>
                                            <div class="col-sm-10">
                                                @if($group['data']->is_active == 1)
                                                    @php $checked = ' checked'; @endphp
                                                @else
                                                    @php $checked = '';@endphp
                                                @endif
                                                <input type="checkbox" name="check" data-id="{{ base64_encode($group['data']->id)}}" value="is_active"{{$checked}}> 
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <input type="text" name="id" value="{{ base64_encode($group['data']->id)}}" hidden/>
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