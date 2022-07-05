<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
var EditJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
            $('.group_multiselect').bootstrapDualListbox();
            $('.permission_multiselect').bootstrapDualListbox();
            $('.menu_multiselect').bootstrapDualListbox();
            var table = $('#permission_select').DataTable({
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
                    url: _base_extraweb_uri + '/prefferences/user/get_list_permission',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "path"},
                    {"data": "controller"},
                    {"data": "method"},
                    {"data": "module_name"},
                    {"data": "action"}
                ]
            });
            var table = $('#tbl_basic_permission').DataTable({
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
                    url: _base_extraweb_uri + '/prefferences/user/get_list_permission?type=basic',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "path"},
                    {"data": "controller"},
                    {"data": "method"},
                    {"data": "module_name"},
                    {"data": "action"}
                ]
            });
            var table = $('#menu_select').DataTable({
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
                    url: _base_extraweb_uri + '/prefferences/user/get_list_menu',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "path"},
                    {"data": "level"},
                    {"data": "rank"},
                    {"data": "module_name"},
                    {"data": "action"}
                ]
            });
            var table = $('#menu_select_basic').DataTable({
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
                    url: _base_extraweb_uri + '/prefferences/user/get_list_menu?type=basic',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "path"},
                    {"data": "level"},
                    {"data": "rank"},
                    {"data": "module_name"},
                    {"data": "action"}
                ]
            });
            $('input[type="checkbox"][name="permission_option"]').on('click', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                if (checked == true) {
                    var value = $(this).val();
                    switch (value) {
                        case "all":
                            $('#select_basic_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="permission_option"][value="basic"]').prop("checked", false);
                            $('#select_manual_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="permission_option"][value="manual"]').prop("checked", false);
                            break;
                        case "basic":
                            $('#select_basic_permission').css({'display': 'block', 'opacity': '1'});
                            $('#select_all_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="permission_option"][value="all"]').prop("checked", false);
                            $('#select_manual_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="permission_option"][value="manual"]').prop("checked", false);
                            break;
                        default :
                            $('#select_manual_permission').css({'display': 'block', 'opacity': '1'});
                            $('#select_all_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="permission_option"][value="all"]').prop("checked", false);
                            $('#select_basic_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="permission_option"][value="basic"]').prop("checked", false);
                            break;
                    }
                } else {
                    $('#select_all_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                    $('#select_basic_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                    $('#select_manual_permission').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                }
                setTimeout(function () {
                    loadingImg('img-loading', 'stop');
                }, 1200);
            });
            $('input[type="checkbox"][name="menu_option"]').on('click', function () {
                loadingImg('img-loading', 'start');
                var checked = this.checked;
                if (checked == true) {
                    var value = $(this).val();
                    switch (value) {
                        case "all":
                            $('#select_basic_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="basic"]').prop("checked", false);
                            $('#select_manual_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="manual"]').prop("checked", false);
                            break;
                        case "basic":
                            $('#select_basic_menu').css({'display': 'block', 'opacity': '1'});
                            $('#select_all_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="all"]').prop("checked", false);
                            $('#select_manual_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="manual"]').prop("checked", false);
                            break;
                        default :
                            $('#select_manual_menu').css({'display': 'block', 'opacity': '1'});
                            $('#select_all_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="all"]').prop("checked", false);
                            $('#select_basic_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="basic"]').prop("checked", false);
                            break;
                    }
                } else {
                    $('#select_all_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                    $('#select_basic_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                    $('#select_manual_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                }
                setTimeout(function () {
                    loadingImg('img-loading', 'stop');
                }, 1200);
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
            $('#submit_form').on('click', function (e) {
                e.preventDefault();
                var uri = _base_extraweb_uri + '/prefferences/user/insert';
                var type = 'POST';
                var formdata = {
                    'action': 'default',
                    'detail': {
                        'user_name': $('input[name="user_name"]').val(),
                        'first_name': $('input[name="first_name"]').val(),
                        'last_name': $('input[name="last_name"]').val(),
                        'email': $('input[name="email"]').val(),
                        'description': $('textarea[name="description"]').val()
                    },
                    'profile': {
                        'address': $('textarea[name="address"]').val(),
                        'lat': $('input[name="lat"]').val(),
                        'lng': $('input[name="lng"]').val(),
                        'zoom': $('input[name="zoom"]').val(),
                        'facebook': $('input[name="facebook"]').val(),
                        'twitter': $('input[name="twitter"]').val(),
                        'instagram': $('input[name="instagram"]').val(),
                        'linkedin': $('input[name="linkedin"]').val(),
                        'last_education': $('input[name="last_education"]').val(),
                        'last_education_institution': $('input[name="last_education_institution"]').val(),
                        'skill': $('textarea[name="skill"]').val(),
                        'notes': $('textarea[name="notes"]').val()
                    },
                    'group': $('select[name="group_id"]').val(),
                    'permission': $('input[name="is_permission_allowed"]:checked').val(),
                    'menu': $('input[name="is_menu_allowed"]:checked').val(),
                    'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                };
                console.log(formdata);
                return false;
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code == 200) {
                    fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                } else {
                    fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
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
