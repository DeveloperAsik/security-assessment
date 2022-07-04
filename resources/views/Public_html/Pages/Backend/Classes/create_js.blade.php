<script>
    var CreateJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('CreateJS successfully load', 'success', {timeOut: 2000});
                $('#submit_form_add').on('click', function () {
                    var id = $('input[name="id"]').val();
                    var uri = _base_extraweb_uri + '/permission/update/' + id;
                    var type = 'POST';
                    var formdata = {
                        'namespace': $('input[name="namespace"]').val(),
                        'class': $('input[name="class"]').val(),
                        'method': $('input[name="method"]').val(),
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0// $('input[name="is_active"]').checked//
                    };
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
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
        CreateJS.init();
    });
</script>
