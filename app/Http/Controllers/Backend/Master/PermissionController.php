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
 * Description of PermissionController
 *
 * @author I00396.ARIF
 */
class PermissionController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_a_permissions';

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
                'title' => 'Permission list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/master/permission/view'
            ],
            [
                'id' => 3,
                'title' => 'Permission create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Create new <b>Permission</b> master data management page',
            'create_page' => [
                'title' => 'click to open permission list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/permission/view'
            ]
        ];
        $params = [
            'table_name' => 'tbl_master_methods',
            'order' => [
                ['a.name', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $methods = $this->MY_Model->find($request, 'list', $params);

        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'methods'));
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
                'path' => config('app.base_extraweb_uri') . '/master/permission/view'
            ],
            [
                'id' => 3,
                'title' => 'Permission edit',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Update <b>Permission</b> master data management page',
            'create_page' => [
                'title' => 'click to open permission list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/permission/view'
            ]
        ];
        $params = [
            'table_name' => 'tbl_master_methods',
            'order' => [
                ['a.name', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $methods = $this->MY_Model->find($request, 'list', $params);
        $param_permission = [
            'table_name' => $this->table_default,
            'conditions' => [
                'where' => [
                    ['a.id', '=', $id]
                ]
            ],
            'order' => [
                ['a.name', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $permission = $this->MY_Model->find($request, 'first', $param_permission);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'methods', 'permission'));
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
        $_config = [
            'title_for_header' => '<b>Permission</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new permission',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/permission/create'
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
                        ['a.path', 'like', '%' . $search . '%'],
                        ['a.controller', 'like', '%' . $search . '%'],
                        ['a.method', 'like', '%' . $search . '%']
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
                    $is_basic = '';
                    if ($value->is_basic == 1) {
                        $is_basic = ' checked';
                    }
                    $is_public = '';
                    if ($value->is_public == 1) {
                        $is_public = ' checked';
                    }
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arrData[] = [
                        'id' => $i,
                        'name' => $value->name,
                        'path' => $value->path,
                        'controller' => $value->controller,
                        'method' => $value->method,
                        'description' => $value->description,
                        'basic' => '<input type="checkbox"' . $is_basic . ' name="is_basic" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'public' => '<input type="checkbox"' . $is_public . ' name="is_public" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'status' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small" data-id="' . base64_encode($value->id) . '">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/master/permission/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/master/permission/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="fas fa-xmark"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/master/permission/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="far fa-trash-alt"></i></a></button>
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
            $arrParam = [];
            if (isset($data['method']) && !empty($data['method'])) {
                foreach ($data['method'] AS $key => $value) {
                    $params = [
                        'table_name' => 'tbl_master_methods',
                        'conditions' => [
                            'where' => [
                                ['a.name', 'like', '%' . $value . '%']
                            ]
                        ],
                        'order' => [
                            ['a.id', 'asc']
                        ]
                    ];
                    $exist_method = $this->MY_Model->findOne($request, $params);
                    $sufix = '';
                    if (isset($exist_method['data']->param) && !empty($exist_method['data']->param)) {
                        $sufix = $exist_method['data']->param;
                    }
                    $arrParam[] = [
                        'name' => $data['name'] . '/' . $value . '/' . $exist_method['data']->param,
                        'path' => $data['path'] . '/' . $value . '/' . $exist_method['data']->param,
                        'controller' => $data['controller'],
                        'method' => $value,
                        'description' => $data['description'],
                        'is_basic' => isset($data['is_basic']) ? 1 : 0,
                        'is_public' => isset($data['is_public']) ? 1 : 0,
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'created_by' => $this->__user_id,
                        'created_date' => MyHelper::getDateNow(),
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                }
            }
            $response = DB::table($this->table_default)->insert($arrParam);
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
                case 'is_basic':
                    $update_data = [
                        'is_basic' => $data['is_basic'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    break;
                case 'is_public':
                    $update_data = [
                        'is_public' => $data['is_public'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    break;
                case 'is_active':
                    $update_data = [
                        'is_active' => $data['is_active'],
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    break;
                default:
                    $update_data = [
                        'name' => $data['name'],
                        'path' => $data['path'],
                        'controller' => $data['controller'],
                        'method' => $data['method'],
                        'description' => $data['description'],
                        'is_basic' => isset($data['is_basic']) ? 1 : 0,
                        'is_public' => isset($data['is_public']) ? 1 : 0,
                        'is_active' => isset($data['is_active']) ? 1 : 0,
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
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
