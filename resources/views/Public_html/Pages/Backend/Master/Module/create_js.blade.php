<script>
    var CreateJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('CreateJS successfully load', 'success', {timeOut: 2000});
                $('#submit_form').on('click', function (e) {
                    e.preventDefault();
                    var uri = _base_extraweb_uri + '/master/module/insert';
                    var type = 'POST';
                    var formdata = {
                        'action': 'default',
                        'name': $('input[name="name"]').val(),
                        'alias': $('input[name="alias"]').val(),
                        'rank': $('input[name="rank"]').val(),
                        'description': $('textarea[name="description"]').val(),
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                    };
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                    if (response.responseJSON.status.code == 200) {
                        $('#form_add')[0].reset();
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
