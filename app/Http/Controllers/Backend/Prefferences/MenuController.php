<?php

namespace App\Http\Controllers\Backend\Prefferences;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\Core\Tbl_a_modules;
use App\Models\Tables\Core\Tbl_d_icons;
use App\Models\Tables\Core\Tbl_a_groups;
use App\Helpers\MyHelper;

/**
 * Description of MenuController
 *
 * @author I00396.ARIF
 */
class MenuController extends Controller {

    //put your code here
    public function create(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Menu Access',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/view'
            ],
            [
                'id' => 3,
                'title' => 'Menu list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/tree_view'
            ],
            [
                'id' => 4,
                'title' => 'Create new Menu',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/menu/create'
            ]
        ];
        $modules = Tbl_a_modules::get_all($request);
        $groups = Tbl_a_groups::get_all($request);
        $badges = Tbl_a_groups::get_all($request);
        $icons = Tbl_d_icons::get_all($request);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'modules', 'icons', 'groups', 'badges'));
    }

    public function view(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Create new Menu',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/create'
            ],
            [
                'id' => 3,
                'title' => 'Menu list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/tree_view'
            ],
            [
                'id' => 4,
                'title' => 'Menu Access',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/menu/view'
            ]
        ];
        $module = DB::table('tbl_a_modules AS a')->get();
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'module'));
    }

    public function tree_view(Request $request) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumbs = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Create new Menu',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/create'
            ],
            [
                'id' => 3,
                'title' => 'Menu Access',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/view'
            ],
            [
                'id' => 4,
                'title' => 'Menu List',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/menu/tree_view'
            ]
        ];
        $module = DB::table('tbl_a_modules AS a')->get();
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'module'));
    }

    public function get_list(Request $request) {
        if (isset($request) && !empty($request)) {
            $draw = $request['draw'];
            $start = (int) $request['start'];
            $length = $request['length'];
            $page = 1;
            if ($start > 0) {
                $r = ($start / $length);
                $page = $r + 1;
            }
            $limit = ($request->length) ? $request->length : 10;
            $offset = ($request->start) ? $request->start : 0;
            $search = $request['search']['value'];
            if (isset($search) && !empty($search)) {
                $data = DB::table('tbl_a_user_menus AS a')
                        ->select('a.id AS user_menu_id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'b.id', 'b.is_allowed', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS group_id', 'd.title AS group_name')
                        ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                        ->leftJoin('tbl_a_groups AS d', 'd.id', '=', 'b.group_id')
                        ->where('b.url', 'like', '%' . $search . '%')
                        ->orWhere('c.name', 'like', '%' . $search . '%')
                        ->orWhere('b.route', 'like', '%' . $search . '%')
                        ->orWhere('b.class', 'like', '%' . $search . '%')
                        ->orWhere('b.method', 'like', '%' . $search . '%')
                        ->orWhere('d.name', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            } else {
                $data = DB::table('tbl_a_user_menus AS a')
                        ->select('a.id AS user_menu_id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'b.id', 'b.is_allowed', 'c.id AS module_id', 'c.name AS module_name', 'd.id AS group_id', 'd.title AS group_name')
                        ->leftJoin('tbl_a_user_menu_access AS b', 'b.user_menu_id', '=', 'a.id')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                        ->leftJoin('tbl_a_groups AS d', 'd.id', '=', 'b.group_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
            }
            $total_rows = DB::table('tbl_a_user_menus AS a')->count();
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_badge = '';
                    if ($value->is_badge == 1) {
                        $is_badge = ' checked';
                    }
                    $is_open = '';
                    if ($value->is_open == 1) {
                        $is_open = ' checked';
                    }
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $is_allowed = '';
                    if ($value->is_allowed == 1) {
                        $is_allowed = ' checked';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'name' => $value->title,
                        'icon' => $value->icon,
                        'group_id' => $value->group_id,
                        'badge' => $value->badge,
                        'badge_value' => $value->badge_value,
                        'path' => $value->path,
                        'level' => $value->level,
                        'rank' => $value->rank,
                        'is_badge' => '<input type="checkbox"' . $is_badge . ' name="check" value="is_badge" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                        'is_open' => '<input type="checkbox"' . $is_open . ' name="check" value="is_open" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="check" value="is_active" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                        'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="check" value="is_allowed" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                        'group_name' => $value->group_name,
                        'module_name' => $value->module_name,
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/menu/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="fas fa-plus-circle"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/menu/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/menu/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="far fa-trash-alt"></i></a></button>
                      </div>',
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

    public function edit(Request $request, $id = null) {
        $title_for_layout = config('app.default_variables.title_for_layout');
        $_breadcrumb = [
            [
                'id' => 1,
                'title' => 'Dashboard',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri')
            ],
            [
                'id' => 2,
                'title' => 'Menu list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/menu/view'
            ],
            [
                'id' => 3,
                'title' => 'Menu Edit ( id ' . base64_decode($id) . ' )',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/menu/edit/' . $id
            ]
        ];
        $modules = Tbl_user_a_permissions::fnGetModules($request);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', 'modules'));
    }

    public function insert(Request $request) {
        $data = $request->json()->all();
        $response = false;
        if (isset($data) && !empty($data)) {
            $param = [
                'title' => $data['title'],
                'path' => $data['path'],
                'content_path' => isset($data['content_path']) ? $data['content_path'] : "-",
                'icon' => isset($data['icon']) ? $data['icon'] : '-',
                'level' => isset($data['level']) ? $data['level'] : 1,
                'rank' => isset($data['rank']) ? $data['rank'] : 1,
                'is_badge' => $data['is_badge'],
                'badge' => isset($data['badge']) ? $data['badge'] : "",
                'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                'module_id' => $data['module_id'],
                'parent_id' => isset($data['parent_id']) ? $data['parent_id'] : 0,
                'is_open' => isset($data['is_open']) ? $data['is_open'] : 0,
                'is_active' => $data['is_active'],
                'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
            ];
            $c_menu_id = DB::table('tbl_a_user_menus')->insertGetId($param);
            if ($data['group']) {
                foreach ($data['group'] AS $k => $v) {
                    if ($c_menu_id) {
                        $param2 = [
                            'user_menu_id' => $c_menu_id,
                            'group_id' => isset($v) ? $v : 0,
                            'is_allowed' => isset($data['is_open']) ? $data['is_open'] : 0,
                            'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                            'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                            'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                            'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                            'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                        ];
                        $response = DB::table('tbl_a_user_menu_access')->insert($param2);
                    }
                }
            }
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update modules', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update modules.', 'valid' => false]);
            }
        }
    }

    public function update(Request $request, $id = null) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            switch ($data['action']) {
                case 'is_active':
                    $update_data = [
                        'is_active' => $data['is_active'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => date('Y-m-d H:i:s')
                    ];
                    break;
                default:
                    $update_data = [
                        'title' => $data->title,
                        'path' => $data->path,
                        'content_path' => isset($data->content_path) ? $data->content_path : "-",
                        'icon' => isset($data->icon) ? $data->icon : '-',
                        'level' => isset($data->level) ? $data->level : 1,
                        'rank' => $data->rank,
                        'is_badge' => $data->is_badge,
                        'badge' => isset($data->badge) ? $data->badge : "",
                        'badge_value' => isset($data->badge_value) ? $data->badge_value : "",
                        'module_id' => $data->module_id,
                        'parent_id' => $data->parent_id,
                        'is_open' => $data->is_open,
                        'is_active' => $data->is_active,
                        'updated_by' => $data->updated_by,
                        'updated_date' => $data->updated_date,
                    ];
                    break;
            }
            $response = DB::table('tbl_a_user_menus')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                $param2 = [
                    'group_id' => $data->group_id,
                    'is_allowed' => $data->is_open,
                    'is_active' => $data->is_active,
                    'updated_by' => $data->updated_by,
                    'updated_date' => $data->updated_date,
                ];
                DB::table('tbl_a_user_menu_access')->insert($param2);
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update modules', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update modules.', 'valid' => false]);
            }
        }
    }

}
