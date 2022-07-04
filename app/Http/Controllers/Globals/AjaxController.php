<?php

namespace App\Http\Controllers\Globals;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\Core\Tbl_a_user_menus;
use App\Models\Tables\Core\Tbl_logs;
use App\Models\Tables\Core\Tbl_a_user_menu_access;
use App\Helpers\MyHelper;
use App\Http\Middleware\TokenUser;

/**
 * Description of AjaxController
 *
 * @author I00396.ARIF
 */
class AjaxController extends Controller {

//put your code here

    public function fn_ajax_get(Request $request, $method = '') {
        switch ($method) {
            case "get-permission":
                $response = $this->fn_get_permission($request);
                break;
            case "get-menu":
                $response = $this->fn_get_menu($request);
                break;
            case "get-menu-by-level":
                $response = $this->fn_get_menu_by_level($request);
                break;
            case "get-menu-single":
                $response = $this->fn_get_menu_single($request);
                break;
            case "get-menu-child":
                $response = $this->fn_get_menu_child($request);
                break;
            case "get-logs":
                $response = $this->fn_get_logs($request);
                break;
        }
        return $response;
    }

    protected function fn_get_logs($request) {
        if (isset($request) && !empty($request)) {
            return Tbl_logs::get_list($request);
        } else {
            return null;
        }
    }

    protected function fn_get_permission($request) {
        $permissions = DB::table('tbl_user_a_permissions AS a')->select('*')->get();
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching permissions data.', 'valid' => true, 'data' => $permissions]);
    }

