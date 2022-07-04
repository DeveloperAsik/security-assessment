<link href="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/dropzone/css/dropzone.css" rel="stylesheet"/>
<div class="modal fade" id="modal_change_picture" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Upload profile picture</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <p>
                            <span class="label label-danger">
                                NOTE: </span>
                            &nbsp; This plugins works only on Latest Chrome, Firefox, Safari, Opera & Internet Explorer 10.
                        </p>
                        <form action="{{config('app.base_extraweb_uri') . '/profile/upload_photo'}}" class="dropzone" id="upload-photo" enctype="multipart/form-data">{{ csrf_field() }}</form>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>