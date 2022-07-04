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
                                        <a class="nav-link{{($value->id == 1) ? ' active' : ''}}" id="tab-{{$value->id}}" data-module_id="{{$value->id}}" data-toggle="pill" href="#content-{{$value->id}}" role="tab" aria-controls="{{$value->id}}" aria-selected="true">{{$value->name}}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="tab-content" id="custom-content-below-tabContent" style="color:#000">
                            @if(isset($module) && !empty($module))
                                @foreach($module AS $key => $val)
                                    <div class="tab-pane fade{{($val->id == 1) ? ' show active' : ''}}" id="content-{{$val->id}}" role="tabpanel" aria-labelledby="{{$val->id}}">
                                        @include('Public_html.Widgets.Backend.Menu.Tab.tab_tree_module_' . $val->id,['id'=>$val->id,'title'=>$val->name])
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