    protected function fn_get_menu_single($request) {
        $menu = [];
        if ($request->id) {
            $menu = Tbl_a_user_menus::get_menu_by_id($request->id, 1, 0);
        }
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $menu]);
    }

    protected function fn_get_menu_child($request) {
        $menu = [];
        if ($request->parent_id) {
            $menu = Tbl_a_user_menus::get_menu_by_parent_id($request->module_id, $request->level, $request->parent_id);
        }
        $strMenu = '';
        $strMenu .= '<div class="form-group row"><label class="col-sm-2 control-label">Menu Parent level ' . $request->level . '</label>
                        <select class="form-control col-sm-9" id="menu' . $request->level . '" name="menu' . $request->level . '" data-level="' . $request->level . '" style="width: 100%; margin-left:8px" onchange="fnSelectMenu(' . $request->parent_id . ',' . $request->level . ',' . $request->module_id . ')">';
        $strMenu .= '<option value="0">-- select one --</option>';
        foreach ($menu AS $key => $value) {
            $strMenu .= '<option value="' . $value->id . '">Title : ' . $value->title . ' | ID : ' . $value->id . ', Parent ID | ' . $value->parent_id . '</option>';
        }
        $strMenu .= '</select></div>';
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $menu]);
    }

    protected function fn_get_menu_by_level($request) {
        $menu = [];
        if ($request->level) {
            $i = $request->level - 1;
            $menu = Tbl_a_user_menus::get_menu_by_level($i, $request->module_id);
            $strMenu = '';
            if (isset($menu) && !empty($menu)) {
                $j = 1;
                $strMenu .= '<div class="form-group row"><label class="col-sm-2 control-label">Menu Parent level ' . $i . '</label>
                                <select class="form-control col-sm-9" id="menu' . $j . '" name="menu' . $j . '" data-level="' . $j . '" style="width: 100%; margin-left:8px">';
                $strMenu .= '<option value="0">-- select one --</option>';
                foreach ($menu AS $key => $value) {
                    $parent_name = 'root';
                    if ($value->parent_name != '')
                        $parent_name = $value->parent_name;
                    $strMenu .= '<option value="' . $value->id . '">' . $value->title . ' (ID : ' . $value->id . ', Parent : ' . $parent_name . ')</option>';
                }
                $strMenu .= '</select></div>';
            }
        }
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $strMenu]);
    }

    protected function fn_get_menu($request) {
        $menu = [];
        if ($request->module_id) {
            $menu_1 = Tbl_a_user_menus::get_menus($request->module_id, 1, 0);
            if ($menu_1) {
                foreach ($menu_1 AS $keyword => $value) {
                    $menu_2 = Tbl_a_user_menus::get_menus($request->module_id, ($value->level + 1), $value->id);
                    $arr_menu_2 = [];
                    if ($menu_2) {
                        foreach ($menu_2 AS $key => $val) {
                            $menu_3 = Tbl_a_user_menus::get_menus($request->module_id, ($val->level + 1), $val->id);
                            $arr_menu_3 = [];
                            if ($menu_3) {
                                foreach ($menu_3 AS $ky => $vl) {
                                    $menu_4 = Tbl_a_user_menus::get_menus($request->module_id, ($vl->level + 1), $vl->id);
                                    $arr_menu_4 = [];
                                    if ($menu_4) {
                                        foreach ($menu_4 AS $k => $v) {
                                            $menu_5 = Tbl_a_user_menus::get_menus($request->module_id, ($v->level + 1), $v->id);
                                            $arr_menu_5 = [];
                                            if ($menu_5) {
                                                foreach ($menu_5 AS $j => $w) {
                                                    $arr_menu_5[] = [
                                                        "id" => $w->id,
                                                        "parent" => $w->parent_id,
                                                        "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="4"  data-id="' . $w->id . '">' . $w->title . '</button>',
                                                        "icon" => $w->icon
                                                    ];
                                                }
                                            }
                                            $arr_menu_4[] = [
                                                "id" => $v->id,
                                                "parent" => $v->parent_id,
                                                "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="4"  data-id="' . $v->id . '">' . $v->title . '</button>',
                                                "icon" => $v->icon,
                                                "children" => $arr_menu_5
                                            ];
                                        }
                                    }
                                    $arr_menu_3[] = [
                                        "id" => $vl->id,
                                        "parent" => $vl->parent_id,
                                        "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="3"  data-id="' . $vl->id . '">' . $vl->title . '</button>',
                                        "icon" => $vl->icon,
                                        "children" => $arr_menu_4
                                    ];
                                }
                            }
                            $arr_menu_2[] = [
                                "id" => $val->id,
                                "parent" => $val->parent_id,
                                "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="2"  data-id="' . $val->id . '">' . $val->title . '</button>',
                                "icon" => $val->icon,
                                "children" => $arr_menu_3
                            ];
                        }
                    }
                    $menu[] = [
                        "id" => $value->id,
                        "parent" => $value->parent_id,
                        "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="1" data-id="' . $value->id . '">' . $value->title . '</button>',
                        "icon" => $value->icon,
                        "children" => $arr_menu_2
                    ];
                }
            }
        }
        $root_menu = [
            "id" => "root",
            "text" => "root",
            "icon" => "",
            "children" => $menu
        ];
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $root_menu]);
    }

    public function fn_ajax_post(Request $request, $method = '') {
        switch ($method) {
            case "form-detail":
                $response = $this->fn_post_update_form_detail($request);
                break;
            case "form-prefferences":
                $response = $this->fn_post_update_form_prefferences($request);
                break;
            case "form-add-group-permission":
                $response = $this->fn_post_add_group_permission($request);
                break;
            case "update-menu":
                $response = $this->fn_post_update_menu($request);
                break;
            case "update-menu-status":
                $response = $this->fn_post_update_menu_status($request);
                break;
            case "post-group-permission-list":
                $response = $this->fn_post_get_group_permission_list($request);
                break;
            case "get-user-list":
                $response = $this->fn_get_user_list($request);
                break;
            case "get-permission-list":
                $response = $this->fn_get_permission_list($request);
                break;
            case "get-group-list":
                $response = $this->fn_get_group_list($request);
                break;
            case "get-group-permission-list":
                $response = $this->fn_get_group_permission_list($request);
                break;
            case "get-classess-list":
                $response = $this->fn_get_classes_list($request);
                break;
            case "group_permission_update":
                $response = $this->fn_post_group_permission_update($request);
                break;
        }
        return $response;
    }

    protected function fn_post_group_permission_update($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            if (isset($data['is_public'])) {
                $dupdate = isset($data['is_public']) ? (int) $data['is_public'] : 0;
                $dstring = 'is_public';
            } elseif (isset($data['is_allowed'])) {
                $dupdate = isset($data['is_allowed']) ? (int) $data['is_allowed'] : 0;
                $dstring = 'is_allowed';
            } elseif (isset($data['is_active'])) {
                $dupdate = isset($data['is_active']) ? (int) $data['is_active'] : 0;
                $dstring = 'is_active';
            }
            $param = [
                $dstring => $dupdate,
                'updated_by' => $this->__user_id,
                'updated_date' => MyHelper::getDateNow(),
            ];
            $response = DB::table('tbl_a_group_auth')->where('id', '=', (int) $data['id'])->update($param);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully group permission.', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update  group permission.', 'valid' => false]);
            }
        }
    }

    protected function fn_get_group_permission_list($request) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_a_group_auth AS a')
                        ->select('a.*', 'b.id AS permission_id', 'b.title', 'b.path', 'b.controller', 'b.method', 'b.module_id', 'b.is_active AS permission_is_active', 'c.id AS group_id', 'c.title AS group_name', 'd.name AS module_name')
                        ->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_modules AS d', 'd.id', '=', 'b.module_id')
                        ->where('b.title', 'like', '%' . $search . '%')
                        ->orWhere('b.path', 'like', '%' . $search . '%')
                        ->orWhere('b.controller', 'like', '%' . $search . '%')
                        ->orWhere('b.method', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            $total_rows = DB::table('tbl_a_group_auth AS a')->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_modules AS d', 'd.id', '=', 'b.module_id')
                        ->where('b.title', 'like', '%' . $search . '%')
                        ->orWhere('b.path', 'like', '%' . $search . '%')
                        ->orWhere('b.controller', 'like', '%' . $search . '%')
                        ->orWhere('b.method', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::table('tbl_a_group_auth AS a')
                        ->select('a.*', 'b.id AS permission_id', 'b.title', 'b.path', 'b.controller', 'b.method', 'b.module_id', 'b.is_active AS permission_is_active', 'c.id AS group_id', 'c.title AS group_name', 'd.name AS module_name')
                        ->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_modules AS d', 'd.id', '=', 'b.module_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            $total_rows = DB::table('tbl_a_group_auth AS a') ->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_modules AS d', 'd.id', '=', 'b.module_id')->count();
            }
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_public = '';
                    $is_public_value = 0;
                    if ($value->is_public == 1) {
                        $is_public = ' checked';
                        $is_public_value = 1;
                    }
                    $is_allowed = '';
                    $is_allowed_value = 0;
                    if ($value->is_allowed == 1) {
                        $is_allowed = ' checked';
                        $is_allowed_value = 1;
                    }
                    $is_active = '';
                    $is_active_value = 0;
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                        $is_active_value = 1;
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'path' => $value->path,
                        'controller' => $value->controller,
                        'method' => $value->method,
                        'module' => $value->module_name,
                        'group' => $value->group_name,
                        'is_public' => '<input type="checkbox"' . $is_public . ' value="' . $is_public_value . '" name="is_public" class="make-switch" data-size="small" data-id="' . $value->id . '">',
                        'is_allowed' => '<input type="checkbox"' . $is_allowed . ' value="' . $is_allowed_value . '" name="is_allowed" class="make-switch" data-size="small" data-id="' . $value->id . '">',
                        'is_active' => '<input type="checkbox"' . $is_active . ' value="' . $is_active_value . '" name="is_active" class="make-switch" data-size="small" data-id="' . $value->id . '">',
                    ];
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_rows,
                    'recordsFiltered' => $total_rows,
                    'data' => $arr,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    protected function fn_get_classes_list($param) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_user_a_classes')
                        ->where('namespace', 'like', '%' . $search . '%')
                        ->orWhere('class', 'like', '%' . $search . '%')
                        ->orWhere('method', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            } else {
                $data = DB::table('tbl_user_a_classes AS a')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            }
            $total_rows = DB::table('tbl_user_a_classes AS a')->count();
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    $is_active_value = 0;
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                        $is_active_value = 1;
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'namespace' => $value->route_name,
                        'class' => $value->class,
                        'method' => $value->method,
                        'group' => $value->group_name,
                        'is_active' => '<input type="checkbox"' . $is_active . ' value="' . $is_active_value . '" name="is_active" class="make-switch" data-size="small" data-id="' . $value->id . '">',
                    ];
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_rows,
                    'recordsFiltered' => $total_rows,
                    'data' => $arr,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    protected function fn_get_group_list($request) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_a_groups AS a')
                        ->select('a.*')
                        ->where('a.name', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            } else {
                $data = DB::table('tbl_a_groups AS a')
                        ->select('a.*')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            }
            $total_rows = DB::table('tbl_a_groups AS a')->count();
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'name' => $value->name,
                        'description' => $value->description,
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
                        'action' => '<a href="">edit</a> | <a href="">delete</a> | <a href="">remove</a>'
                    ];
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_rows,
                    'recordsFiltered' => $total_rows,
                    'data' => $arr,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    protected function fn_get_permission_list($request) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_a_permissions AS a')
                        ->select('a.id', 'a.route_name', 'a.url', 'a.class', 'a.method', 'a.is_active', 'b.id AS module_id', 'b.name AS module_name', 'b.alias AS module_alias')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where('a.route_name', 'like', '%' . $search . '%')
                        ->orWhere('a.url', 'like', '%' . $search . '%')
                        ->orWhere('a.class', 'like', '%' . $search . '%')
                        ->orWhere('a.method', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            } else {
                $data = DB::table('tbl_a_permissions AS a')
                        ->select('a.id', 'a.route_name', 'a.url', 'a.class', 'a.method', 'a.is_active', 'b.id AS module_id', 'b.name AS module_name', 'b.alias AS module_alias')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            }
            $total_rows = DB::table('tbl_a_permissions AS a')->count();
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    $is_active_value = 0;
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                        $is_active_value = 1;
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'route_name' => $value->route_name,
                        'url' => $value->url,
                        'class' => $value->class,
                        'method' => $value->method,
                        'module_id' => $value->module_id,
                        'module_name' => $value->module_name,
                        'is_active' => '<input type="checkbox"' . $is_active . ' value="' . $is_active_value . '" name="is_active" class="make-switch" data-size="small" data-id="' . $value->id . '">',
                        'action' => '<a href="/extraweb/permission/edit/' . $value->id . '">edit</a>'
                    ];
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_rows,
                    'recordsFiltered' => $total_rows,
                    'data' => $arr,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    protected function fn_get_user_list($request) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_user_a_users AS a')
                        ->select('a.*', 'c.id as group_id', 'c.name as group_name')
                        ->leftJoin('tbl_user_b_user_groups AS b', 'b.user_id', '=', 'a.id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'b.group_id')
                        ->where('a.code', 'like', '%' . $search . '%')
                        ->orWhere('a.user_name', 'like', '%' . $search . '%')
                        ->orWhere('a.first_name', 'like', '%' . $search . '%')
                        ->orWhere('a.last_name', 'like', '%' . $search . '%')
                        ->orWhere('a.email', 'like', '%' . $search . '%')
                        ->orWhere('c.name', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            } else {
                $data = DB::table('tbl_user_a_users AS a')
                        ->select('a.*', 'c.id as group_id', 'c.name as group_name')
                        ->leftJoin('tbl_user_b_user_groups AS b', 'b.user_id', '=', 'a.id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'b.group_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            }
            $total_rows = DB::table('tbl_user_a_users AS a')->count();
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'code' => $value->code,
                        'user_name' => $value->user_name,
                        'first_name' => $value->first_name,
                        'last_name' => $value->last_name,
                        'email' => $value->email,
                        'group_id' => $value->group_id,
                        'group_name' => $value->group_name,
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
                        'action' => '<a href="">edit</a> | <a href="">delete</a> | <a href="">remove</a>'
                    ];
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_rows,
                    'recordsFiltered' => $total_rows,
                    'data' => $arr,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    public function fn_post_update_menu_status(Request $request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $menu_access = Tbl_a_user_menu_access::get_by_id($data['id']);
            dd($menu_access);
            switch ($data['field']) {
                case "is_badge":
                    $update_data = [
                        'is_badge' => $data['value'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    $response = DB::table('tbl_a_user_menus')->where('id', '=', (int) $data['id'])->update($update_data);
                    break;

                case "is_open":
                    $update_data = [
                        'is_badge' => $data['value'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    $response = DB::table('tbl_a_user_menus')->where('id', '=', (int) $data['id'])->update($update_data);
                    break;

                case "is_active":
                    $update_data = [
                        'is_badge' => $data['value'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    $response = DB::table('tbl_a_user_menus')->where('id', '=', (int) $data['id'])->update($update_data);
                    break;

                case "is_allowed":
                    $update_data = [
                        'is_badge' => $data['value'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    $response = DB::table('tbl_a_user_menu_access')->where('id', '=', (int) $data['id'])->update($update_data);
                    break;
            }
        }
    }

    public function fn_post_update_menu(Request $request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            if (isset($data['is_delete']) && !empty($data['is_delete'])) {
                $id = (int) base64_decode($data['id']);
                $response = DB::table('tbl_a_user_menus')->where('id', '=', $id)->delete();
                if ($response) {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully delete data.', 'valid' => true]);
                } else {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed delete data.', 'valid' => false]);
                }
            } else {
                if ($data['parent'] && $data['parent'] == 'root') {
                    $parent_id = 0;
                    $level = 1;
                    $exist_all = DB::table('tbl_a_user_menus AS a')->select('*')->where('a.module_id', '=', $data['module_id'])->where('a.level', '=', $level)->where('a.parent_id', '=', $parent_id)->get();
                    $total_exist = count($exist_all);
                    $rank = $total_exist + 1;
                } else {
                    $parent_id = (int) $data['parent'];
                    $parent = DB::table('tbl_a_user_menus AS a')->select('*')->where('a.id', '=', $parent_id)->first();
                    $members = DB::table('tbl_a_user_menus AS a')->select('*')->where('a.parent_id', '=', $parent_id)->get();
                    if ($data['is_insert'] == true) {
                        $total_member = count($members);
                        $level = (int) $parent->level + 1;
                        if ($total_member > 0) {
                            $i = $total_member - 1;
                            $rank = (int) $total_member + 1;
                        } else {
                            $rank = 1;
                        }
                    }
                }
                if ($data['is_insert'] == true) {
                    $param = [
                        'title' => (string) $data['value'],
                        'icon' => '',
                        'path' => '',
                        'content_path' => '',
                        'level' => $level,
                        'rank' => $rank,
                        'parent_id' => $parent_id,
                        'is_badge' => 0,
                        'badge' => isset($data['badge']) ? $data['badge'] : "",
                        'badge_id' => isset($data['badge_id']) ? $data['badge_id'] : "",
                        'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                        'is_open' => 0,
                        'is_active' => 1,
                        'module_id' => (int) $data['module_id'],
                        'created_by' => $this->__user_id,
                        'created_date' => MyHelper::getDateNow(),
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow(),
                    ];
                    $response = DB::table('tbl_a_user_menus')->insert($param);
                } else {
                    $title = '';
                    if (isset($data['value'])) {
                        $title = $data['value'];
                    } elseif (isset($data['title'])) {
                        $title = $data['title'];
                    }
                    $param = [
                        'title' => isset($title) ? (string) $title : '',
                        'icon' => isset($data['icon']) ? $data['icon'] : '',
                        'path' => isset($data['path']) ? $data['path'] : '',
                        'content_path' => isset($data['content_path']) ? $data['content_path'] : '',
                        'level' => isset($data['level']) ? (int) $data['level'] : 1,
                        'rank' => isset($data['rank']) ? (int) $data['rank'] : 1,
                        'parent_id' => isset($data['parent']) ? (int) $data['parent'] : 0,
                        'is_badge' => isset($data['is_badge']) ? (int) $data['is_badge'] : 0,
                        'badge' => isset($data['badge']) ? $data['badge'] : "",
                        'badge_id' => isset($data['badge_id']) ? $data['badge_id'] : "",
                        'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                        'is_open' => isset($data['is_open']) && $data['is_open'] == true ? 1 : 0,
                        'is_active' => isset($data['is_active']) && $data['is_active'] == true ? 1 : 0,
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    $response = DB::table('tbl_a_user_menus')->where('id', '=', (int) $data['id'])->update($param);
                }
                if ($response) {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update menu.', 'valid' => true]);
                } else {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update menu.', 'valid' => false]);
                }
            }
        }
    }

    public function fn_post_get_group_permission_list($request) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_a_group_auth AS a')
                        ->select('a.id', 'a.permission_id', 'a.group_id', 'a.is_allowed', 'a.is_public', 'a.is_active', 'b.route_name', 'b.url', 'b.class', 'b.method', 'b.is_active as permission_is_active', 'c.id AS group_id', 'c.name AS group_name')
                        ->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->orWhere('b.route_name', 'like', '%' . $search . '%')
                        ->orWhere('b.url', 'like', '%' . $search . '%')
                        ->orWhere('b.class', 'like', '%' . $search . '%')
                        ->orWhere('b.method', 'like', '%' . $search . '%')
                        ->orWhere('d.group_name', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            } else {
                $data = DB::table('tbl_a_group_auth AS a')
                        ->select('a.id', 'a.permission_id', 'a.group_id', 'a.is_allowed', 'a.is_public', 'a.is_active', 'b.route_name', 'b.url', 'b.class', 'b.method', 'b.is_active as permission_is_active', 'c.id AS group_id', 'c.name AS group_name')
                        ->leftJoin('tbl_a_permissions AS b', 'b.id', '=', 'a.permission_id')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->where('a.group_id', '=', $this->__group_id)
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            }
            $total_rows = DB::table('tbl_a_group_auth AS a')->count();
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_public = '';
                    if ($value->is_public == 1) {
                        $is_public = ' checked';
                    }
                    $is_allowed = '';
                    if ($value->is_allowed == 1) {
                        $is_allowed = ' checked';
                    }
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'url' => $value->url,
                        'route_name' => $value->route_name,
                        'class' => $value->class,
                        'method' => $value->method,
                        'group_id' => $value->group_id,
                        'group_name' => $value->group_name,
                        'is_public' => '<input type="checkbox"' . $is_public . ' name="is_public" class="make-switch" data-size="small">',
                        'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="is_allowed" class="make-switch" data-size="small">',
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
                        'action' => '<a href="">Edit</a> | <a href="">Delete</a>'
                    ];
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $total_rows,
                    'recordsFiltered' => $total_rows,
                    'data' => $arr,
                );
                echo json_encode($output);
            } else {
                echo json_encode(array());
            }
        } else {
            echo json_encode(array());
        }
    }

    protected function fn_post_update_form_detail($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $user = DB::table('tbl_user_a_users AS a')->select('a.id', 'a.user_name', 'a.email', 'a.password')->where('a.id', '=', $this->__user_id)->first();
            $param_update_profile = [
                'user_name' => (string) $data['user_name'],
                'first_name' => (string) $data['first_name'],
                'last_name' => (string) $data['last_name'],
                'email' => (string) $data['email']
            ];
            DB::table('tbl_user_a_users')->where('id', $this->__user_id)->update($param_update_profile);
            if ($data['is_change_pass'] == true) {
                if (isset($user) && !empty($user)) {
                    $verify_hash = TokenUser::__verify_hash(base64_decode($data['old_pass']), $user->password);
                    if ($verify_hash == true) {
                        $hashed_new_pass = TokenUser::__string_hash(base64_decode($data['new_pass1']));
                        DB::table('tbl_user_a_users')->where('id', $this->__user_id)->update([
                            'password' => $hashed_new_pass
                        ]);
                    }
                }
            }
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
        }
    }

    protected function fn_post_update_form_prefferences($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $users = DB::table('tbl_user_a_users AS a')->select('a.id', 'a.profile_id')->where('a.id', '=', $this->__user_id)->first();
            if ($users->profile_id != 0) {
                $param_update_profile = [
                    'facebook' => ($data['facebook']) ? (string) $data['facebook'] : '',
                    'twitter' => ($data['twitter']) ? (string) $data['twitter'] : '',
                    'instagram' => ($data['instagram']) ? (string) $data['instagram'] : '',
                    'linkedin' => ($data['linkedin']) ? (string) $data['linkedin'] : '',
                    'last_education' => ($data['last_education']) ? (string) $data['last_education'] : '',
                    'last_education_institution' => ($data['last_education_institution']) ? (string) $data['last_education_institution'] : '',
                    'skill' => ($data['skill']) ? (string) $data['skill'] : '',
                    'notes' => ($data['notes']) ? (string) $data['notes'] : '',
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                DB::table('tbl_user_a_profiles')->where('id', $users->profile_id)->update($param_update_profile);
            } else {
                $param_update_profile = [
                    'facebook' => ($data['facebook']) ? (string) $data['facebook'] : '',
                    'twitter' => ($data['twitter']) ? (string) $data['twitter'] : '',
                    'instagram' => ($data['instagram']) ? (string) $data['instagram'] : '',
                    'linkedin' => ($data['linkedin']) ? (string) $data['linkedin'] : '',
                    'last_education' => ($data['last_education']) ? (string) $data['last_education'] : '',
                    'last_education_institution' => ($data['last_education_institution']) ? (string) $data['last_education_institution'] : '',
                    'skill' => ($data['skill']) ? (string) $data['skill'] : '',
                    'notes' => ($data['notes']) ? (string) $data['notes'] : '',
                    'created_by' => $this->__user_id,
                    'created_date' => MyHelper::getDateNow(),
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                $profileID = DB::table('tbl_user_a_profiles')->insertGetId($param_update_profile);
                DB::table('tbl_user_a_users')->where('id', $users->id)->update(['profile_id' => $profileID]);
            }
            return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
        }
    }

    protected function fn_post_add_group_permission($request) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $permissions = DB::table('tbl_a_permissions')
                    ->where('url', '=', $data['url'])
                    ->where('route_name', '=', $data['route_name'])
                    ->where('class', '=', $data['class'])
                    ->where('method', '=', $data['method'])
                    ->where('module_id', '=', $data['module'])
                    ->first();
            if ($permissions == '' || empty($permissions) || $permissions == null) {
                $params = [
                    'route_name' => ($data['route_name']) ? (string) $data['route_name'] : '',
                    'url' => ($data['url']) ? (string) $data['url'] : '',
                    'class' => ($data['class']) ? (string) $data['class'] : '',
                    'method' => ($data['method']) ? (string) $data['method'] : '',
                    'description' => isset($data['description']) ? (string) $data['description'] : '-',
                    'module_id' => ($data['module']) ? (int) $data['module'] : '',
                    'is_active' => 1,
                    'created_by' => $this->__user_id,
                    'created_date' => MyHelper::getDateNow(),
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow(),
                ];
                $result = DB::table('tbl_a_permissions')->insertGetId($params);
                if ($result) {
                    $group_permissions = DB::table('tbl_a_group_auth AS a')->where('a.permission_id', '=', $result)->where('a.group_id', '=', $this->__group_id)->first();
                    if ($group_permissions == '' || empty($group_permissions) || $group_permissions == null) {
                        $param_group_permission = [
                            'group_id' => $this->__group_id,
                            'permission_id' => $result,
                            'is_allowed' => ($data['is_allowed'] == false) ? 1 : 0,
                            'is_public' => ($data['is_public'] == false) ? 1 : 0,
                            'is_active' => 1,
                            'created_by' => $this->__user_id,
                            'created_date' => MyHelper::getDateNow(),
                            'updated_date' => MyHelper::getDateNow(),
                        ];
                        $result = DB::table('tbl_a_group_auth')->insert($param_group_permission);
                    }
                    if ($data['is_generated_view'] == 1) {
                        
                    }
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
                }
            } else {

                return MyHelper::_set_response('json', ['code' => 500, 'message' => 'Failed insert new permission data exist.', 'valid' => false]);
            }
        }
    }

}
