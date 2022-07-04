<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card" style="background-color:#fff; color:#000">
                    <div class="card-header">
                        <h5>Developer Team Lists</h5>
                        <div class="card-tools">
                            <a href="{{config('app.base_extraweb_uri') . '/project/developer-teams/create'}}" class="btn btn-tool" title="click to open form for create new team">
                                <i class="fas fa-square-plus"></i>
                            </a>
                            <a type="button" class="btn btn-tool" data-card-widget="collapse" title="minimize window">
                                <i class="fas fa-minus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-divider"></div>
                    <div class="card-table">
                        <div class="table-responsive-sm p-3">
                            <table style="width:100%;background-color:#fff;color:#000; font-size:10px;" class="table table-bordered" id="project_team_developer">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>ID</th>
                                        <th>Photo</th>
                                        <th>Code</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email address</th>
                                        <th>Mobile Phone</th>
                                        <th>Team Name</th>
                                        <th>Logged in</th>
                                        <th>Status</th>
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