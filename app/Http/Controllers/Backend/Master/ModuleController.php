<?php

namespace App\Http\Controllers\Backend\Master;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\MyHelper;
use App\Models\MY_Model;

/**
 * Description of ModulesController
 *
 * @author User
 */
class ModuleController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_a_modules';

    public function __construct(Request $request, MY_Model $MY_Model) {
        parent::__construct($request);
        $this->MY_Model = $MY_Model;
    }

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
                'title' => 'Module list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/master/module/view'
            ],
            [
                'id' => 3,
                'title' => 'Module create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Create new <b>Module</b> master data management page',
            'create_page' => [
                'title' => 'click to open module list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/module/view'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config'));
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
                'title' => 'Module list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/master/module/view'
            ],
            [
                'id' => 3,
                'title' => 'Module edit',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
         $_config = [
            'title_for_header' => 'Update <b>Module</b> master data management page',
            'create_page' => [
                'title' => 'click to open module list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/module/view'
            ]
        ];
        $params = [
            'table_name' => $this->table_default,
            'conditions' => [
                'where' => [
                    ['a.id', '=', $id]
                ]
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $module = $this->MY_Model->find($request, 'first', $params);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs','_config', 'module'));
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
                'title' => 'Module list',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];

        $_config = [
            'title_for_header' => '<b>Module</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new module',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/module/create'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config'));
    }

    public function get_list(Request $request) {
        if (isset($request) && !empty($request)) {
            $draw = $request->draw;
            $limit = ($request->length) ? $request->length : 10;
            if ($request->length == '-1') {
                $limit = 1000;
            }
            $offset = ($request->start) ? $request->start : 0;
            $search = $request->search['value'];
            if (isset($search) && !empty($search)) {
                $conditions = [
                    'orWhere' => [
                        ['a.name', 'like', '%' . $search . '%'],
                        ['a.alias', 'like', '%' . $search . '%']
                    ]
                ];
            } else {
                $conditions = [];
            }
            $params = [
                'table_name' => $this->table_default,
                'conditions' => $conditions,
                'order' => [
                    ['a.id', 'asc']
                ],
                'limit' => $limit,
                'offset' => $offset,
                'query_param' => config('app.url') . $request->getRequestUri()
            ];
            $data = $this->MY_Model->find($request, 'all', $params);
            if (isset($data['data']) && !empty($data['data'])) {
                $arrData = array();
                if ($offset == 0) {
                    $i = 1;
                } else {
                    $i = ($offset + 1);
                }
                foreach ($data['data'] AS $keyword => $value) {
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arrData[] = [
                        'id' => $i,
                        'name' => $value->name,
                        'alias' => $value->alias,
                        'rank' => $value->rank,
                        'description' => $value->description,
                        'status' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/master/module/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/master/module/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/master/module/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
                      </div>',
                    ];
                    if ($i <= $data['meta']['total']) {
                        $i++;
                    }
                }
                $output = array(
                    'draw' => $draw,
                    'recordsTotal' => $data['meta']['total'],
                    'recordsFiltered' => $data['meta']['total'],
                    'data' => $arrData,
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
                'name' => $data['name'],
                'alias' => $data['alias'],
                'rank' => $data['rank'],
                'description' => $data['description'],
                'is_active' => isset($data['is_active']) ? 1 : 0,
                'created_by' => $this->__user_id,
                'created_date' => MyHelper::getDateNow(),
                'updated_by' => $this->__user_id,
                'updated_date' => MyHelper::getDateNow(),
            ];
            $response = DB::table($this->table_default)->insert($param);
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
                        'name' => $data['name'],
                        'alias' => $data['alias'],
                        'description' => $data['description'],
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => isset($data['created_by']) ? $data['created_by'] : $this->__user_id,
                        'updated_date' => isset($data['created_date']) ? $data['created_date'] : date('Y-m-d H:i:s')
                    ];
                    break;
            }
            $response = DB::table($this->table_default)->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

}
