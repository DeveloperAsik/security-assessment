<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<link href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">

<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="background-color:#fff; color:#000">
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
                    <div class="card-divider"></div>
                    <div class="card-table">
                        <div class="table-responsive-sm p-3">
                            <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="permissions">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Path</th>
                                        <th>Controller</th>
                                        <th>Method</th>
                                        <th>Is Basic</th>
                                        <th>Is Public</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>							
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>