<link rel="stylesheet" type="text/css" href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            Menu Tree
                        </h3>
                        <div class="card-tools">
                            <a href="/extraweb/menu/create" class="btn btn-success btn-sm" title="Click this button to add new permission!">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                            @if(isset($module) && !empty($module))
                            @foreach($module AS $keyword => $value)
                            <li class="nav-item">
                                <a class="nav-link{{($value->rank == 1) ? ' active' : ''}}" id="tab-{{$value->rank}}" data-module_id="{{$value->id}}" data-toggle="pill" href="#content-{{$value->rank}}" role="tab" aria-controls="{{$value->rank}}" aria-selected="true">{{$value->name}}</a>
                            </li>
                            @endforeach
                            @endif
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent" style="color:#000">
                            @if(isset($module) && !empty($module))
                            @foreach($module AS $key => $val)
                            <div class="tab-pane fade{{($val->rank == 1) ? ' show active' : ''}}" id="content-{{$val->rank}}" role="tabpanel" aria-labelledby="{{$val->rank}}">
                                <div class="col-md-12">
                                    <div class="portlet yellow-lemon box mt-2">
                                        <div class="portlet-title">
                                            <div class="caption">
                                                {{isset($title) ? $title : ''}}
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse">
                                                </a>
                                                <a href="#portlet-config" data-toggle="modal" class="config">
                                                </a>
                                                <a href="javascript:;" class="reload">
                                                </a>
                                                <a href="javascript:;" class="remove">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="portlet-body">
                                            <div id="tree_{{$val->id}}" class="tree-demo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@include('Public_html.Modals.Extraweb.Menu.modal_edit_node',['modules'=>$module])