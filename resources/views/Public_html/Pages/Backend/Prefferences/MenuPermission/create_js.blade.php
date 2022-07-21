<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
var fnInitMenuList = function () {
    var uri = _base_extraweb_uri + '/prefferences/menu/permissions/get_list?a=option';
    var type = 'POST';
    var formdata = {};
    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
    return response;
}
var CreateJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('CreateJS successfully load', 'success', {timeOut: 2000});
            //
            $('select[name="group_id"]').on('change', function () {
                var strOption = fnInitMenuList();
                var strHtml = '<select class="form-control menu_id_multiselect" name="menu_id" multiple="multiple">';
                strHtml = strHtml + strOption.responseJSON.data;
                strHtml = strHtml + '</select>';
                $('#selPermission').html(strHtml);
                $('.menu_id_multiselect').bootstrapDualListbox();
            });
            $('#submit_form_add').on('click', function (e) {
                e.preventDefault();
                var uri = _base_extraweb_uri + '/prefferences/menu/permissions/insert';
                var type = 'POST';
                var formdata = {
                    'group_id': $('select[name="group_id"]').val(),
                    'module_id': $('select[name="module_id"]').val(),
                    'menu_id': $('select[name="menu_id"]').val(),
                    'is_allowed': ($('input[type="checkbox"][name="is_allowed"]:checked').val()) ? 1 : 0,
                    'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                };
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
    CreateJS.init();
});
</script>
