<!-- Select2 -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{config('app.base_assets_uri')}}/templates/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>

<script>
var fnGetMenu = function (id, level) {
    loadingImg('img-loading', 'start');
    var uri = _base_extraweb_uri + '/master/menu/get_list?a=3';
    var type = 'POST';
    var formdata = {
        id: id,
        level: level
    };
    var response = fnAjaxSend(formdata, uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
    //console.log(response.responseJSON);return false;
    if (response.status === 200) {
        setTimeout(function () {
            loadingImg('img-loading', 'stop');
            $(response.responseJSON.data).insertBefore('#result_menu');
        }, 1100);
    } else {
        setTimeout(function () {
            loadingImg('img-loading', 'stop');
            $('#result_menu').html('');
        }, 1100);
    }
};
var fnGetMenuChild = function (parent_id, level, module_id) {
    loadingImg('img-loading', 'start');
    var uri = _base_extraweb_uri + '/master/menu/get_list?a=4';
    var type = 'POST';
    var formdata = {
        parent_id: parent_id,
        module_id: module_id,
        level: level
    };
    var response = fnAjaxSend(formdata, uri, type, {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
    if (response.status === 200) {
        setTimeout(function () {
            loadingImg('img-loading', 'stop');
            $('#levelChildID').html(response.responseJSON.data);
        }, 1100);
    } else {
        setTimeout(function () {
            loadingImg('img-loading', 'stop');
            $('#levelChildID').html('');
        }, 1100);
    }
};
var fnSelectMenu = function (e, level, module_id) {
    var parent_id = e.value;
    fnGetMenuChild(parent_id, level, module_id);
};

var fnSelectMenuAfter = function (data) {
    var id = data.value;
    var level = data.attributes.getNamedItem("data-level").value;
    console.log(id);
    console.log(level);
    //return false;
    //var field = '#menu' +  parseInt(level) + 1;
    $('#result_menu').css({'display': 'flex'});
    fnGetMenu(id, level);
};
var EditJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            fnAlertStr('EditJS successfully load', 'success', {timeOut: 2000});
            $('select[name="parent_menu"]').on('change', function () {
                var id = $(this).val();
                var level = $('option:selected', this).attr('data-level');
                //var field = '#menu' +  parseInt(level) + 1;
                $('#result_menu').css({'display': 'flex'});
                fnGetMenu(id, level);
            });
            $('input[name="check"]').on('click', function () {
                var checked = $(this)[0].checked;
                //console.log(checked);return false;
                var value = $(this)[0].value;
                if (checked == true && value == 'is_badge') {
                    //console.log(checked);
                    $('#badgeID').show();
                }
                if (checked == false && value == 'is_badge') {
                    //console.log(checked);
                    $('#badgeID').hide();
                }
            });
            $('#submit_form_add_menu').on('click', function (e) {
                e.preventDefault();
                var uri = _base_extraweb_uri + '/master/menu/insert';
                var type = 'POST';
                var child_menu = $('select[name="menu_child[]"]').map(function () {
                    if(this.value != 0){
                        return this.value;
                    }
                }).get();
                var formdata = {
                    name: $('input[name="name"]').val(),
                    path: $('input[name="path"]').val(),
                    content_path: $('input[name="content_path"]').val(),
                    icon: $('select[name="icon"]').val(),
                    is_badge: $('input[type="checkbox"][name="check"][value="is_badge"]')[0].checked,
                    badge: $('input[name="badge"]').val(),
                    badge_id: $('input[name="badge_id"]').val(),
                    badge_value: $('input[name="badge_value"]').val(),
                    parent_menu: $('select[name="parent_menu"]').val(),
                    child_menu: child_menu,
                    module_id: parseInt($('select[name="module_id"]').val()),
                    is_basic: $('input[type="checkbox"][name="check"][value="is_basic"]')[0].checked,
                    is_open: $('input[type="checkbox"][name="check"][value="is_open"]')[0].checked,
                    is_active: $('input[type="checkbox"][name="check"][value="is_active"]')[0].checked
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
    EditJS.init();
});
</script>

