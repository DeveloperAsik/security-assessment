<script>
    var fnSubmitLogin = function (e) {
        loadingImg('img-loading', 'start');
        var uri = _base_extraweb_uri + '/validate-user';
        var type = 'POST';
        var formdata = {
            deviceid: _uuid,
            userid: Base64.encode($('input[name="userid"]').val()),
            password: Base64.encode($('input[name="password"]').val())
        };
        var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
        //console.log(response);
        //return false;
        if (response.responseJSON.status.code == 200) {
            var res = fnAjaxSend({token: response.responseJSON.data.token}, _base_extraweb_uri + '/save-token', 'POST', {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
            //console.log(res);
            //return false;
            if (res.responseJSON.status.code == 200) {
                setTimeout(function () {
                    loadingImg('img-loading', 'stop');
                    $('input[name="userid"]').css({'color': '#000'});
                    $('input[name="userid"]').addClass('is-valid');
                    $('input[name="userid"]').removeClass('is-invalid');
                    $('input[name="userid"]').css({'color': '#ced4da', 'border': '1px solid #ced4da', 'font-size': '12px'});

                    $('input[name="password"]').css({'color': '#000'});
                    $('input[name="password"]').addClass('is-valid');
                    $('input[name="password"]').removeClass('is-invalid');
                    $('input[name="password"]').css({'color': '#ced4da', 'border': '1px solid #ced4da', 'font-size': '12px'});

                    var session_destination_path = '{{$_session_destination_path}}';
                    if (session_destination_path && session_destination_path != '//') {
                        window.location = session_destination_path;
                    } else {
                        window.location = _base_extraweb_uri + '/dashboard';
                    }
                }, 2000);
            } else {
                setTimeout(function () {
                    loadingImg('img-loading', 'stop');
                    $('input[name="userid"]').css({'color': 'red'});
                    $('input[name="userid"]').addClass('is-invalid');
                    $('input[name="userid"]').removeClass('is-valid');
                    $('input[name="userid"]').css({'color': 'red', 'border': '2px solid red', 'font-size': '10px'});

                    $('input[name="password"]').css({'color': 'red'});
                    $('input[name="password"]').addClass('is-invalid');
                    $('input[name="password"]').removeClass('is-valid');
                    $('input[name="password"]').css({'color': 'red', 'border': '2px solid red', 'font-size': '10px'});

                    $('.login-box-msg').html('<p style="color:#red;">' + response.responseJSON.status.message + '</p>');
                    //window.location = _base_extraweb_uri + '/logout';
                    $('input[name="userid"]').val("");
                    $('input[name="password"]').val("");
                }, 2500);
            }
        } else {
            setTimeout(function () {
                loadingImg('img-loading', 'stop');
                $('input[name="userid"]').css({'color': 'red'});
                $('input[name="userid"]').addClass('is-invalid');
                $('input[name="userid"]').removeClass('is-valid');
                $('input[name="userid"]').css({'color': 'red', 'border': '2px solid red', 'font-size': '10px'});

                $('input[name="password"]').css({'color': 'red'});
                $('input[name="password"]').addClass('is-invalid');
                $('input[name="password"]').removeClass('is-valid');
                $('input[name="password"]').css({'color': 'red', 'border': '2px solid red', 'font-size': '10px'});

                $('.login-box-msg').html('<p style="color:#red;">' + response.responseJSON.status.message + '</p>');
                //window.location = _base_extraweb_uri + '/logout';
                $('input[name="userid"]').val("");
                $('input[name="password"]').val("");
            }, 2500);
        }
        return false;
    };

    var validateLogin = function (e) {
        var errStatus = true;
        if ($('input[name="userid"]').val() == '' || $('input[name="userid"]').val() == null) {
            errStatus = false;
            $('input[name="userid"]').css({'color': 'red', 'border': '2px solid red', 'font-size': '10px'});
            $('input[name="userid"]').addClass('is-invalid');
            $('input[name="userid"]').prop('placeholder', 'This field is required, cannot submit with empt value.');
        } else {
            $('input[name="userid"]').css({'color': '#ced4da', 'border': '1px solid #ced4da', 'font-size': '12px'});
            $('input[name="userid"]').removeClass('is-invalid');
            $('input[name="userid"]').prop('placeholder', '');
        }
        if ($('input[name="password"]').val() == '' || $('input[name="password"]').val() == null) {
            errStatus = false;
            $('input[name="password"]').css({'color': 'red', 'border': '2px solid red', 'font-size': '10px'});
            $('input[name="password"]').addClass('is-invalid');
            $('input[name="password"]').prop('placeholder', 'This field is required, cannot submit with empt value.');
        } else {
            $('input[name="password"]').css({'color': '#ced4da', 'border': '1px solid #ced4da', 'font-size': '12px'});
            $('input[name="password"]').removeClass('is-invalid');
            $('input[name="password"]').prop('placeholder', '');
        }
        return errStatus;
    };

    var LoginJS = function () {
        return {
            //main function to initiate the module
            init: function () {
                fnAlertStr('LoginJS successfully load', 'success', {type: 'toastr', timeOut: 2000});
                $('input[name="userid"]').on('click', function () {
                    $('input[name="userid"]').css({'color': '#000', 'border': '1px solid #ced4da', 'font-size': '12px'});
                    $('input[name="userid"]').addClass('is-valid');
                });
                $('input[name="password"]').on('click', function () {
                    $('input[name="password"]').css({'color': '#000', 'border': '1px solid #ced4da', 'font-size': '12px'});
                    $('input[name="password"]').addClass('is-valid');
                });
                $('#remember').on('click', function () {
                    var checkedValue = $('#remember:checked').val();
                    if (checkedValue === 'on') {
                        //create cookies save username and password (hash)
                        var uri = _base_api_url + '/save-login-credentials';
                        var type = 'POST';
                        var formdata = {
                            deviceid: _uuid,
                            username: Base64.encode($('input[name="username"]').val()),
                            password: Base64.encode($('input[name="password"]').val())
                        };
                        var response = fnAjaxSend(formdata, uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                        if (response.responseJSON.status === 200) {
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        } else {
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }
                    } else {
                        //remove cookies save username and password (hash)
                    }
                });
                $('form[name="login_auth"]').on('submit', function (e) {
                    e.preventDefault();
                    var validate = validateLogin();
                    if (validate) {
                        fnSubmitLogin(e);
                    }
                });
            }

        };
    }();
    jQuery(document).ready(function () {
        LoginJS.init();
    });
</script>
