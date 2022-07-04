<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<link rel="stylesheet" href="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/summernote/summernote-bs4.css">
<link rel="stylesheet" type="text/css" href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css"/>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="background-color:#fff; color:#000">
                    <div class="card-header">
                        <h5>Menu Access Permission</h5>
                    </div>
                    <div class="card-divider"></div>
                    <div class="card-table">
                        <div class="table-responsive-sm p-3" style="overflow:auto">
                            <table style="width:100%;background-color:#fff;color:#000;" class="table table-bordered" id="menu">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Level</th>
                                        <th>Rank</th>
                                        <th>Is Badge</th>
                                        <th>Is Open</th>
                                        <th>Is Active</th>
                                        <th>Is Allowed</th>
                                        <th>Group Name</th>
                                        <th>Module Name</th>
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
    </div>
</section>