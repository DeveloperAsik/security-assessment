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
            <div id="tree_{{$id}}" class="tree-demo"></div>
        </div>
    </div>
</div>