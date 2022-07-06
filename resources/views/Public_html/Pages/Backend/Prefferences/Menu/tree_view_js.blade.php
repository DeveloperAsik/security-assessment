<script src="{{config('app.base_assets_uri')}}/templates/metronic/assets/global/plugins/jstree/dist/jstree.min.js"></script>
<script>
var MenuViewJS = function () {
    var fnInitTree = function (data, id) {
        $("#tree_" + id).jstree({
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
        //$('#tree_' + id).on('changed.jstree', function (e, data) {});
        //$('#tree_' + id).on('create_node.jstree', function (e, data) {});
        if (data) {
            $('#tree_' + id).on('rename_node.jstree', function (e, data) {
                var formdata = [];
                if (data.node.original.text == 'New node') {
                    formdata = {
                        'id': data.node.id,
                        'is_insert': true,
                        'is_update': false,
                        'module_id': id,
                        'parent': data.node.parent,
                        'value': data.node.text
                    };
                } else {
                    formdata = {
                        'id': parseInt(data.node.id),
                        'is_insert': false,
                        'is_update': true,
                        'module_id': id,
                        'parent': data.node.parent,
                        'value': data.node.text
                    };
                }
                var uri = _base_extraweb_uri + '/ajax/post/update-menu';
                var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code == 200) {
                    fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
                } else {
                    fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
                }
                return false;
            });
        }
        $('#tree_' + id).on('delete_node.jstree', function (e, data) {
            var formdata = [];
            formdata = {
                'id': Base64.encode(parseInt(data.node.id)),
                'is_delete': true
            };
            var uri = _base_extraweb_uri + '/ajax/post/update-menu';
            var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
            if (response.responseJSON.status.code == 200) {
                fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
            } else {
                fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
            }
            return false;
        });
        $('#tree_' + id).on('move_node.jstree', function (e, data) {
            console.log(data);
            console.log('move: ' + data.node.id);
            //return false;
            var formdata = [];
            formdata = {
                'id': Base64.encode(parseInt(data.node.id)),
                'new_position' : data.position,
                'new_parent' : data.parent,
                'is_move': true
            };
            var uri = _base_extraweb_uri + '/ajax/post/update-menu';
            var response = fnAjaxSend(JSON.stringify(formdata), uri, "POST", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
            if (response.responseJSON.status.code == 200) {
                fnAlertStr(response.responseJSON.status.message, 'success', {timeOut: 2000});
            } else {
                fnAlertStr(response.responseJSON.status.message, 'error', {timeOut: 2000});
            }
            return false;
        });
        $('#tree_' + id).on('copy_node.jstree', function (e, data) {
            console.log('copy: ' + data.selected);
        });
    };
    var fnGetTreeMenu = function (module_id) {
        var uri = _base_extraweb_uri + '/ajax/get/get-menu?module_id=' + module_id;
        var response = fnAjaxSend({}, uri, "GET", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
        if (response) {
            fnInitTree(response.responseJSON.data, module_id);
        }
    };
    return {
        //main function to initiate the module
        init: function () {
            //$.notific8('iyey', {'theme': 'lime', 'sticky': false, 'horizontalEdge': 'top', 'verticalEdge': 'right'});
            fnAlertStr('MenuViewJS successfully load', 'success', {timeOut: 2000});
            var module_active = $('a#tab-1.nav-link.active')[0].getAttribute('data-module_id');
            if (module_active) {
                fnGetTreeMenu(module_active);
            }
            $('.nav li a').click(function () {
                fnGetTreeMenu($(this).attr("data-module_id"));
            });
            $('#modal_edit_node').on('shown.bs.modal', function (event) {
                var id = event.relatedTarget.attributes['data-id'].value;
                var uri = _base_extraweb_uri + '/ajax/get/get-menu-single?id=' + id;
                var response = fnAjaxSend({}, uri, "GET", {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, false);
                if (response.responseJSON.status.code == 200) {
                    $('input[name="menu_id"]').val(response.responseJSON.data[0].id);
                    $('input[name="parent_id"]').val(response.responseJSON.data[0].parent_id);
                    $('input[name="title"]').val(response.responseJSON.data[0].title);
                    $('input[name="icon"]').val(response.responseJSON.data[0].icon);
                    $('input[name="path"]').val(response.responseJSON.data[0].path);
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
                    'id': $('input[name="menu_id"]').val(),
                    'is_insert': false,
                    'is_update': true,
                    'parent': $('input[name="parent_id"]').val(),
                    'title': $('input[name="title"]').val(),
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
                    'module_id': $('select[name="module"]').val(),
                };
                var uri = _base_extraweb_uri + '/ajax/post/update-menu';
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