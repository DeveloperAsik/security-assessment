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
use App\Models\Tables\Core\Tbl_a_user_groups;
use App\Models\Tables\Core\Tbl_a_users;

/**
 * Description of UsergroupController
 *
 * @author User
 */
class UsergroupController extends Controller {

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
                'title' => 'User Group list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user_group/view'
            ],
            [
                'id' => 3,
                'title' => 'User Group create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $users = DB::table('tbl_a_user_groups AS a')
                ->select('a.*', 'b.id as group_id', 'b.title AS group_name', 'c.id AS user_id', 'c.user_name', 'c.first_name', 'c.last_name', 'c.email')
                ->leftJoin('tbl_a_groups AS b', 'b.id', '=', 'a.group_id')
                ->leftJoin('tbl_a_users AS c', 'c.id', '=', 'a.user_id')
                ->where('a.is_active', '=', 1)
                ->orderBy('a.id', 'ASC')
                ->get();
        $groups = Tbl_a_groups::get_all($request)['data'];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'users', 'groups'));
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
                'title' => 'User Group list',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user_group/view'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs'));
    }

    public function edit(Request $request, $pr_id = null) {
        $id = base64_decode($pr_id);
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
                'title' => 'User Group',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user_group/view'
            ],
            [
                'id' => 3,
                'title' => 'User Group Edit',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user_group/edit/' . $id
            ]
        ];
        $group_permission = DB::table('tbl_a_user_groups AS a')
                ->select('a.*', 'b.id as group_id', 'b.title AS group_name', 'c.id AS user_id', 'c.user_name', 'c.first_name', 'c.last_name', 'c.email')
                ->leftJoin('tbl_a_groups AS b', 'b.id', '=', 'a.group_id')
                ->leftJoin('tbl_a_users AS c', 'c.id', '=', 'a.user_id')
                ->where('a.id', '=', $id)
                ->orderBy('a.id', 'ASC')
                ->first();
        $groups = Tbl_a_groups::get_all($request)['data'];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'group_permission', 'groups'));
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
                $data = DB::table('tbl_a_user_groups AS a')
                        ->select('a.*', 'b.id as group_id', 'b.title AS group_name', 'c.id AS user_id', 'c.user_name', 'c.first_name', 'c.last_name', 'c.email')
                        ->leftJoin('tbl_a_groups AS b', 'b.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_users AS c', 'c.id', '=', 'a.user_id')
                        ->where('a.id', '=', $search)
                        ->orWhere('c.title', 'like', '%' . $search . '%')
                        ->orWhere('d.title', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_user_groups AS a')
                                ->select('a.*', 'b.id as group_id', 'b.title AS group_name', 'c.id AS user_id', 'c.user_name', 'c.first_name', 'c.last_name', 'c.email')
                                ->leftJoin('tbl_a_groups AS b', 'b.id', '=', 'a.group_id')
                                ->leftJoin('tbl_a_users AS c', 'c.id', '=', 'a.user_id')
                                ->where('a.id', '=', $search)
                                ->orWhere('c.title', 'like', '%' . $search . '%')
                                ->orWhere('d.title', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::table('Tbl_a_user_groups AS a')
                        ->select('a.*', 'b.id as group_id', 'b.title AS group_name', 'c.id AS user_id', 'c.user_name', 'c.first_name', 'c.last_name', 'c.email')
                        ->leftJoin('tbl_a_groups AS b', 'b.id', '=', 'a.group_id')
                        ->leftJoin('tbl_a_users AS c', 'c.id', '=', 'a.user_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('Tbl_a_user_groups AS a')->count();
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
                        'user_id' => $value->user_id,
                        'user_name' => $value->user_name,
                        'user_email' => $value->email,
                        'group_id' => $value->group_id,
                        'group_name' => $value->group_name,
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/user_group/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/user_group/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/user_group/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
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
            if (isset($data['group_id']) && !empty($data['group_id'])) {
                $group = [];
                $is_ok = [];
                sort($data['user_id']);
                foreach ($data['group_id'] AS $keyword => $value) {
                    $permission_id = [];
                    foreach ($data['user_id'] AS $key => $val) {
                        $permission_id[] = [
                            'group_id' => (int) $value,
                            'user_id' => (int) $val,
                            'is_active' => $data['is_active'],
                            'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                            'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                            'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                            'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                        ];
                    }
                    $response = DB::table('Tbl_a_user_groups')->insert($permission_id);
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
                        'group_id' => (int) $data['group_id'],
                        'user_id' => (int) $data['user_id'],
                        'description' => $data['description'],
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::table('Tbl_a_user_groups')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

}
