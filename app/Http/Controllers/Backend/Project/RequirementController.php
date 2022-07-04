<?php

namespace App\Http\Controllers\Backend\Project;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tables\Tbl_user_a_groups;

/**
 * Description of RequirementController
 *
 * @author User
 */
class RequirementController extends Controller {

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
                'title' => 'Project list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/view'
            ],
            [
                'id' => 3,
                'title' => 'Project create new',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/project/create'
            ]
        ];
        $modules = Tbl_user_a_modules::get_all($request);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'modules'));
    }

    public function edit(Request $request, $id = null) {
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
                'title' => 'Project list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/view'
            ],
            [
                'id' => 3,
                'title' => 'Project edit',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/project/edit'
            ]
        ];
        $modules = Tbl_user_a_groups::fnGetModules($request);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'modules'));
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
                'title' => 'Project list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/view'
            ],
            [
                'id' => 3,
                'title' => 'Project View list',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/project/view'
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
                $data = DB::connection('mysql_assessment')->table('tbl_a_projects AS a')
                        ->select('a.id', 'a.code AS project_code', 'a.name AS project_name', 'a.description AS project_description', 'a.is_active AS project_active_status', 'b.id AS project_detail_id', 'b.text', 'b.version', 'b.project_url', 'b.repository_link', 'b.documentation_file', 'b.user_manual', 'c.id AS team_id', 'c.code AS team_code', 'c.name AS team_name', 'c.description AS team_description', 'c.email AS team_email', 'c.phone_number AS team_phone_number', 'd.id as project_type_id', 'd.name AS project_type_name')
                        ->leftJoin('tbl_a_project_details AS b', 'b.id', '=', 'a.project_detail_id')
                        ->leftJoin('tbl_a_project_teams AS c', 'c.id', '=', 'a.project_team_id')
                        ->leftJoin('tbl_a_project_types AS d', 'd.id', '=', 'a.project_type_id')
                        ->where('a.is_active', '=', 1)
                        ->orWhere('a.code', 'like', '%' . $search . '%')
                        ->orWhere('a.name', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::connection('mysql_assessment')->table('tbl_a_projects AS a')->leftJoin('tbl_a_project_details AS b', 'b.id', '=', 'a.project_detail_id')
                                ->leftJoin('tbl_a_project_teams AS c', 'c.id', '=', 'a.project_team_id')
                                ->leftJoin('tbl_a_project_types AS d', 'd.id', '=', 'a.project_type_id')
                                ->where('a.is_active', '=', 1)
                                ->orWhere('a.code', 'like', '%' . $search . '%')
                                ->orWhere('a.name', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::connection('mysql_assessment')->table('tbl_a_projects AS a')
                        ->select('a.id', 'a.code AS project_code', 'a.name AS project_name', 'a.description AS project_description', 'a.is_active AS project_active_status', 'b.id AS project_detail_id', 'b.text', 'b.version', 'b.project_url', 'b.repository_link', 'b.documentation_file', 'b.user_manual', 'c.id AS team_id', 'c.code AS team_code', 'c.name AS team_name', 'c.description AS team_description', 'c.email AS team_email', 'c.phone_number AS team_phone_number', 'd.id as project_type_id', 'd.name AS project_type_name')
                        ->leftJoin('tbl_a_project_details AS b', 'b.id', '=', 'a.project_detail_id')
                        ->leftJoin('tbl_a_project_teams AS c', 'c.id', '=', 'a.project_team_id')
                        ->leftJoin('tbl_a_project_types AS d', 'd.id', '=', 'a.project_type_id')
                        ->where('a.is_active', '=', 1)
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::connection('mysql_assessment')->table('tbl_a_projects AS a')->count();
            }
            if (isset($data) && !empty($data)) {
                $arr = array();
                foreach ($data AS $keyword => $value) {
                    $is_active = '';
                    if ($value->project_active_status == 1) {
                        $is_active = ' checked';
                    }
                    $arr[] = [
                        'id' => $value->id,
                        'project_code' => $value->project_code,
                        'project_name' => $value->project_name,
                        'project_active_status' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
                        'version' => $value->version,
                        'project_url' => $value->project_url,
                        'documentation_file' => $value->documentation_file,
                        'user_manual' => $value->user_manual,
                        'team_code' => $value->team_code,
                        'team_name' => $value->team_name,
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="fas fa-plus-circle"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="far fa-trash-alt"></i></a></button>
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
