<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('#submit_form').on('click', function () {
                    var id = Base64.encode($('input[name="id"]').val());
                    var uri = _base_extraweb_uri + '/master/module/update/' + id;
                    var type = 'POST';
                    var formdata = {
                        'action': 'default',
                        'name': $('input[name="name"]').val(),
                        'rank': $('input[name="rank"]').val(),
                        'alias': $('input[name="alias"]').val(),
                        'description': $('textarea[name="description"]').val(),
                        'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
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
        EditJS.init();
    });
</script>
