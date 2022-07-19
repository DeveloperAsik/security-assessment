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
                                            <label for="name" class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name" value="{{$module['data']->name}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="alias" class="col-sm-2 control-label">Alias</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="alias" class="form-control" id="alias" placeholder="alias" value="{{$module['data']->alias}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="rank" class="col-sm-2 control-label">Rank</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="rank" class="form-control" id="rank" placeholder="rank" value="{{$module['data']->rank}}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="description" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" name="description" id="description" name="description" >{{$module['data']->description}}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <div class="checkbox">
                                                    @php $is_active = ''; $is_active_value = 0;@endphp
                                                    @if ($module['data']->is_active == 1) 
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
                                        <input type="text" value="{{$module['data']->id}}" name="id" hidden />
                                        <button type="submit" id="submit_form" class="btn btn-info">Submit</button>
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