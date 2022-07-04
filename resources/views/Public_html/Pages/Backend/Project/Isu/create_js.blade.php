<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('#submit_form_add').on('click', function (e) {
                    e.preventDefault();
                    loadingImg('img-loading', 'start');
                    var uri = _base_extraweb_uri + '/project/isu-teams/insert';
                    var type = 'POST';
                    var formdata = {
                        photo: $('input[name="photo"]').val(),
                        code: $('input[name="code"]').val(),
                        first_name: $('input[name="first_name"]').val(),
                        last_name: $('input[name="last_name"]').val(),
                        email_address: $('input[name="email_address"]').val(),
                        mobile_phone_number: $('input[name="mobile_phone_number"]').val(),
                        is_active: $('input[type="checkbox"][name="check"][value="is_active"]')[0].checked
                    };
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                    if (response.responseJSON.status.code === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
                        }, 1500);
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
