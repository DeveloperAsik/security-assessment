<script>
    var EditJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
                $('input[name="check"][value="is_active"').on('click', function (e) {
                    loadingImg('img-loading', 'start');
                    var checked = this.checked;
                    var uri = _base_extraweb_uri + '/project/teams/update/' + $(this).attr('data-id');
                    var type = 'POST';
                    var formdata = {
                        is_active: (checked == true) ? 1 : 0,
                        action: 'is_active'
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
                });
                $('#submit_form_edit').on('click', function (e) {
                    e.preventDefault();
                    loadingImg('img-loading', 'start');
                    var uri = _base_extraweb_uri + '/project/teams/update/' + $('input[name="id"]').val();
                    var type = 'POST';
                    var formdata = {
                        code: $('input[name="code"]').val(),
                        name: $('input[name="name"]').val(),
                        email: $('input[name="email"]').val(),
                        phone_number: $('input[name="phone_number"]').val(),
                        description: $('textarea[name="description"]').val(),
                        is_active: $('input[type="checkbox"][name="check"][value="is_active"]')[0].checked,
                        action: 'update'
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
