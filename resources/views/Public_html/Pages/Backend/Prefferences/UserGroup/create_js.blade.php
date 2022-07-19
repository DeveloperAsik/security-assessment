<script>
    var CreateJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('CreateJS successfully load', 'success', {timeOut: 2000});

                $('#submit_form_add').on('click', function (e) {
                    e.preventDefault();
                    var uri = _base_extraweb_uri + '/prefferences/user/groups/insert';
                    var type = 'POST';
                    var formdata = {
                        user: $('select[name="user"]').val(),
                        group: $('select[name="group"]').val(),
                        is_active: ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                    };
                    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                    if (response.responseJSON.status.code === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            if (response.responseJSON.options.valid == true) {
                                $('#eMsg').html('<span style="color:green;">' + response.responseJSON.status.message + '</span>');
                            } else {
                                $('#eMsg').html('<span style="color:red;">' + response.responseJSON.status.message + '</span>');
                            }
                            fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            $('#eMsg').html('<span style="color:red;">' + response.responseJSON.status.message + '</span>');
                            fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                    return false;
                });
            }
        };
    }();
    jQuery(document).ready(function () {
        CreateJS.init();
    });
</script>
