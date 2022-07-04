<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('#submit_form_add_permission').on('click', function () {
                    var id = Base64.encode($('input[name="id"]').val());
                    var uri = _base_extraweb_uri + '/prefferences/permission/update/' + id;
                    var type = 'POST';
                    var formdata = {
                        'action': 'default',
                        'title': $('input[name="title"]').val(),
                        'path': $('input[name="path"]').val(),
                        'controller': $('input[name="controller"]').val(),
                        'method': $('input[name="method"]').val(),
                        'module_id': $('select[name="module_id"]').val(),
                        'description': $('textarea[name="description"]').val(),
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0// $('input[name="is_active"]').checked//
                    };
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                    //console.log(response);
                    //return false;
                    if (response.responseJSON.status.code == 200) {
                        fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                    } else {
                        fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
                    }
                });
            }
        };
    }();
    jQuery(document).ready(function () {
        EditJS.init();
    });
</script>
