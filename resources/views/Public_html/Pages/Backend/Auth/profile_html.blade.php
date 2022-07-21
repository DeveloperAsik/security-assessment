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
                            <li class="nav-item"><a class="nav-link active" id="activity_nav" href="#activity" data-toggle="tab">Activity</a></li>
                            <li class="nav-item"><a class="nav-link" href="#logs" id="logs_nav" data-toggle="tab">Logs</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="activity">
                                <!-- Post -->
                                @include('Public_html.Widgets.Backend.Post.profile')
                                <!-- /.post -->
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="logs">
                                <!-- The timeline -->
                                @if(isset($logs) && !empty($logs))
                                <div id="result_logs"></div>
                                <div id="paging_options" data-offset="{{$logs['meta']['offset']}}" data-limit="{{$logs['meta']['limit']}}"></div>
                                <div class="timeline timeline-inverse">
                                    <!-- timeline time label -->
                                    @foreach($logs['data'] AS $keyword => $value)
                                    <div class="time-label">
                                        <span class="bg-danger">
                                            {{$value->createdDate}}
                                        </span>
                                    </div>
                                    <!-- /.timeline-label -->
                                    <!-- timeline item -->
                                    <div>
                                        <i class="fas fa-envelope bg-primary"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i>{{$value->createdDateHour}}</span>
                                            <h3 class="timeline-header">{{$value->user_name . ' ('. $value->email.')'}}</h3>
                                            <div class="timeline-body">
                                                Accessing class : {{$value->class}} <br/>
                                                Class action : {{$value->method}} <br/>
                                                Type : {{$value->event}} <br/>
                                                {{$value->fraud_scan}}
                                            </div>
                                            <div class="timeline-footer">
                                                <code style="font-size:10px">{{$value->browser}}</code>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END timeline item -->
                                    @endforeach 
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->
        </div>
    </div>
</section>