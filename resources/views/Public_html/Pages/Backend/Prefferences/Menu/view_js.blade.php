<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<script type="text/javascript" src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
var MenuViewJS = function () {

    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('MenuViewJS successfully load', 'success', {timeOut: 2000});
            var table = $('#menu').DataTable({
                "sPaginationType": "bootstrap",
                "paging": true,
                "pagingType": "full_numbers",
                "pageLength": 10,
                "ordering": false,
                "serverSide": true,
                "cache": false,
                "processing": true,
                "lengthChange": false,
                "language": {
                    processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                },
                "ajax": {
                    url: _base_extraweb_uri + '/menu/get_list',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST'
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    //{"data": "icon"},
                    //{"data": "badge"},
                    //{"data": "badge_value"},
                    //{"data": "path"},
                    {"data": "level"},
                    {"data": "rank"},
                    {"data": "is_badge"},
                    {"data": "is_open"},
                    {"data": "is_active"},
                    {"data": "is_allowed"},
                    {"data": "group_name"},
                    {"data": "module_name"},
                    {"data": "action"}
                ]
            });

            $('#menu').on('click', 'input[type="checkbox"][name="check"]', function () {
                var checked = $(this)[0].checked;
                var ch = 1;
                if(checked == false){
                    ch = 0;
                }
                var formdata = {
                    'id': $(this).data('id'),
                    'field' : $(this).val(),
                    'value' : ch
                };
                var uri = _base_extraweb_uri + '/ajax/post/update-menu-status';
                var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
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
    MenuViewJS.init();
});
</script>