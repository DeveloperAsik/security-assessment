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
use App\Http\Middleware\TokenUser;
use Illuminate\Support\Facades\DB;
use App\Models\MY_Model;

/**
 * Description of GroupPermissionController
 *
 * @author User
 */
class GroupPermissionController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_b_group_permissions';

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
                'title' => 'Group Permissions list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/view'
            ],
            [
                'id' => 3,
                'title' => 'Group Permissions create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Assign <b>Permissions</b> access to <b>Group</b>',
            'create_page' => [
                'title' => 'click to open user group list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/view'
            ]
        ];
        $param_group = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.description', 'a.rank', 'a.is_menu', 'a.is_active', 'b.id AS parent_id', 'b.name AS parent_name'],
            'conditions' => [
                'where' => [
                    ['a.is_menu', '=', 1]
                ]
            ],
            'join' => [
                'leftJoin' => [
                    ['tbl_a_groups as b', 'b.id', '=', 'a.parent_id']
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
        ];
        $groups = $this->MY_Model->find($request, 'all', $param_group);
        $param_modules = [
            'table_name' => 'tbl_a_modules',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $modules = $this->MY_Model->find($request, 'all', $param_modules);
        $param_permissions = [
            'table_name' => 'tbl_a_permissions',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $permissions = $this->MY_Model->find($request, 'all', $param_permissions);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'groups', 'modules', 'permissions'));
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
                'title' => 'Group Permission List',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/view'
            ]
        ];
        $_config = [
            'title_for_header' => '<b>Group Permissions</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new user group',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/create'
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
                'title' => 'Group Permission',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/view'
            ],
            [
                'id' => 3,
                'title' => 'Group Edit',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/edit/' . $id
            ]
        ];
        $_config = [
            'title_for_header' => 'Update <b>Permissions</b> access to <b>Group</b>',
            'create_page' => [
                'title' => 'click to open user group list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/group/permissions/view'
            ]
        ];
        $params = [
            'table_name' => $this->table_default,
            'conditions' => [
                'where' => [
                    ['a.id', '=', $id]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $userGroup = $this->MY_Model->find($request, 'first', $params);
        $param_group = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.description', 'a.rank', 'a.is_menu', 'a.is_active', 'b.id AS parent_id', 'b.name AS parent_name'],
            'conditions' => [
                'where' => [
                    ['a.is_menu', '=', 1]
                ]
            ],
            'join' => [
                'leftJoin' => [
                    ['tbl_a_groups as b', 'b.id', '=', 'a.parent_id']
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
        ];
        $groups = $this->MY_Model->find($request, 'all', $param_group);
        $param_modules = [
            'table_name' => 'tbl_a_modules',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $modules = $this->MY_Model->find($request, 'all', $param_modules);
        $param_permissions = [
            'table_name' => 'tbl_a_permissions',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $permissions = $this->MY_Model->find($request, 'all', $param_permissions);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs','_config', 'userGroup', 'groups', 'modules', 'permissions'));
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
                        ['a.user_id', 'like', '%' . $search . '%'],
                        ['a.group_id', 'like', '%' . $search . '%'],
                        ['b.name', 'like', '%' . $search . '%'],
                        ['c.user_name', 'like', '%' . $search . '%'],
                        ['c.first_name', 'like', '%' . $search . '%'],
                        ['c.last_name', 'like', '%' . $search . '%'],
                        ['c.email', 'like', '%' . $search . '%']
                    ]
                ];
            } else {
                $conditions = [];
            }
            $params = [
                'table_name' => $this->table_default,
                'select' => [
                    'a.*',
                    'b.name AS group_name',
                    'c.name AS module_name',
                    'd.name AS permission_name', 'd.path AS permission_path', 'd.controller AS permission_controller', 'd.method AS permission_method'
                ],
                'join' => [
                    'leftJoin' => [
                        ['tbl_a_groups AS b', 'b.id', '=', 'a.group_id'],
                        ['tbl_a_modules AS c', 'c.id', '=', 'a.module_id'],
                        ['tbl_a_permissions AS d', 'd.id', '=', 'a.permission_id']
                    ]
                ],
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
                    $is_allowed = '';
                    if ($value->is_allowed == 1) {
                        $is_allowed = ' checked';
                    }
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arrData[] = [
                        'id' => $i,
                        'group_name' => $value->group_name,
                        'module_name' => $value->module_name,
                        'permission_name' => $value->permission_name,
                        'permission_path' => $value->permission_path,
                        'permission_controller' => $value->permission_controller,
                        'permission_method' => $value->permission_method,
                        'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="is_allowed" class="make-switch" data-size="small">',
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
                        'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/group/permissions/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
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
        }
    }

    public function insert(Request $request) {
        $data = $request->json()->all();
        $response = false;
        if (isset($data) && !empty($data)) {
            $arrDataCorrect = [];
            if (isset($data['permission_id']) && !empty($data['permission_id'])) {
                foreach ($data['permission_id'] AS $k => $v) {
                    $params = [
                        'table_name' => 'tbl_b_group_permissions',
                        'conditions' => [
                            'where' => [
                                ['a.module_id', '=', $data['module_id']],
                                ['a.group_id', '=', $data['group_id']],
                                ['a.permission_id', '=', $data['permission_id']]
                            ]
                        ]
                    ];
                    $groupPermission_exist = $this->MY_Model->find($request, 'first', $params);
                    if ($groupPermission_exist['data'] == null) {
                        $arrDataCorrect[] = [
                            'module_id' => (int) $data['module_id'],
                            'group_id' => (int) $data['group_id'],
                            'permission_id' => (int) $v,
                            'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                            'created_by' => $this->__user_id,
                            'created_date' => MyHelper::getDateNow(),
                            'updated_by' => $this->__user_id,
                            'updated_date' => MyHelper::getDateNow()
                        ];
                    }
                }
            }
            $response = DB::table('tbl_b_group_permissions')->insertGetId($arrDataCorrect);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully insert data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed insert data. user already exist or this user email already used.', 'valid' => false]);
            }
        }
    }

    public function update(Request $request, $pr_id = null) {
        $data = $request->json()->all();
        $id = base64_decode($pr_id);
        if (isset($data) && !empty($data)) {
            $param_group_permission = [
                'module_id' => (int) $data['module_id'],
                'group_id' => (int) $data['group_id'],
                'permission_id' => (int) $data['permission_id'],
                'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                'updated_by' => $this->__user_id,
                'updated_date' => MyHelper::getDateNow(),
            ];
            $result = DB::table('tbl_b_group_permissions')->where('a.id', '=', $id)->update($param_group_permission);
            if ($result) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update user profile.', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 500, 'message' => 'Failed insert new permission data.', 'valid' => false]);
            }
        } else {
            return MyHelper::_set_response('json', ['code' => 500, 'message' => 'Failed insert new permission data.', 'valid' => false]);
        }
    }

}
