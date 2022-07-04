<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('.group_multiselect').bootstrapDualListbox();
                $('.permission_multiselect').bootstrapDualListbox();
                $('#group_permissions').on('click', 'input[type="checkbox"][name="is_public"]', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                var value = parseInt($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/ajax/post/group_permission_update';
                var type = 'POST';
                var formdata = {
                    id: value,
                    is_public: (checked == true) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
            });
            $('#group_permissions').on('click', 'input[type="checkbox"][name="is_allowed"]', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                var value = parseInt($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/ajax/post/group_permission_update';
                var type = 'POST';
                var formdata = {
                    id: value,
                    is_allowed: (checked == true) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
            });
            $('#group_permissions').on('click', 'input[type="checkbox"][name="is_active"]', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                var value = parseInt($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/ajax/post/group_permission_update';
                var type = 'POST';
                var formdata = {
                    id: value,
                    is_active: (checked == true) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
            });
                $('#submit_form_add').on('click', function (e) {
                    e.preventDefault();
                    var uri = _base_extraweb_uri + '/prefferences/group_permission/insert';
                    var type = 'POST';
                    var formdata = {
                        'action': 'default',
                        'group_id': $('select[name="group_id"]').val(),
                        'permission_id': $('select[name="permission_id"]').val(),
                        'is_public': ($('input[type="checkbox"][name="is_public"]:checked').val()) ? 1 : 0,
                        'is_allowed': ($('input[type="checkbox"][name="is_allowed"]:checked').val()) ? 1 : 0,
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                    };
                    //console.log(formdata);return false;
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                    if (response.responseJSON.status.code == 200) {
                        fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                    } else {
                        fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
                    }
                    return false;
                });
            }
        };
    }();
    jQuery(document).ready(function () {
        EditJS.init();
    });
</script>
