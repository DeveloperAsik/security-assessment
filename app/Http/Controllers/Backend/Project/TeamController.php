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
use App\Helpers\MyHelper;
use App\Models\Tables\Assessment\Tbl_a_project_teams;

/**
 * Description of TeamController
 *
 * @author User
 */
class TeamController extends Controller {

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
                'title' => 'Team List',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/teams/view'
            ],
            [
                'id' => 3,
                'title' => 'Create new Project Team',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
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
                'title' => 'Team List',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/project/teams/view'
            ],
            [
                'id' => 3,
                'title' => 'Update Team List',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $project_teams = Tbl_a_project_teams::get_by_id($id);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', 'project_teams'));
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
                'title' => 'Team List',
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
                $data = DB::connection('mysql_assessment')->table('tbl_a_project_teams AS a')
                        ->where('a.id', '=', $search)
                        ->orWhere('a.title', 'like', '%' . $search . '%')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::connection('mysql_assessment')->table('tbl_a_project_teams AS a')->where('a.id', '=', $search)
                                ->orWhere('a.title', 'like', '%' . $search . '%')->count();
            } else {
                $data = DB::connection('mysql_assessment')->table('tbl_a_project_teams AS a')
                        ->orderBy('a.id', 'ASC')
                        ->offset($offset)
                        ->limit($limit)
                        ->get();
                $total_rows = DB::connection('mysql_assessment')->table('tbl_a_project_teams AS a')->count();
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
                        'code' => $value->code,
                        'name' => $value->name,
                        'email' => $value->email,
                        'phone_number' => $value->phone_number,
                        'description' => $value->description,
                        'status' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/teams/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/teams/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/project/teams/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
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
                'code' => $data['code'],
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'description' => $data['description'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'created_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'created_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s'),
                'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
            ];
            $response = DB::connection('mysql_assessment')->table('tbl_a_project_teams')->insert($param);
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
                        'code' => $data['code'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone_number' => $data['phone_number'],
                        'description' => $data['description'],
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::connection('mysql_assessment')->table('tbl_a_project_teams')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

}
