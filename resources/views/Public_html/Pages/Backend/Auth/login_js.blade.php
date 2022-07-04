<script src="{{config('app.base_assets_uri')}}/libs/jquery/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script>
var fnSubmitLogin = function () {
    loadingImg('img-loading', 'start');
    var uri = _base_extraweb_uri + '/validate-user';
    var type = 'POST';
    var formdata = {
        deviceid: _uuid,
        userid: $('input[name="userid"]').val(),
        password: Base64.encode($('input[name="password"]').val())
    };
    var response = fnAjaxSend(formdata, uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
    //console.log(response);
    //return false;
    if (response.responseJSON.status.code == 200) {
        var res = fnAjaxSend({token: response.responseJSON.data.token}, _base_extraweb_uri + '/save-token', 'POST', {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
        //console.log(res);
        //return false;
        if (res.responseJSON.status.code == 200) {
            setTimeout(function () {
                loadingImg('img-loading', 'stop');
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
                $('.login-box-msg').html('<span style="background-color:red;color:#fff;">' + response.responseJSON.status.message + '</span>');
                //window.location = _base_extraweb_uri + '/logout';
                $('input[name="userid"]').val("");
                $('input[name="password"]').val("");
            }, 2500);
        }
    } else {
        setTimeout(function () {
            loadingImg('img-loading', 'stop');
            $('.login-box-msg').html('<span style="background-color:red;color:#fff;">' + response.responseJSON.status.message + '</span>');
            //window.location = _base_extraweb_uri + '/logout';
            $('input[name="userid"]').val("");
            $('input[name="password"]').val("");
        }, 2500);
    }
    return false;
};

var handleLogin = function () {
    $('.login-form').validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        rules: {
            username: {
                required: true
            },
            password: {
                required: true
            },
            remember: {
                required: false
            }
        },
        messages: {
            username: {
                required: "Username is required."
            },
            password: {
                required: "Password is required."
            }
        },
        invalidHandler: function (event, validator) { //display error alert on form submit   
            $('.alert-danger', $('.login-form')).show();
        },
        highlight: function (element) { // hightlight error inputs
            $(element).closest('.form-group').addClass('has-error'); // set error class to the control group
        },
        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element.closest('.input-icon'));
        },
        submitHandler: function (form) {
            //loadingBg('start');
            //setTimeout(function () {
            fnSubmitLogin();
            //}, 2000);
        }
    });
};

var LoginJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('LoginJS successfully load', 'success', {type: 'toastr', timeOut: 2000});
            handleLogin();
            $('#remember').on('click', function () {
                var checkedValue = $('#remember:checked').val();
                console.log(checkedValue);
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
        }

    };
}();
jQuery(document).ready(function () {
    LoginJS.init();
});
</script>
