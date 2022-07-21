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
                                            <label for="code" class="col-sm-2 control-label">Code</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="code" class="form-control" id="code" placeholder="code">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="name" class="form-control" id="name" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" name="email" class="form-control" id="email" placeholder="email">
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