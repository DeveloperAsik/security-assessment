<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/dropzone/dropzone.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
var ProfileUpdateJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('ProfileUpdateJS successfully load', 'success', {timeOut: 2000});
            $('#skill').summernote();
            $('#notes').summernote();
            var table = $('#group_permissions').DataTable({
                "sPaginationType": "bootstrap",
                "paging": true,
                "pagingType": "full_numbers",
                "pageLength": 10,
                "ordering": false,
                "serverSide": true,
                "cache": false,
                "processing": true,
                "lengthChange": true,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "ajax": {
                    url: _base_extraweb_uri + '/ajax/post/get-group-permission-list',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columnDefs": [
                    {"width": "20", "targets": 0}
                ],
                "columns": [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "path"},
                    {"data": "controller"},
                    {"data": "method"},
                    {"data": "module"},
                    {"data": "group"},
                    {"data": "is_public"},
                    {"data": "is_allowed"},
                    {"data": "is_active"}
                ]
            });

            $('#group_permissions').on('click', 'input[type="checkbox"][name="is_public"]', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                var value = parseInt($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/ajax/post/group_permission_update';
                var type = 'POST';
                var formdata = {
                    id: value,
                    is_public: (checked == true) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
            });
            $('#group_permissions').on('click', 'input[type="checkbox"][name="is_allowed"]', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                var value = parseInt($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/ajax/post/group_permission_update';
                var type = 'POST';
                var formdata = {
                    id: value,
                    is_allowed: (checked == true) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
            });
            $('#group_permissions').on('click', 'input[type="checkbox"][name="is_active"]', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                var value = parseInt($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/ajax/post/group_permission_update';
                var type = 'POST';
                var formdata = {
                    id: value,
                    is_active: (checked == true) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
            });
            $('input[type="checkbox"][name="change_password"]').on('click', function (e) {
                loadingImg('img-loading', 'start');
                if ($(this).prop("checked") == true) {
                    setTimeout(function () {
                        loadingImg('img-loading', 'stop');
                        $('.change_password').css({'display': 'block'});
                    }, 700);
                } else if ($(this).prop("checked") == false) {
                    setTimeout(function () {
                        loadingImg('img-loading', 'stop');
                        $('.change_password').css({'display': 'none'});
                    }, 700);
                }
            });
            $('input[type="checkbox"][name="add_permission"]').on('click', function (e) {
                loadingImg('img-loading', 'start');
                if ($(this).prop("checked") == true) {
                    setTimeout(function () {
                        loadingImg('img-loading', 'stop');
                        $('#form_new_permission').css({'display': 'block'});
                    }, 700);
                } else if ($(this).prop("checked") == false) {
                    setTimeout(function () {
                        loadingImg('img-loading', 'stop');
                        $('#form_new_permission').css({'display': 'none'});
                    }, 700);
                }
            });
            $('form#form-detail').on('submit', function (e) {
                e.preventDefault();
                loadingImg('img-loading', 'start');
                var uri = _base_extraweb_uri + '/ajax/post/form-detail';
                var type = 'POST';
                var change_password = $('input[type="checkbox"][name="change_password"]').prop("checked");
                var old_pass = '';
                var new_pass1 = '';
                var new_pass2 = '';
                if (change_password == true) {
                    old_pass = Base64.encode($('input[name="old_password"]').val());
                    new_pass1 = Base64.encode($('input[name="new_password"]').val());
                    new_pass2 = Base64.encode($('input[name="new_password2"]').val());
                }
                var formdata = {
                    user_name: $('input[name="user_name"]').val(),
                    first_name: $('input[name="first_name"]').val(),
                    last_name: $('input[name="last_name"]').val(),
                    email: $('input[name="email"]').val(),
                    is_change_pass: change_password,
                    old_pass: old_pass,
                    new_pass1: new_pass1,
                    new_pass2: new_pass2
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
                return false;
            });

            $('form#form-prefferences').on('submit', function (e) {
                e.preventDefault();
                loadingImg('img-loading', 'start');
                var uri = _base_extraweb_uri + '/ajax/post/form-prefferences';
                var type = 'POST';
                var formdata = {
                    facebook: $('input[name="facebook"]').val(),
                    twitter: $('input[name="twitter"]').val(),
                    instagram: $('input[name="instagram"]').val(),
                    linkedin: $('input[name="linkedin"]').val(),
                    last_education: $('input[name="last_education"]').val(),
                    last_education_institution: $('input[name="last_education_institution"]').val(),
                    skill: $('textarea[name="skill"]').val(),
                    notes: $('textarea[name="notes"]').val()
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
                return false;
            });
            $('#close_form_add_permission').on('click', function (e) {
                e.preventDefault();
                loadingImg('img-loading', 'start');
                setTimeout(function () {
                    loadingImg('img-loading', 'stop');
                    $('#form_new_permission').css({'display': 'none'});
                }, 700);
            });
            $('#submit_form_add_permission').on('click', function (e) {
                e.preventDefault();
                loadingImg('img-loading', 'start');
                var uri = _base_extraweb_uri + '/ajax/post/form-add-group-permission';
                var type = 'POST';
                var formdata = {
                    url: $('input[name="url"]').val(),
                    module: $('select[name="module"]').val(),
                    route_name: $('input[name="route"]').val(),
                    class: $('input[name="class"]').val(),
                    method: $('input[name="method"]').val(),
                    description: $('input[name="description"]').val(),
                    is_allowed: $('input[name="is_allowed"]').prop("checked"),
                    is_public: $('input[name="is_public"]').prop("checked")
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code === 200) {
                    if (response.status === 200) {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'success', {timeOut: 2000});
                        }, 1500);
                    } else {
                        setTimeout(function () {
                            loadingImg('img-loading', 'stop');
                            fnAlertStr(response.responseJSON.message, 'error', {timeOut: 2000});
                        }, 1500);
                    }
                }
                return false;
            });
        }
    };
}();
jQuery(document).ready(function () {
    ProfileUpdateJS.init();
});
</script>