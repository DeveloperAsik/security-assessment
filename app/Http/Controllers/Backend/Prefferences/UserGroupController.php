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
 * Description of UsersController
 *
 * @author elitebook
 */
class UserGroupController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_a_users';

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
                'title' => 'User Groups list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/user/groups/view'
            ],
            [
                'id' => 3,
                'title' => 'User Groups create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Create new <b>User Groups</b> master data management page',
            'create_page' => [
                'title' => 'click to open user group list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/user/groups/view'
            ]
        ];
        $param_group = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.description', 'a.rank', 'a.is_menu', 'a.is_active', 'b.id AS parent_id', 'b.name AS parent_name'],
            'from' => 'tbl_a_groups as a',
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
        $param_users = [
            'table_name' => 'tbl_a_users',
            'from' => 'tbl_a_users as a',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $users = $this->MY_Model->find($request, 'all', $param_users);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'groups', 'users'));
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
        $_config = [
            'title_for_header' => '<b>User Groups</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new user group',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/user/groups/create'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', '_config'));
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
        $params = [
            'table_name' => 'tbl_b_user_groups',
            'from' => 'tbl_b_user_groups as a',
            'conditions' => [
                ['a.id', '=', $id]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $userGroup = $this->MY_Model->find($request, 'all', $params);
        $param_group = [
            'table_name' => 'tbl_a_groups',
            'select' => ['a.id', 'a.name', 'a.description', 'a.rank', 'a.is_menu', 'a.is_active', 'b.id AS parent_id', 'b.name AS parent_name'],
            'from' => 'tbl_a_groups as a',
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
        $param_users = [
            'table_name' => 'tbl_a_users',
            'from' => 'tbl_a_users as a',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $users = $this->MY_Model->find($request, 'all', $param_users);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', 'userGroup', 'groups', 'users'));
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
                'table_name' => 'tbl_b_user_groups',
                'from' => 'tbl_b_user_groups as a',
                'select' => [
                    'a.*',
                    'b.name AS group_name',
                    'c.user_name', 'c.first_name', 'c.last_name', 'c.email'
                ],
                'join' => [
                    'leftJoin' => [
                        ['tbl_a_groups AS b', 'b.id', '=', 'a.group_id'],
                        ['tbl_a_users AS c', 'c.id', '=', 'a.user_id']
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
                    $is_active = '';
                    if ($value->is_active == 1) {
                        $is_active = ' checked';
                    }
                    $arrData[] = [
                        'id' => $i,
                        'user_id' => $value->user_id,
                        'user_name' => $value->user_name,
                        'email' => $value->email,
                        'group_id' => $value->group_id,
                        'group_name' => $value->group_name,
                        'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
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
            $params = [
                'table_name' => 'tbl_b_user_groups',
                'from' => 'tbl_b_user_groups as a',
                'conditions' => [
                    'where' => [
                        ['a.user_id', '=', $data['user']],
                        ['a.group_id', '=', $data['group']]
                    ]
                ]
            ];
            $user_exist = $this->MY_Model->find($request, 'first', $params);
            if (isset($user_exist['data']) && !empty($user_exist['data'])) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed insert data. user already exist or this user group already used.', 'valid' => false]);
            } else {
                $user_detail = [
                    'user_id' => $data['user_id'],
                    'group_id' => $data['group_id'],
                    'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                    'created_by' => $this->__user_id,
                    'created_date' => MyHelper::getDateNow(),
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                $response = DB::table('tbl_a_users')->insertGetId($user_detail);
            }
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
                'user_id' => $data['user_id'],
                'group_id' => $data['group_id'],
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
                    $response = DB::table('tbl_b_group_permissions')->insert($user_id);
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
            $response = DB::table('tbl_b_group_permissions')->where('id', '=', (int) $id)->update($update_data);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update data.', 'valid' => false]);
            }
        }
    }

    public function view_group(Request $request) {
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
        $_config = [
            'title_for_header' => '<b>User Groups</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new user group',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/user/groups/create'
            ]
        ];
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', '_config'));
    }

}
