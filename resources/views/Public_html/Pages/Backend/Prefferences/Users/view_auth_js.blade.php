<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script>
var ViewJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('ViewJS successfully load', 'success', {timeOut: 2000});
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
                    url: _base_extraweb_uri + '/prefferences/user/auth/get_list_auth',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "permission_name"},
                    {"data": "permission_path"},
                    {"data": "permission_controller"},
                    {"data": "permission_method"},
                    {"data": "group_name"},
                    {"data": "module_name"},
                    {"data": "is_allowed"},
                    {"data": "is_public"},
                    {"data": "is_active"},
                    {"data": "action"}
                ]
            });
            $('#group_permissions').on('click', 'input[type="checkbox"][name="is_active"]', function () {
                var checked = this.checked;
                var id = Base64.encode($(this).attr('data-id'));
                var uri = _base_extraweb_uri + '/prefferences/group_permission/update/' + id;
                var type = 'POST';
                var formdata = {
                    action: 'is_active',
                    is_active: (checked == true) ? 1 : 0
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
    ViewJS.init();
});
</script>
