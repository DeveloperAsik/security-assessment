<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('.method_multiselect').bootstrapDualListbox();
                $('#submit_form_add_permission').on('click', function (e) {
                    e.preventDefault();
                    var id = Base64.encode($('input[name="id"]').val());
                    var uri = _base_extraweb_uri + '/master/permission/update/' + id;
                    var type = 'POST';
                    var formdata = {
                        'action': 'default',
                        'name': $('input[name="name"]').val(),
                        'path': $('input[name="path"]').val(),
                        'controller': $('input[name="controller"]').val(),
                        'method': $('input[name="method"]').val(),
                        'description': $('textarea[name="description"]').val(),
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0// $('input[name="is_active"]').checked//
                    };
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                    if (response.responseJSON.status.code == 200) {
                        $('#form_update')[0].reset();
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
