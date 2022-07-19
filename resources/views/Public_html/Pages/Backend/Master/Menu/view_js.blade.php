<script src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/jstree/dist/jstree.min.js"></script>
<script>
var fnGetTreeMenu = function (module_id, group_id) {
    var uri = _base_extraweb_uri + '/master/menu/get_list?a=1&module_id=' + module_id + '&group_id=' + group_id;
    var response = fnAjaxSend({}, uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
    if (response.responseJSON.status.code == 200) {
        fnInitTree(response.responseJSON.data, module_id, group_id);
    }
};

var fnInitTree = function (data, module_id, group_id) {
    console.log("#tree_" + group_id);
    $("#tree_" + group_id).jstree({
        "core": {
            "themes": {
                "responsive": false
            },
            "check_callback": true,
            "data": data
        },
        "types": {
            "default": {
                "icon": "fa fa-folder icon-state-warning icon-lg"
            },
            "file": {
                "icon": "fa fa-file icon-state-warning icon-lg"
            }
        },
        "state": {"key": "demo2"},
        "plugins": ["contextmenu", "dnd", "state", "types"],
        "contextmenu": {
            'items': function (node) {
                var items = $.jstree.defaults.contextmenu.items();
                items.ccp = false;

                return items;
            }
        }
    });
    if (data) {
        $('#tree_' + group_id).on('rename_node.jstree', function (e, data) {
            var formdata = [];
            if (data.node.original.text == 'New node') {
                formdata = {
                    'id': data.node.id,
                    'is_insert': true,
                    'is_update': false,
                    'module_id': module_id,
                    'group_id': group_id,
                    'parent': data.node.parent,
                    'value': data.node.text
                };
            } else {
                formdata = {
                    'id': parseInt(data.node.id),
                    'is_insert': false,
                    'is_update': true,
                    'module_id': module_id,
                    'group_id': group_id,
                    'parent': data.node.parent,
                    'value': data.node.text
                };
            }
            var uri = _base_extraweb_uri + '/master/menu/update/' + formdata.id + '?a=1';
            var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
            if (response.responseJSON.status.code == 200) {
                fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
            } else {
                fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
            }
            return false;
        });
    }
    $('#tree_' + group_id).on('delete_node.jstree', function (e, data) {
        var formdata = [];
        formdata = {
            'id': Base64.encode(parseInt(data.node.id)),
            'is_delete': true
        };
        var uri = _base_extraweb_uri + '/master/menu/update/' + formdata.id + '?a=1';
        var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
        if (response.responseJSON.status.code == 200) {
            fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
        } else {
            fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
        }
        return false;
    });
    $('#tree_' + group_id).on('move_node.jstree', function (e, data) {
        console.log(data);
        console.log('move: ' + data.node.id);
        //return false;
        var formdata = [];
        formdata = {
            'id': Base64.encode(parseInt(data.node.id)),
            'new_position': data.position,
            'new_parent': data.parent,
            'is_move': true
        };
        var uri = _base_extraweb_uri + '/master/menu/update/' + formdata.id + '?a=1';
        var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
        if (response.responseJSON.status.code == 200) {
            fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
        } else {
            fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
        }
        return false;
    });
    $('#tree_' + group_id).on('copy_node.jstree', function (e, data) {
        console.log('copy: ' + data.selected);
    });
};
var MenuViewJS = function () {
    return {
        //main function to initiate the module
        init: function () {
            //$.notific8('iyey', {'theme': 'lime', 'sticky': false, 'horizontalEdge': 'top', 'verticalEdge': 'right'});
            fnAlertStr('MenuViewJS successfully load', 'success', {timeOut: 2000});
            //ul#tab_modules.nav.nav-tabs li.nav-item a.nav-link.active
            var module_id = $('ul#tab_modules.nav.nav-tabs li.nav-item a.nav-link.active')[0].getAttribute('data-module_id');
            console.log(module_id);
            switch (module_id) {
                case 1:
                    break;
                case 2 :
                    break;
                default:
                    var group_id = $('ul#tab_group.nav.nav-tabs li.nav-item a.nav-link.active')[0].getAttribute('data-group_id');
                    console.log(group_id);
                    fnGetTreeMenu(module_id, group_id);
                    break;
            }
            $('ul#tab_group.nav.nav-tabs li.nav-item a').click(function () {
                fnGetTreeMenu(module_id, group_id);
            });

            $('#modal_edit_node').on('shown.bs.modal', function (event) {
                var id = event.relatedTarget.attributes['data-id'].value;
                var uri = _base_extraweb_uri + '/master/menu/get_list?a=2&id=' + id;
                var response = fnAjaxSend({}, uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code == 200) {
                    $('input[name="menu_id"]').val(response.responseJSON.data[0].id);
                    $('input[name="module_id"]').val(response.responseJSON.data[0].module_id);
                    $('input[name="parent_id"]').val(response.responseJSON.data[0].parent_id);
                    $('input[name="name"]').val(response.responseJSON.data[0].name);
                    $('input[name="icon"]').val(response.responseJSON.data[0].icon);
                    $('input[name="path"]').val(response.responseJSON.data[0].path);
                    $('input[name="content_path"]').val(response.responseJSON.data[0].content_path);
                    $('input[name="badge"]').val(response.responseJSON.data[0].badge);
                    $('input[name="badge_value"]').val(response.responseJSON.data[0].badge_value);
                    $('input[name="level"]').val(response.responseJSON.data[0].level);
                    $('input[name="rank"]').val(response.responseJSON.data[0].rank);

                    var is_basic = (response.responseJSON.data[0].is_basic == 1) ? true : false;
                    $('input[name="is_basic"][type="checkbox"]').prop('checked', is_basic);
                    var is_badge = (response.responseJSON.data[0].is_badge == 1) ? true : false;
                    $('input[name="is_badge"][type="checkbox"]').prop('checked', is_badge);
                    var is_open = (response.responseJSON.data[0].is_open == 1) ? true : false;
                    $('input[name="is_open"][type="checkbox"]').prop('checked', is_open);
                    var is_active = (response.responseJSON.data[0].is_active == 1) ? true : false;
                    $('input[name="is_active"][type="checkbox"]').prop('checked', is_active);

                    $('select[name="module"]').val(response.responseJSON.data[0].module_id).change();
                    fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                } else {
                    fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
                }
                return false;
            });
            
            $('div#modal_edit_node div div div button#submit_modal_edit_node').on('click', function () {
                var formdata = {
                    'id': Base64.encode($('input[name="menu_id"]').val()),
                    'is_insert': false,
                    'is_update': true,
                    'parent': $('input[name="parent_id"]').val(),
                    'name': $('input[name="name"]').val(),
                    'icon': $('input[name="icon"]').val(),
                    'path': $('input[name="path"]').val(),
                    'content_path': $('input[name="content_path"]').val(),
                    'badge': $('input[name="badge"]').val(),
                    'badge_value': $('input[name="badge_value"]').val(),
                    'level': $('input[name="level"]').val(),
                    'rank': $('input[name="rank"]').val(),
                    'is_badge': $('input[type="checkbox"][name="is_badge"]')[0].checked, // $('input[name="is_badge"]').val(),
                    'is_open': $('input[type="checkbox"][name="is_open"]')[0].checked, //$('input[name="is_open"]').val(),
                    'is_active': $('input[type="checkbox"][name="is_active"]')[0].checked, //$('input[name="is_active"]').val(),
                    'module_id': $('select[name="module"]').val()
                };
                var uri = _base_extraweb_uri + '/master/menu/update/' + formdata.id + '?a=1';
                var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
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
    MenuViewJS.init();
});
</script>