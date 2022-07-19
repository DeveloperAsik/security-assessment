<div class="modal fade" id="modal_edit_node" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="z-index:1050">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Menu</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal">
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" id="name" placeholder="name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="icon" class="col-sm-2 control-label">icon</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="icon" class="form-control" id="icon" placeholder="icon">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="path" class="col-sm-2 control-label">path</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="path" class="form-control" id="path" placeholder="path">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="path" class="col-sm-2 control-label">content path</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="content_path" class="form-control" id="content_path" placeholder="content path">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="badge" class="col-sm-2 control-label">Badge</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="badge" class="form-control" id="badge" placeholder="badge">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="badge_value" class="col-sm-2 control-label">Badge Value</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="badge_value" class="form-control" id="badge_value" placeholder="badge_value">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="level" class="col-sm-2 control-label">level</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="level" class="form-control" id="level" placeholder="level">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 control-label">rank</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="rank" class="form-control" id="rank" placeholder="rank">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_basic" value="1"> Is Basic
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_badge" value="1"> Is Badge
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_open" value="1"> Is Open
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_active" value="1"> Is Active 
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="text" name="menu_id" id="menu_id" value="0" style="display:none" />
                <input type="text" name="module_id" id="menu_id" value="0" style="display:none" />
                <input type="text" name="parent_id" id="parent_id" value="0" style="display:none" />
                <button type="button" class="btn btn-default" id="close_modal_edit_node" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit_modal_edit_node">Save changes</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>