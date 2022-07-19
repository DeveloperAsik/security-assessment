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
use App\Models\Tables\Core\Tbl_a_menus;

/**
 * Description of MenuController
 *
 * @author I00396.ARIF
 */
class MenuController extends Controller {

    //put your code here    
    protected $MY_Model;
    protected $table_default = 'tbl_a_menus';

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
                'title' => 'Menu list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/master/menu/view'
            ],
            [
                'id' => 3,
                'title' => 'Create new Menu',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/master/menu/create'
            ]
        ];
        $_config = [
            'title_for_header' => 'Create <b>Menu</b> master data management page',
            'create_page' => [
                'title' => 'click to open form list new menu',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/menu/view'
            ]
        ];
        $param_parents = [
            'table_name' => $this->table_default,
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1],
                    ['a.level', '=', 1]
                ]
            ],
            'order' => [
                ['a.rank', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $parents = $this->MY_Model->find($request, 'all', $param_parents);
        $param_modules = [
            'table_name' => 'tbl_a_modules',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $modules = $this->MY_Model->find($request, 'all', $param_modules);
        $param_groups = [
            'table_name' => 'tbl_a_groups',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1],
                    ['a.is_menu', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $groups = $this->MY_Model->find($request, 'all', $param_groups);
        $param_icon = [
            'table_name' => 'tbl_d_icons',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $icons = $this->MY_Model->find($request, 'all', $param_icon);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'parents', 'groups', 'modules', 'icons'));
    }

    public function edit(Request $request, $tr_id = null) {
        $id = base64_decode($tr_id);
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
                'title' => 'Menu list',
                'icon' => '',
                'arrow' => true,
                'path' => config('app.base_extraweb_uri') . '/master/menu/view'
            ],
            [
                'id' => 3,
                'title' => 'Menu Edit ( id ' . base64_decode($id) . ' )',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/master/menu/edit/' . $id
            ]
        ];
        $_config = [
            'title_for_header' => 'Create <b>Menu</b> master data management page',
            'create_page' => [
                'title' => 'click to open form create new menu',
                'icon' => '<i class="fa-solid fa-list"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/menu/view'
            ]
        ];
        $param_parents = [
            'table_name' => $this->table_default,
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1],
                    ['a.level', '=', 1]
                ]
            ],
            'order' => [
                ['a.rank', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $parents = $this->MY_Model->find($request, 'all', $param_parents);
        $param_module = [
            'table_name' => 'tbl_a_modules',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $modules = $this->MY_Model->find($request, 'all', $param_module);
        $param_icon = [
            'table_name' => 'tbl_d_icons',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $icons = $this->MY_Model->find($request, 'all', $param_icon);
        $param_menu = [
            'table_name' => 'tbl_a_menus',
            'conditions' => [
                'where' => [
                    ['a.id', '=', $id]
                ]
            ],
            'order' => [
                ['a.id', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $menu = $this->MY_Model->find($request, 'all', $param_menu);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumb', '_config', 'parents', 'modules', 'icons', 'menu'));
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
                'id' => 3,
                'title' => 'Menu Access',
                'icon' => '',
                'arrow' => false,
                'path' => config('app.base_extraweb_uri') . '/master/menu/view'
            ]
        ];
        $_config = [
            'title_for_header' => '<b>Menu</b> master data management page',
            'create_page' => [
                'title' => 'click to open form list menu',
                'icon' => '<i class="fa-solid fa-plus"></i>',
                'link' => config('app.base_extraweb_uri') . '/master/menu/create'
            ]
        ];
        $param_modules = [
            'table_name' => 'tbl_a_modules',
            'conditions' => [
                'where' => [
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.rank', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $modules = $this->MY_Model->find($request, 'all', $param_modules);
        $param_groups = [
            'table_name' => 'tbl_a_groups',
            'conditions' => [
                'where' => [
                    ['a.is_menu', '=', 1],
                    ['a.is_active', '=', 1]
                ]
            ],
            'order' => [
                ['a.rank', 'asc']
            ],
            'query_param' => config('app.url') . $request->getRequestUri()
        ];
        $groups = $this->MY_Model->find($request, 'all', $param_groups);
        return view('Public_html.Layouts.Adminlte.dashboard', compact('title_for_layout', '_breadcrumbs', '_config', 'modules', 'groups'));
    }

    public function get_list(Request $request) {
        if (isset($request) && !empty($request)) {
            if (isset($request['a']) && !empty($request['a'])) {
                switch ($request['a']) {
                    case 1:
                        return $this->get_list_all($request);
                        break;
                    case 2:
                        return $this->get_menu_single($request);
                        break;
                    case 3 :
                        return $this->get_menu_by_level($request);
                        break;
                    case 4 :
                        return $this->get_menu_by_child($request);
                        break;
                }
            } else {
                $this->get_list_default($request);
            }
        } else {
            return json_encode(array());
        }
    }

    public function get_list_default($request) {
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
                    ['a.content_path', 'like', '%' . $search . '%'],
                    ['a.level', 'like', '%' . $search . '%'],
                    ['a.rank', 'like', '%' . $search . '%']
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
                $is_badge = '';
                if ($value->is_badge == 1) {
                    $is_badge = ' checked';
                }
                $is_open = '';
                if ($value->is_open == 1) {
                    $is_open = ' checked';
                }
                $is_active = '';
                if ($value->is_active == 1) {
                    $is_active = ' checked';
                }
                $is_allowed = '';
                if ($value->is_allowed == 1) {
                    $is_allowed = ' checked';
                }
                $arrData[] = [
                    'id' => $i,
                    'name' => $value->title,
                    'icon' => $value->icon,
                    'user_id' => $value->user_id,
                    'badge' => $value->badge,
                    'badge_value' => $value->badge_value,
                    'path' => $value->path,
                    'level' => $value->level,
                    'rank' => $value->rank,
                    'is_badge' => '<input type="checkbox"' . $is_badge . ' name="check" value="is_badge" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                    'is_open' => '<input type="checkbox"' . $is_open . ' name="check" value="is_open" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                    'is_active' => '<input type="checkbox"' . $is_active . ' name="check" value="is_active" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                    'is_allowed' => '<input type="checkbox"' . $is_allowed . ' name="check" value="is_allowed" data-id="' . $value->id . '" class="make-switch" data-size="small">',
                    'group_name' => $value->group_name,
                    'module_name' => $value->module_name,
                    'action' => '<div class="btn-group">
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/menu/remove/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Add"><i class="fas fa-plus-circle"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/menu/delete/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Edit"><i class="fas fa-edit"></i></a></button>
                        <button type="button" class="btn btn-info"><a href="' . config('app.base_extraweb_uri') . '/menu/edit/' . base64_encode($value->id) . '" style="color:#fff;font-size:14px;" title="Remove"><i class="far fa-trash-alt"></i></a></button>
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

    public function get_menu_single($request) {
        $menu = [];
        if ($request->id) {
            $menu = Tbl_a_menus::get_menu_by_id($request->id, 1, 0);
        }
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $menu]);
    }

    public function get_menu_by_level($request) {
        $menu = [];
        $strMenu = [];
        if ($request->level) {
            $i = $request->level;
            $menu = Tbl_a_menus::get_menu_by_level($request->id);
            $strMenu = '';
            if (isset($menu) && !empty($menu)) {
                $j = ($i + 1);
                $strMenu .= '<div class="form-group row">'
                        . '<label class="col-sm-2 control-label">Menu level ' . $j . '</label>
                                <div class="col-sm-10"><select class="form-control menu_child" onChange="return fnSelectMenuAfter(this, ' . $request->id . ')" id="menu_child' . $j . '" name="menu_child[]" data-level="' . $j . '" >';
                $strMenu .= '<option value="0">-- select one --</option>';
                foreach ($menu AS $key => $value) {
                    $parent_name = 'root';
                    if ($value->parent_name != '')
                        $parent_name = $value->parent_name;
                    $strMenu .= '<option value="' . $value->id . '">' . $parent_name . ' -- ' . $value->name . '</option>';
                }
                $strMenu .= '</select></div></div>';
            }
        }
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $strMenu]);
    }

    public function get_list_all($request) {
        $menu = [];
        if ($request->group_id) {
            $menu_1 = Tbl_a_menus::get_menus($request->group_id, 1, 0);
            if ($menu_1) {
                foreach ($menu_1 AS $keyword => $value) {
                    $menu_2 = Tbl_a_menus::get_menus($request->group_id, ($value->level + 1), $value->id);
                    $arr_menu_2 = [];
                    if ($menu_2) {
                        foreach ($menu_2 AS $key => $val) {
                            $menu_3 = Tbl_a_menus::get_menus($request->group_id, ($val->level + 1), $val->id);
                            $arr_menu_3 = [];
                            if ($menu_3) {
                                foreach ($menu_3 AS $ky => $vl) {
                                    $menu_4 = Tbl_a_menus::get_menus($request->group_id, ($vl->level + 1), $vl->id);
                                    $arr_menu_4 = [];
                                    if ($menu_4) {
                                        foreach ($menu_4 AS $k => $v) {
                                            $menu_5 = Tbl_a_menus::get_menus($request->group_id, ($v->level + 1), $v->id);
                                            $arr_menu_5 = [];
                                            if ($menu_5) {
                                                foreach ($menu_5 AS $j => $w) {
                                                    $arr_menu_5[] = [
                                                        "id" => $w->id,
                                                        "parent" => $w->parent_id,
                                                        "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="4"  data-id="' . $w->id . '">' . $w->name . '</button>',
                                                        "icon" => $w->icon
                                                    ];
                                                }
                                            }
                                            $arr_menu_4[] = [
                                                "id" => $v->id,
                                                "parent" => $v->parent_id,
                                                "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="4"  data-id="' . $v->id . '">' . $v->name . '</button>',
                                                "icon" => $v->icon,
                                                "children" => $arr_menu_5
                                            ];
                                        }
                                    }
                                    $arr_menu_3[] = [
                                        "id" => $vl->id,
                                        "parent" => $vl->parent_id,
                                        "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="3"  data-id="' . $vl->id . '">' . $vl->name . '</button>',
                                        "icon" => $vl->icon,
                                        "children" => $arr_menu_4
                                    ];
                                }
                            }
                            $arr_menu_2[] = [
                                "id" => $val->id,
                                "parent" => $val->parent_id,
                                "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="2"  data-id="' . $val->id . '">' . $val->name . '</button>',
                                "icon" => $val->icon,
                                "children" => $arr_menu_3
                            ];
                        }
                    }
                    $menu[] = [
                        "id" => $value->id,
                        "parent" => $value->parent_id,
                        "text" => '<button type="button" style="background-color: transparent;border: none;" data-toggle="modal" data-target="#modal_edit_node" data-level="1" data-id="' . $value->id . '">' . $value->name . '</button>',
                        "icon" => $value->icon,
                        "children" => $arr_menu_2
                    ];
                }
            }
        }
        $root_menu = [
            "id" => "root",
            "text" => "root",
            "icon" => "",
            "children" => $menu
        ];
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $root_menu]);
    }

    public function get_menu_by_child($request) {
        $menu = [];
        if ($request->parent_id) {
            $menu = Tbl_a_menus::get_menu_by_parent_id($request->module_id, $request->level, $request->parent_id);
        }
        $strMenu = '';
        $strMenu .= '<div class="form-group row"><label class="col-sm-2 control-label">Menu Parent level ' . $request->level . '</label>
                        <select class="form-control col-sm-9" id="menu' . $request->level . '" name="menu' . $request->level . '" data-level="' . $request->level . '" style="width: 100%; margin-left:8px" onchange="fnSelectMenu(' . $request->parent_id . ',' . $request->level . ',' . $request->module_id . ')">';
        $strMenu .= '<option value="0">-- select one --</option>';
        foreach ($menu AS $key => $value) {
            $strMenu .= '<option value="' . $value->id . '">Title : ' . $value->title . ' | ID : ' . $value->id . ', Parent ID | ' . $value->parent_id . '</option>';
        }
        $strMenu .= '</select></div>';
        return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully fetching menu data.', 'valid' => true, 'data' => $menu]);
    }

    public function insert(Request $request) {
        $data = $request->json()->all();
        $response = false;
        if (isset($data) && !empty($data)) {
            if (isset($data['child_menu']) && !empty($data['child_menu'])) {
                $parent_menu_id = 0;
                foreach ($data['child_menu'] AS $key => $value) {
                    $parent_menu_id = $value;
                }
            }
            $parent_menus = Tbl_a_menus::get_by_id($parent_menu_id);
            $level = 1;
            if ($parent_menus) {
                $level = ((int) $parent_menus->level + 1);
            }
            $param = [
                'name' => $data['name'],
                'path' => $data['path'],
                'content_path' => isset($data['content_path']) ? $data['content_path'] : "-",
                'icon' => isset($data['icon']) ? $data['icon'] : '-',
                'level' => isset($level) ? $level : 1,
                'rank' => isset($data['rank']) ? $data['rank'] : 1,
                'is_badge' => $data['is_badge'],
                'badge' => isset($data['badge']) ? $data['badge'] : "",
                'badge_id' => isset($data['badge_id']) ? $data['badge_id'] : "",
                'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                'parent_id' => isset($parent_menu_id) ? (int) $parent_menu_id : 0,
                'is_basic' => isset($data['is_basic']) ? $data['is_basic'] : 0,
                'is_open' => isset($data['is_open']) ? $data['is_open'] : 0,
                'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                'created_by' => $this->__user_id,
                'created_date' => MyHelper::getDateNow(),
                'updated_by' => $this->__user_id,
                'updated_date' => MyHelper::getDateNow()
            ];
            $menu_id = DB::table('tbl_a_user_menus')->insertGetId($param);
            if ($menu_id) {
                $param2 = [
                    'menu_id' => $menu_id,
                    'group_id' => $this->__group_id,
                    'module_id' => $data['module_id'],
                    'is_allowed' => 1,
                    'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                    'created_by' => $this->__user_id,
                    'created_date' => MyHelper::getDateNow(),
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                $response = DB::table('tbl_b_menu_permission')->insert($param2);
            }
            if ($response) {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update modules', 'valid' => true]);
            } else {
                return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update modules.', 'valid' => false]);
            }
        }
    }

    public function update(Request $request, $tr_id = null) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            $id = base64_decode($tr_id);
            if (isset($request->a) && !empty($request->a)) {
                switch ($request->a) {
                    case 1 :
                        return $this->update_menu($request, $id);
                        break;
                }
            } else {
                switch ($data['action']) {
                    case 'is_active':
                        $update_data = [
                            'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                            'updated_by' => $this->__user_id,
                            'updated_date' => MyHelper::getDateNow()
                        ];
                        break;
                    default:
                        if (isset($data['child_menu']) && !empty($data['child_menu'])) {
                            $parent_menu_id = 0;
                            foreach ($data['child_menu'] AS $key => $value) {
                                $parent_menu_id = $value;
                            }
                        }
                        $parent_menus = Tbl_a_menus::get_by_id($parent_menu_id);
                        $level = 1;
                        if ($parent_menus) {
                            $level = ((int) $parent_menus->level + 1);
                        }
                        $update_data = [
                            'name' => $data['name'],
                            'path' => $data['path'],
                            'content_path' => isset($data['content_path']) ? $data['content_path'] : "-",
                            'icon' => isset($data['icon']) ? $data['icon'] : '-',
                            'level' => isset($level) ? $level : 1,
                            'rank' => isset($data['rank']) ? $data['rank'] : 1,
                            'is_badge' => $data['is_badge'],
                            'badge' => isset($data['badge']) ? $data['badge'] : "",
                            'badge_id' => isset($data['badge_id']) ? $data['badge_id'] : "",
                            'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                            'parent_id' => isset($parent_menu_id) ? (int) $parent_menu_id : 0,
                            'is_basic' => isset($data['is_basic']) ? $data['is_basic'] : 0,
                            'is_open' => isset($data['is_open']) ? $data['is_open'] : 0,
                            'is_active' => isset($data['is_active']) ? $data['is_active'] : 0,
                            'updated_by' => $this->__user_id,
                            'updated_date' => MyHelper::getDateNow(),
                        ];
                        break;
                }
                $response = DB::table('tbl_a_user_menus')->where('id', '=', (int) $id)->update($update_data);
                if ($response) {
                    $param2 = [
                        'user_id' => isset($data->user_id,) ? $data->user_id : 0,
                        'is_allowed' => isset($data->is_open) ? $data->is_open : 0,
                        'is_active' => isset($data->is_active) ? $data->is_active : 0,
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    DB::table('tbl_a_user_menu_access')->insert($param2);
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update modules', 'valid' => true]);
                } else {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update modules.', 'valid' => false]);
                }
            }
        }
    }

    public function update_menu(Request $request, $id) {
        $data = $request->json()->all();
        if (isset($data) && !empty($data)) {
            if (isset($data['is_delete']) && !empty($data['is_delete'])) {
                $response = DB::table('tbl_a_menus')->where('id', '=', $id)->delete();
                if ($response) {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully delete data.', 'valid' => true]);
                } else {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed delete data.', 'valid' => false]);
                }
            } elseif (isset($data['is_move']) && !empty($data['is_move'])) {
                $exist_menu = DB::table('tbl_a_menus AS a')->select('*')->where('a.id', '=', $id)->first();
                $rank = (int) $data['new_position'] + 1;
                $level = $exist_menu->level;
                $new_parent_id = 0;
                if (isset($data['new_parent']) && $data['new_parent'] != 'root') {
                    $new_parent_id = $data['new_parent'];
                    $new_parent_menu = DB::table('tbl_a_menus AS a')->select('*')->where('a.id', '=', $new_parent_id)->first();
                    $rank = (int) $data['new_position'] + 1;
                    $level = $new_parent_menu->level + 1;
                } else {
                    $level = $exist_menu->level - 1;
                }
                $param = [
                    'level' => isset($level) ? (int) $level : 1,
                    'rank' => isset($rank) ? (int) $rank : 1,
                    'parent_id' => isset($new_parent_id) ? (int) $new_parent_id : 0,
                    'updated_by' => $this->__user_id,
                    'updated_date' => MyHelper::getDateNow()
                ];
                $response = DB::table('tbl_a_menus')->where('id', '=', (int) $id)->update($param);
                if ($response) {
                    $all_menu = DB::table('tbl_a_menus AS a')->select('*')->where([['a.parent_id', '=', $new_parent_id], ['a.rank', '>=', $rank], ['a.id', '!=', $id]])->orderBy('a.rank', 'ASC')->get();
                    $total_menu = count($all_menu);
                    if ($all_menu) {
                        $arr_new_menu = [];
                        $i = $rank;
                        foreach ($all_menu AS $k => $v) {
                            $i++;
                            $arr_new_menu = [
                                'id' => $v->id,
                                'rank' => $i,
                                'updated_by' => $this->__user_id,
                                'updated_date' => MyHelper::getDateNow()
                            ];
                            DB::table('tbl_a_menus')->where('id', '=', (int) $v->id)->update($arr_new_menu);
                        }
                    }
                }
                if ($response) {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update menu.', 'valid' => true]);
                } else {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update menu.', 'valid' => false]);
                }
            } else {
                if ($data['parent'] && $data['parent'] == 'root') {
                    $parent_id = 0;
                    $level = 1;
                    $exist_all = DB::table('tbl_a_menus AS a')->select('*')->where('a.level', '=', $level)->where('a.parent_id', '=', $parent_id)->get();
                    $total_exist = count($exist_all);
                    $rank = $total_exist + 1;
                } else {
                    $parent_id = (int) $data['parent'];
                    $parent = DB::table('tbl_a_menus AS a')->select('*')->where('a.id', '=', $parent_id)->first();
                    $members = DB::table('tbl_a_menus AS a')->select('*')->where('a.parent_id', '=', $parent_id)->get();
                    if ($data['is_insert'] == true) {
                        $total_member = count($members);
                        $level = (int) $parent->level + 1;
                        if ($total_member > 0) {
                            $i = $total_member - 1;
                            $rank = (int) $total_member + 1;
                        } else {
                            $rank = 1;
                        }
                    }
                }
                if ($data['is_insert'] == true) {
                    $param = [
                        'name' => (string) $data['value'],
                        'icon' => '',
                        'path' => '',
                        'content_path' => '',
                        'level' => $level,
                        'rank' => $rank,
                        'parent_id' => $parent_id,
                        'is_badge' => 0,
                        'badge' => isset($data['badge']) ? $data['badge'] : "",
                        'badge_id' => isset($data['badge_id']) ? $data['badge_id'] : "",
                        'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                        'is_basic' => 0,
                        'is_open' => 0,
                        'is_active' => 1,
                        'created_by' => $this->__user_id,
                        'created_date' => MyHelper::getDateNow(),
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow(),
                    ];
                    $menu_id = DB::table('tbl_a_menus')->insertGetId($param);
                    if ($menu_id) {
                        $param2 = [
                            'menu_id' => $menu_id,
                            'group_id' => $data['group_id'],
                            'module_id' => $data['module_id'],
                            'is_allowed' => 1,
                            'is_active' => 1,
                            'created_by' => $this->__user_id,
                            'created_date' => MyHelper::getDateNow(),
                            'updated_by' => $this->__user_id,
                            'updated_date' => MyHelper::getDateNow(),
                        ];
                        $response = DB::table('tbl_b_menu_permission')->insert($param2);
                    }
                } else {
                    $name = '';
                    if (isset($data['value'])) {
                        $name = $data['value'];
                    } elseif (isset($data['name'])) {
                        $name = $data['name'];
                    }
                    $param = [
                        'name' => isset($name) ? (string) $name : '',
                        'icon' => isset($data['icon']) ? $data['icon'] : '',
                        'path' => isset($data['path']) ? $data['path'] : '',
                        'content_path' => isset($data['content_path']) ? $data['content_path'] : '',
                        'level' => isset($data['level']) ? (int) $data['level'] : 1,
                        'rank' => isset($data['rank']) ? (int) $data['rank'] : 1,
                        'parent_id' => isset($data['parent']) ? (int) $data['parent'] : 0,
                        'is_badge' => isset($data['is_badge']) ? (int) $data['is_badge'] : 0,
                        'badge' => isset($data['badge']) ? $data['badge'] : "",
                        'badge_id' => isset($data['badge_id']) ? $data['badge_id'] : "",
                        'badge_value' => isset($data['badge_value']) ? $data['badge_value'] : "",
                        'is_basic' => isset($data['is_basic']) && $data['is_basic'] == true ? 1 : 0,
                        'is_open' => isset($data['is_open']) && $data['is_open'] == true ? 1 : 0,
                        'is_active' => isset($data['is_active']) && $data['is_active'] == true ? 1 : 0,
                        'updated_by' => $this->__user_id,
                        'updated_date' => MyHelper::getDateNow()
                    ];
                    $response = DB::table('tbl_a_menus')->where('id', '=', (int) $id)->update($param);
                }
                if ($response) {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'successfully update menu.', 'valid' => true]);
                } else {
                    return MyHelper::_set_response('json', ['code' => 200, 'message' => 'failed update menu.', 'valid' => false]);
                }
            }
        }
    }

}
