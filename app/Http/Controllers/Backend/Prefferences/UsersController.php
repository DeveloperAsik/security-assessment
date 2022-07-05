<?php

namespace App\Http\Controllers\Backend\Prefferences;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\MyHelper;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\Core\Tbl_a_groups;
use App\Models\Tables\Core\Tbl_a_users;
use App\Models\Tables\Core\Tbl_a_modules;
use App\Models\Tables\Core\Tbl_a_permissions;
use App\Models\Tables\Core\Tbl_a_user_menus;

/**
 * Description of UsersController
 *
 * @author elitebook
 */
class UsersController extends Controller {

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
                'title' => 'User list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user/view'
            ],
            [
                'id' => 3,
                'title' => 'User create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];

        $modules = Tbl_a_modules::get_all($request)['data'];
        $groups = Tbl_a_groups::get_all($request)['data'];
        $param_permissions = [
            'conditions' => [
                ['module_id', '=', 2],
                ['is_basic', '=', 1]
            ],
            'order' => [
                'keyword' => 'id',
                'type' => 'ASC'
            ]
        ];
        $permissions = Tbl_a_permissions::get_all($request, $param_permissions)['data'];
        $param_menu = [
            'conditions' => [
                ['module_id', '=', 2],
                ['level', '=', 1]
            ],
            'order' => [
                'keyword' => 'rank',
                'type' => 'ASC'
            ]
        ];
        $menus = Tbl_a_user_menus::get_all($request, $param_menu)['data'];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'modules', 'groups', 'permissions', 'menus'));
    }

    public function view(Request $request) {
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
                'title' => 'User Permission',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user/view'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb'));
    }

    public function edit(Request $request, $pr_id = null) {
        $id = base64_decode($pr_id);
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
                'title' => 'User Permission',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user/view'
            ],
            [
                'id' => 3,
                'title' => 'User Edit',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user/edit/' . $id
            ]
        ];
        $user = Tbl_a_users::get_by_id($id);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', 'user'));
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
                $data = DB::table('tbl_a_users AS a')
                        ->where('a.id', '=', $search)
                        ->orWhere('a.title', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_users AS a')->where('a.id', '=', $search)->orWhere('a.title', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::table('tbl_a_users AS a')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_users AS a')->count();
            }
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'user_name' => $value->user_name,
                        'first_name' => $value->first_name,
                        'last_name' => $value->last_name,
                        'email' => $value->email,
                        'description' => $value->description,
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/user/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/user/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/user/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
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

    public function insert(Request $request) {
        $data = $request->json()->all();
        $response = false;
        if (isset($data) && !empty($data)) {
            $user_id[] = [
                'user_name' => $data['user_name'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'description' => $data['description'],
                'registered_type_id' => 1,
                'is_active' => $data['is_active'],
                'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
            ];
            $response = DB::table('tbl_a_users')->insert($user_id);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully insert data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed insert data.', 'valid' => false]);
            }
        }
    }

    public function update(Request $request, $pr_id = null) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $id = base64_decode($pr_id);
            switch ($data['action']) {
                case 'is_active':
                    $update_data = [
                        'is_active' => $data['is_active'],
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
                default:
                    $update_data = [
                        'user_name' => $data['user_name'],
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'description' => $data['description'],
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::table('tbl_a_users')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

    public function view_auth(Request $request) {
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
                'title' => 'Group Permission',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/group_user/view'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb'));
    }

    public function get_list_auth(Request $request) {
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
                $data = DB::table('Tbl_a_group_auth AS a')
                        ->select('a.*', 'c.id AS group_id', 'c.title AS group_name', 'd.id AS user_id', 'd.title AS user_name', 'd.path AS user_path', 'd.controller AS user_controller', 'd.method AS user_method', 'd.is_active AS user_status', 'e.id AS module_id', 'e.name AS module_name')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'a.user_id')
                        ->leftJoin('tbl_a_modules AS e', 'e.id', '=', 'd.module_id')
                        ->where('a.id', '=', $search)
                        ->orWhere('c.title', 'like', '%' . $search . '%')
                        ->orWhere('d.title', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('Tbl_a_group_auth AS a')->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                                ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'a.user_id')
                                ->leftJoin('tbl_a_modules AS e', 'e.id', '=', 'd.module_id')
                                ->where('a.id', '=', $search)
                                ->orWhere('c.title', 'like', '%' . $search . '%')
                                ->orWhere('d.title', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::table('Tbl_a_group_auth AS a')
                        ->select('a.*', 'c.id AS group_id', 'c.title AS group_name', 'd.id AS user_id', 'd.title AS user_name', 'd.path AS user_path', 'd.controller AS user_controller', 'd.method AS user_method', 'd.is_active AS user_status', 'e.id AS module_id', 'e.name AS module_name')
                        ->leftJoin('tbl_a_groups AS c', 'c.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'a.user_id')
                        ->leftJoin('tbl_a_modules AS e', 'e.id', '=', 'd.module_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('Tbl_a_group_auth AS a')->count();
            }
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
                        'user_name' => $value->user_name,
                        'user_path' => $value->user_path,
                        'user_controller' => $value->user_controller,
                        'user_method' => $value->user_method,
                        'user_id' => $value->user_id,
                        'group_id' => $value->group_id,
                        'group_name' => $value->group_name,
                        'module_id' => $value->module_id,
                        'module_name' => $value->module_name,
                        'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="is_allowed" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'is_public' => '<input type="checkbox"' . $is_public . ' name="is_public" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/group_user/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/group_user/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/group_user/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
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

    public function get_list_menu(Request $request) {
        if (isset($request) && !empty($request)) {
            $conditions = [['a.module_id', '=', 2]];
            if (isset($request->type) && $request->type == 'basic') {
                $conditions = [['a.is_basic', '=', 1], ['a.module_id', '=', 2]];
            }
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
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                        ->where($conditions)
                        ->orWhere('b.url', 'like', '%' . $search . '%')
                        ->orWhere('c.name', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_user_menus AS a')
                                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                                ->leftJoin('tbl_a_users AS d', 'd.id', '=', 'b.user_id')
                                ->where($conditions)
                                ->orWhere('b.url', 'like', '%' . $search . '%')
                                ->orWhere('c.name', 'like', '%' . $search . '%')
                                ->orderBy('a.id', 'ASC')->count();
            } else {
                $data = DB::table('tbl_a_user_menus AS a')
                        ->select('a.id', 'a.title', 'a.icon', 'a.path', 'a.badge', 'a.badge_value', 'a.level', 'a.rank', 'a.is_badge', 'a.is_open', 'a.is_active', 'c.id AS module_id', 'c.name AS module_name')
                        ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                        ->where($conditions)
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_user_menus AS a')
                                ->leftJoin('tbl_a_modules AS c', 'c.id', '=', 'a.module_id')
                                ->where($conditions)->count();
            }
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $action = '<input type="checkbox" name="is_menu_allowed[]" class="make-switch is_menu_allowed" data-size="small" value="' . base64_encode($value->id) . '">';
                    if (isset($request->type) && $request->type == 'basic') {
                        $action = '<input type="checkbox" name="is_menu_allowed[]" class="make-switch is_menu_allowed" checked disabled data-size="small" value="' . base64_encode($value->id) . '">';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'name' => $value->title,
                        'path' => $value->path,
                        'level' => $value->level,
                        'rank' => $value->rank,
                        'module_name' => $value->module_name,
                        'action' => $action
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

    public function get_list_permission(Request $request) {
        if (isset($request) && !empty($request)) {
            $conditions = [['a.is_active', '=', 1], ['a.module_id', '=', 2]];
            if (isset($request->type) && $request->type == 'basic') {
                $conditions = [['a.is_basic', '=', 1], ['a.module_id', '=', 2]];
            }
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
                $data = DB::table('tbl_a_permissions AS a')
                        ->select('a.*', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where($conditions)
                        ->orWhere('a.id', '=', $search)
                        ->orWhere('a.title', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_permissions AS a')
                                ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                                ->where($conditions)
                                ->orWhere('a.id', '=', $search)
                                ->orWhere('a.title', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::table('tbl_a_permissions AS a')
                        ->select('a.*', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where($conditions)
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_permissions AS a')
                                ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                                ->where($conditions)->count();
            }
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $action = '<input type="checkbox" name="is_permission_allowed[]" class="make-switch is_permission_allowed" data-size="small" value="' . base64_encode($value->id) . '">';
                    if (isset($request->type) && $request->type == 'basic') {
                        $action = '<input type="checkbox" name="is_permission_allowed[]" class="make-switch is_permission_allowed" checked disabled data-size="small" value="' . base64_encode($value->id) . '">';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'title' => $value->title,
                        'path' => $value->path,
                        'controller' => $value->controller,
                        'method' => $value->method,
                        'module_name' => $value->module_name,
                        'action' => $action
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

    public function insert_auth(Request $request) {
        $data = $request->json()->all();
        $response = false;
        if (isset($data) && !empty($data)) {
            if (isset($data['group_id']) && !empty($data['group_id'])) {
                $group = [];
                $is_ok = [];
                sort($data['user_id']);
                foreach ($data['group_id'] AS $keyword => $value) {
                    $user_id = [];
                    foreach ($data['user_id'] AS $key => $val) {
                        $user_id[] = [
                            'group_id' => (int) $value,
                            'user_id' => (int) $val,
                            'is_public' => $data['is_public'],
                            'is_allowed' => $data['is_allowed'],
                            'is_active' => $data['is_active'],
                            'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                            'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                            'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                            'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                        ];
                    }
                    $response = DB::table('Tbl_a_group_auth')->insert($user_id);
                    if ($response) {
                        $is_ok[] = [1];
                    }
                }
            }
            if ($is_ok == 1) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully insert data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed insert data.', 'valid' => false]);
            }
        }
    }

    public function update_auth(Request $request, $pr_id = null) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $id = base64_decode($pr_id);
            switch ($data['action']) {
                case 'is_active':
                    $update_data = [
                        'is_active' => $data['is_active'],
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
                default:
                    $update_data = [
                        'title' => $data['title'],
                        'path' => $data['path'],
                        'controller' => $data['controller'],
                        'method' => $data['method'],
                        'module_id' => $data['module_id'],
                        'description' => $data['description'],
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::table('Tbl_a_group_auth')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

}
