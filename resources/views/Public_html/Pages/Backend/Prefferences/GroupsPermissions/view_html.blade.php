<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<link href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">

<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="background-color:#fff; color:#000">
                    <div class="card-header">
                        <h3 class="card-title">
                            Group Permission Lists
                        </h3>
                        <div class="card-tools">
                            <a href="/extraweb/prefferences/group_permission/create" class="btn btn-success btn-sm" title="Click this button to add new group permission!">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-divider"></div>
                    <div class="card-table">
                        <div class="table-responsive-sm p-3">
                            <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="group_permissions">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>ID</th>
                                        <th>User name</th>
                                        <th>Group Name</th>
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