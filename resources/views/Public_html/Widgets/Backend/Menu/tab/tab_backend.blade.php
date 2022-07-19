<div class="card-body">
    <ul class="nav nav-tabs" id="tab_group" role="tablist">
        @if(isset($groups['data']) && !empty($groups['data']))
        @foreach($groups['data'] AS $keyword => $value)
        <li class="nav-item">
            <a class="nav-link{{($value->rank == 1) ? ' active' : ''}}" id="tab_group-{{$value->rank}}" data-group_id="{{$value->id}}" data-toggle="pill" href="#content_group-{{$value->rank}}" role="tab" aria-controls="{{$value->rank}}" aria-selected="true">{{$value->name}}</a>
        </li>
        @endforeach
        @endif
    </ul>
    <div class="tab-content" id="tab_group-content" style="color:#000">
        @if(isset($groups['data']) && !empty($groups['data']))
        @foreach($groups['data'] AS $key => $val)
        <div class="tab-pane fade{{($val->rank == 1) ? ' show active' : ''}}" id="content_group-{{$val->rank}}" role="tabpanel" aria-labelledby="{{$val->rank}}">
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