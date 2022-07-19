<link rel="stylesheet" type="text/css" href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/jstree/dist/themes/default/style.min.css"/>
<style>
    .tab-pane{
        border: 1px solid #ccc;
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
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
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="tab_modules" role="tablist">
                            @if(isset($modules['data']) && !empty($modules['data']))
                                @foreach($modules['data'] AS $keyword => $value)
                                <li class="nav-item">
                                    <a class="nav-link{{($value->rank == 1) ? ' active' : ''}}" id="tab_module-{{$value->rank}}" data-module_id="{{$value->id}}" data-toggle="pill" href="#content_module-{{$value->rank}}" role="tab" aria-controls="{{$value->rank}}" aria-selected="true">{{$value->name}}</a>
                                </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="tab-content" id="tab_modules-content" style="color:#000">
                            @if(isset($modules['data']) && !empty($modules['data']))
                                @foreach($modules['data'] AS $key => $val)
                                <div class="tab-pane fade{{($val->rank == 1) ? ' show active' : ''}}" id="content_module-{{$val->rank}}" role="tabpanel" aria-labelledby="{{$val->rank}}">
                                    <div class="col-md-12">
                                        @include('Public_html.Widgets.Backend.Menu.tab.tab_' . strtolower($val->name),['modules'=>$modules,'groups'=>$groups])
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
@include('Public_html.Modals.Extraweb.Menu.modal_edit_node',['groups'=>$groups])