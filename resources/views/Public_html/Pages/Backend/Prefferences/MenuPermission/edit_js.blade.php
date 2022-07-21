<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script>
var fnInitMenuList = function (id) {
    var uri = _base_extraweb_uri + '/prefferences/menu/permissions/get_list?a=option';
    var type = 'POST';
    var formdata = {
        'menu_id': id
    };
    var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
    return response;
}
var EditJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
            //
            $('#changeInToSel').on('click', function () {
                var id = $('input[name="menu_id"]').val();
                var strOption = fnInitMenuList(id);
                var strHtml = '<select class="form-control menu_multiselect" name="new_menu_id" multiple="new_menu_id">';
                strHtml = strHtml + strOption.responseJSON.data;
                strHtml = strHtml + '</select>';
                $('#selPermission').html(strHtml);
                $('.menu_multiselect').bootstrapDualListbox();
            });
            $('#submit_form_add').on('click', function (e) {
                e.preventDefault();
                var id = $('input[name="menu_id"]').val();
                var uri = _base_extraweb_uri + '/prefferences/menu/permissions/update/' + Base64.encode(id);
                var type = 'POST';
                var menu_id = $('input[name="menu_id"]').val();
                var new_menu_id = $('select[name="new_menu_id"]').val();
                if (new_menu_id) {
                    menu_id = new_menu_id;
                }
                if (!isNaN(menu_id) == false) {
                    fnAlertStr('Nothing happened and change.', 'info', {timeOut: 2000, withHtml: true});
                    return false;
                }
                var formdata = {
                    'group_id': $('select[name="group_id"]').val(),
                    'module_id': $('select[name="module_id"]').val(),
                    'menu_id': menu_id,
                    'is_allowed': ($('input[type="checkbox"][name="is_allowed"]:checked').val()) ? 1 : 0,
                    'is_active': ($('input[type="checkbox"][name="is_active"]:checked').val()) ? 1 : 0
                };
                var response = fnAjaxSend(JSON.stringify(formdata), uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code == 200) {
                    fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000, withHtml: true});
                } else {
                    fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000, withHtml: true});
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
