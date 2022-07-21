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
 * Description of MenuPermissionController
 *
 * @author User
 */
class MenuPermissionController extends Controller {

    //put your code here
    protected $MY_Model;
    protected $table_default = 'tbl_b_menu_permission';

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
                'title' => 'Menu Permissions list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/view'
            ],
            [
                'id' => 3,
                'title' => 'Menu Permissions create new',
                'icon' => '',
                'arrow' => false,
                'path' => '#'
            ]
        ];
        $_config = [
            'title_for_header' => 'Assign <b>Permissions</b> access to <b>Menu</b>',
            'create_page' => [
                'title' => 'click to open user menu list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/view'
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
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'modules', 'groups'));
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
                'title' => 'Menu Permission List',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/view'
            ]
        ];
        $_config = [
            'title_for_header' => '<b>Menu Permissions</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new user menu',
                'icon' => '<i class="fas fa-square-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/create'
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
                'title' => 'Menu Permission',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/view'
            ],
            [
                'id' => 3,
                'title' => 'Menu Edit',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/edit/' . $id
            ]
        ];
        $_config = [
            'title_for_header' => 'Update <b>Menu Permissions</b> access',
            'create_page' => [
                'title' => 'click to open user menu list page',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/prefferences/menu/permissions/view'
            ]
        ];
        $params = [
            'table_name' => $this->table_default,
            'select' => [
                'a.*',
                'b.name AS menu_name', 'b.path', 'b.content_path',
                'c.id AS parent_menu_id', 'c.name AS parent_menu_name'
            ],
            'conditions' => [
                'where' => [
                    ['a.id', '=', $id]
                ]
            ],
            'join' => [
                'leftJoin' => [
                    ['tbl_a_menus AS b', 'b.id', '=', 'a.menu_id'],
                    ['tbl_a_menus AS c', 'c.id', '=', 'b.parent_id']
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ]
        ];
        $userMenu = $this->MY_Model->find($request, 'first', $params);
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
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'groups', 'userMenu', 'modules'));
    }

    public function get_list(Request $request) {
        if (isset($request) && !empty($request)) {
            if (isset($request->a) && $request->a == 'option') {
                $param_menu = [
                    'table_name' => 'tbl_a_menus',
                    'select' => [
                        'a.id AS menu_id', 'a.name AS menu_name', 'a.path AS menu_path', 'a.content_path AS menu_content_path', 'a.level AS menu_level',
                        'b.id AS parent_menu_id', 'b.name AS parent_menu_name', 'b.path AS parent_menu_path'
                    ],
                    'join' => [
                        'leftJoin' => [
                            ['tbl_a_menus AS b', 'b.id', '=', 'a.parent_id']
                        ]
                    ],
                    'order' => [
                        ['a.id', 'asc']
                    ]
                ];
                $menus = $this->MY_Model->find($request, 'all', $param_menu);
                $strOption = '';
                if (isset($menus['data']) && !empty($menus['data'])) {
                    foreach ($menus['data'] AS $keyword => $value) {
                        $isroot = isset($value->parent_menu_name) ? $value->parent_menu_name : 'root';
                        $strOption .= '<option value="' . $value->menu_id . '">' . $isroot . ' - <b>' . $value->menu_name . '</b>' . '</option>';
                    }
                }
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching data', 'valid' => true, 'data' => $strOption]);
            } else {
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
                            ['a.is_allowed', 'like', '%' . $search . '%'],
                            ['a.is_active', 'like', '%' . $search . '%'],
                            ['b.name', 'like', '%' . $search . '%'],
                            ['b.path', 'like', '%' . $search . '%'],
                            ['b.content_path', 'like', '%' . $search . '%'],
                            ['c.name', 'like', '%' . $search . '%'],
                            ['d.name', 'like', '%' . $search . '%']
                        ]
                    ];
                } else {
                    $conditions = [];
                }
                $params = [
                    'table_name' => $this->table_default,
                    'select' => [
                        'a.*',
                        'b.name AS menu_name', 'b.path AS menu_path', 'b.content_path AS menu_content_path', 'b.level AS menu_level',
                        'c.name AS module_name',
                        'd.name AS group_name',
                        'e.id AS parent_menu_id', 'e.name AS parent_menu_name', 'e.path AS parent_menu_path'
                    ],
                    'join' => [
                        'leftJoin' => [
                            ['tbl_a_menus AS b', 'b.id', '=', 'a.menu_id'],
                            ['tbl_a_modules AS c', 'c.id', '=', 'a.module_id'],
                            ['tbl_a_groups AS d', 'd.id', '=', 'a.group_id'],
                            ['tbl_a_menus AS e', 'e.id', '=', 'b.parent_id']
                        ]
                    ],
                    'conditions' => $conditions,
                    'order' => [
                        ['b.parent_id', 'asc'],
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
                    $pcolor_ = '';
                    foreach ($data['data'] AS $keyword => $value) {
                        $rand_color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
                        $is_allowed = '';
                        if ($value->is_allowed == 1) {
                            $is_allowed = ' checked';
                        }
                        $is_active = '';
                        if ($value->is_active == 1) {
                            $is_active = ' checked';
                        }
                        ${"pcolor_" . $value->id} = $rand_color;
                        $arrData[] = [
                            'id' => $i,
                            'parent' => isset($value->parent_menu_name) ? '<span style="color:#fff;padding:0px 4px 0px 4px;background-color:' . ${"pcolor_" . $value->parent_menu_id} . ' ">#' . $value->parent_menu_id . ' ' . $value->parent_menu_name . '</span>' : '<span style="padding:0px 4px 0px 4px;background-color:#ccc;">system</span>',
                            'menu_name' => '<span style="color:#fff;padding:0px 4px 0px 4px;background-color:' . ${"pcolor_" . $value->id} . ' ">' . $value->menu_name . '</span>',
                            'menu_path' => $value->menu_path,
                            'menu_content_path' => $value->menu_content_path,
                            'menu_level' => $value->menu_level,
                            'module_name' => $value->module_name,
                            'group_name' => $value->group_name,
                            'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="is_allowed" class="make-switch" data-size="small">',
                            'is_active' => '<input type="checkbox"' . $is_active . ' name="is_active" class="make-switch" data-size="small">',
                            'action' => '<div class="btn-menu">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/prefferences/menu/permissions/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
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
    }

    public function insert(Request $request) {
        $data = $request->json()->all();
        $response = false;
        if (isset($data) && !empty($data)) {
            $arrDataCorrect = [];
            if (isset($data['menu_id']) && !empty($data['menu_id'])) {
                foreach ($data['menu_id'] AS $k => $v) {
                    $params = [
                        'table_name' => 'tbl_b_menu_permissions',
                        'conditions' => [
                            'where' => [
                                ['a.module_id', '=', $data['module_id']],
                                ['a.menu_id', '=', $data['menu_id']],
                                ['a.group_id', '=', $data['group_id']]
                            ]
                        ]
                    ];
                    $menuPermission_exist = $this->MY_Model->find($request, 'first', $params);
                    if ($menuPermission_exist['data'] == null) {
                        $arrDataCorrect[] = [
                            'module_id' => (int) $data['module_id'],
                            'menu_id' => (int) $data['menu_id'],
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
            $response = DB::table('tbl_b_menu_permissions')->insertGetId($arrDataCorrect);
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
            $arrDataCorrect = [];
            if (isset($data['menu_id']) && !empty($data['menu_id'])) {
                foreach ($data['menu_id'] AS $k => $v) {
                    $params = [
                        'table_name' => 'tbl_b_menu_permission',
                        'conditions' => [
                            'where' => [
                                ['a.module_id', '=', $data['module_id']],
                                ['a.menu_id', '=', $data['menu_id']],
                                ['a.group_id', '=', $data['group_id']]
                            ]
                        ]
                    ];
                    $menuPermission_exist = $this->MY_Model->find($request, 'first', $params);
                    if ($menuPermission_exist['data'] == null) {
                        $arrDataCorrect[] = [
                            'module_id' => (int) $data['module_id'],
                            'menu_id' => (int) $data['menu_id'],
                            'permission_id' => (int) $v,
                            'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                            'updated_by' => $this->__user_id,
                            'updated_date' => MyHelper::getDateNow()
                        ];
                    } else {
                        return MyHelper::_set_response('json', ['code' => 500, 'message' => 'failed update data. credentials already exist or this already used.', 'valid' => false]);
                    }
                }
            }
            $response = DB::table('tbl_b_menu_permissions')->insertGetId($arrDataCorrect);
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully insert data', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 500, 'message' => 'failed insert data. user already exist or this user email already used.', 'valid' => false]);
            }
        }
    }

}
