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
use App\Helpers\MyHelper;
use App\Models\Tables\Core\Tbl_a_permissions;
use App\Models\Tables\Core\Tbl_a_modules;

/**
 * Description of PermissionController
 *
 * @author I00396.ARIF
 */
class PermissionController extends Controller {

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
                'title' => 'Permission list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/permission/view'
            ],
            [
                'id' => 3,
                'title' => 'Permission create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $modules = Tbl_a_modules::get_all($request)['data'];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'modules'));
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
                'title' => 'Permission list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/permission/view'
            ],
            [
                'id' => 3,
                'title' => 'Permission edit',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $permission = Tbl_a_permissions::get_by_id($id);
        $modules = Tbl_a_modules::get_all($request)['data'];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'permission', 'modules'));
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
                'title' => 'Permission list',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs'));
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
                $data = DB::table('tbl_a_permissions AS a')
                        ->select('a.*', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->where('a.id', '=', $search)
                        ->orWhere('a.title', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_permissions AS a')
                                ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                                ->where('a.id', '=', $search)
                                ->orWhere('a.title', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::table('tbl_a_permissions AS a')
                        ->select('a.*', 'b.id AS module_id', 'b.name AS module_name')
                        ->leftJoin('tbl_a_modules AS b', 'b.id', '=', 'a.module_id')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::table('tbl_a_permissions AS a')->count();
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
                        'title' => $value->title,
                        'path' => $value->path,
                        'controller' => $value->controller,
                        'method' => $value->method,
                        'module_name' => $value->module_name,
                        'status' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/permission/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/permission/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/permission/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
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
            $param = [
                'title' => $data['title'],
                'path' => $data['path'],
                'controller' => $data['controller'],
                'method' => $data['method'],
                'module_id' => (int) $data['module_id'],
                'description' => $data['description'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
            ];
            $response = DB::table('tbl_a_permissions')->insert($param);
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
            $response = DB::table('tbl_a_permissions')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

}