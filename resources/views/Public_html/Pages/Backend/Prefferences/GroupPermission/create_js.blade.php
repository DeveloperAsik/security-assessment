<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('#submit_form_add').on('click', function (e) {
                    e.preventDefault();
                    var uri = _base_extraweb_uri + '/prefferences/group_permission/insert';
                    var type = 'POST';
                    var formdata = {
                        'action': 'default',
                        'group_id': $('select[name="group_id"]').val(),
                        'user_id': $('select[name="user_id"]').val(),
                        'is_public': ($('input[type="checkbox"][name="is_public"]:checked').val()) ? 1 : 0,
                        'is_allowed': ($('input[type="checkbox"][name="is_allowed"]:checked').val()) ? 1 : 0,
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                    };
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
