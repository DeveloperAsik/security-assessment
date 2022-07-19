<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/dropzone/dropzone.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
var table_permission_select = function () {
    $('#permission_select').DataTable({
        "sPaginationType": "bootstrap",
        "paging": true,
        "pagingType": "full_numbers",
        "pageLength": 10,
        "ordering": false,
        "serverSide": true,
        "cache": false,
        "processing": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "1000"]],
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        "ajax": {
            url: _base_extraweb_uri + '/master/user/get_list?a=2',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST'
        },
        "columns": [
            {"data": "id"},
            {"data": "name"},
            {"data": "path"},
            {"data": "controller"},
            {"data": "method"},
            {"data": "action"}
        ]
    });
};
var table_menu_select_basic = function () {
    $('#menu_select_basic').DataTable({
        "sPaginationType": "bootstrap",
        "paging": true,
        "pagingType": "full_numbers",
        "pageLength": 10,
        "ordering": false,
        "serverSide": true,
        "cache": false,
        "processing": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "1000"]],
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        "ajax": {
            url: _base_extraweb_uri + '/master/user/get_list?a=3&type=basic',
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
            {"data": "action"}
        ]
    });
};
var table_menu_select = function () {
    $('#menu_select').DataTable({
        "sPaginationType": "bootstrap",
        "paging": true,
        "pagingType": "full_numbers",
        "pageLength": 10,
        "ordering": false,
        "serverSide": true,
        "cache": false,
        "processing": true,
        "lengthChange": true,
        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "1000"]],
        "language": {
            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
        },
        "ajax": {
            url: _base_extraweb_uri + '/master/user/get_list?a=3',
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
            {"data": "action"}
        ]
    });
};
var CreateJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('CreateJS successfully load', 'success', {timeOut: 2000});
            $('#skill').summernote();
            $('#notes').summernote();
            $('.permissions_multiselect').bootstrapDualListbox();
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
                    url: _base_extraweb_uri + '/master/user/get_list?a=1',
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
                    {"data": "name"},
                    {"data": "path"},
                    {"data": "controller"},
                    {"data": "method"},
                    {"data": "is_public"},
                    {"data": "is_allowed"},
                    {"data": "is_active"}
                ]
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
                            table_menu_select_basic();
                            $('#select_basic_menu').css({'display': 'block', 'opacity': '1'});
                            $('#select_all_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="all"]').prop("checked", false);
                            $('#select_manual_menu').css({'display': 'none', 'transition': 'opacity 1s ease-out', 'opacity': '0'});
                            $('input[type="checkbox"][name="menu_option"][value="manual"]').prop("checked", false);
                            break;
                        default :
                            table_menu_select();
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
            $('#submit_form').on('click', function (e) {
                e.preventDefault();
                var uri = _base_extraweb_uri + '/master/user/insert';
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
                    'group': $('select[name="group"]').val(),
                    'is_allowed': ($('input[type="checkbox"][name="is_allowed"]:checked').val()) ? 1 : 0,
                    'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                };
                //console.log(formdata);return false;
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code == 200) {
                    fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                } else {
                    fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
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
        }
    };
}();
jQuery(document).ready(function () {
    CreateJS.init();
});
</script>